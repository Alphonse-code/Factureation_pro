<?php

namespace App\Controller;

use DateTime;
use Swift_Mailer;
use Dompdf\Dompdf;
use Swift_Message;
use Dompdf\Options;
use Swift_Transport;
use App\Entity\Client;
use App\Entity\Facture;
use App\Entity\LigneFacture;
use Swift_TransportException;
use Swift_Plugins_LoggerPlugin;
use Swift_Plugins_MessageLogger;
use App\Repository\TvaRepository;
use Symfony\Component\Mime\Email;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Repository\ProduitRepository;
use Swift_Plugins_Loggers_ArrayLogger;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\SplFileInfo;
use App\Repository\LigneFactureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ang3\Component\Serializer\Encoder\ExcelEncoder;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

/**
 * @Route("/facture")
 */
class InvoiceController extends AbstractController
{
    private $clientRepository;
    private $factureRepository;
    private $lignesFacture;
    public  function __construct(LigneFactureRepository $lignesFacture, ClientRepository $clientRepository, FactureRepository $factureRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->factureRepository = $factureRepository;
        $this->lignesFacture = $lignesFacture;
    }
    /**
     * @Route("/", name="invoice", options={"expose"=true})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $lignesFactureSupprime = $this->lignesFacture->findBy(["facture" => 4]);
        //dd($lignesFactureSupprime);
        //$facture = $this->factureRepository->findInvoiceByUser("F", $user);
        $invoices = $this->factureRepository->findAllByUser($user);
        // dd($invoices);
        $pagination = $paginator->paginate(
            $invoices,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        $totalFactures = $this->factureRepository->getTotalFacture($user);
        //dd($facture);
        return $this->render('invoice/index.html.twig', [
            'invoices' => $pagination,
            'total' => $totalFactures,
            'bruillon' => $this->factureRepository->getTotalFactureBruillon($user),
            'envoyer' => $this->factureRepository->getTotalFactureEnvoyer($user),
            'payer' => $this->factureRepository->getTotalFacturePaye($user),
        ]);
    }
    /**
     * @Route("/factures", name="factures" , options={"expose"=true})
     */
    public function ajaxGetFactures()
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $invoices = $this->factureRepository->findAllByUser($user);
        $response = $this->json($invoices, 200, ["Content-Type" => "appication/json"], ['groups' => 'invoice:read']);
        return $response;
    }

    private function calclulNum($user)
    {
        $lastid = $this->factureRepository->findOneBy(["user" => $user], ['id' => 'desc']);
        if (is_null($lastid)) {
            $lastnum = 1;
            $num = str_pad($lastnum, 7, "0", STR_PAD_LEFT);
            return $num;
        } else {
            $numlast = $lastid->getNum();
            $numlast++;
            $num = str_pad($numlast, 7, "0", STR_PAD_LEFT);
            return $num;
        }
    }
    /**
     * @Route("/nouvelle", name="nouvelle_facture", options={"expose"=true})
     */
    public function nouvelleFacture(FactureRepository $factureRepository): Response
    {
        $user = $this->getUser();
        $num = $this->calclulNum($user);
        return $this->render('invoice/createinvoice.html.twig', [
            'controller_name' => 'InvoiceController',
            'num' => $num
        ]);
    }

    /**
     * @Route("/lignes/{id}", name="ligne_facture", options={"expose"=true})
     */
    public function ligneFacture($id): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $user = $this->getUser();
        $items = $this->factureRepository->recentFacture($user);
        //dd($items);
        $dataInvoice = $this->factureRepository->getDataInvoice($id, $user);
        //dd($dataInvoice->getClent()->getId());
        $clientFacture = $this->factureRepository->getFactureClient($dataInvoice->getClent()->getId(), $user);
        $sumTTC = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumTTC += $var->getTotalTTC();
        }
        $sumHT = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumHT += $var->getTotalHT();
        }
        $sumTVA = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumTVA += $var->getTotalTVA();
        }
        $sumRemise = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumRemise += $var->getTotalRemise();
        }

        return $this->render('invoice/detail.html.twig', [
            'data' => $dataInvoice,
            'factureClient' => $clientFacture
        ]);
    }

    /**
     * 
     * @Route("/v2Client", name="V2_ajoutClient", methods={"POST"}, options={"expose"=true})
     */
    public function V2Client(Request $request, EntityManagerInterface $entityManager)
    {
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $nom = $request->get("nom");
            $adresse = $request->get("adresse");
            $prenom = $request->get("prenom");
            $email = $request->get("email");
            $numRue = $request->get("numRue");
            $nomRue = $request->get("nomRue");
            $codePostal = $request->get("codePostal");
            $ville = $request->get("ville");
            $fixe = $request->get("fixe");
            $pays = $request->get("pays");
            $portable1 = $request->get("portable1");
            $portable2 = $request->get("portable2");
            $condition = $request->get("condition");
            $nomSociete = $request->get("nomSociete");
            $numSerie = $request->get("numSerie");
            $titreSociete = $request->get("titreSociete");
            $client = new Client;
            $client->setUser($user);
            $client->setNomClient($nom);
            $client->setPrenomClient($prenom);
            $client->setTel($portable1);
            $client->setTel2($portable2);
            $client->setEmail($email);
            $client->setNomRueClient($nomRue);
            $client->setNumRueClient($numRue);
            $client->setVilleClient($ville);
            $client->setCodePostalClient($codePostal);
            $client->setCoditionDePaiement($condition);
            $client->setFixe($fixe);
            $client->setPaysClient($pays);
            $client->setNomSociete($nomSociete);
            $client->setTitreEntrepriseClient($titreSociete);
            $client->setNumeroDeSerieClient($numSerie);
            $client->setAdresseFactureClient($adresse);
            $entityManager->persist($client);
            $entityManager->flush();
            // $facture = $this->factureRepository->findInvoiceByUser($ref, $user);
            $response = $this->json($nom, 200, ["Content-Type" => "appication/json"]);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * 
     * @Route("/recherche", name="searche_invoice", methods={"POST"}, options={"expose"=true})
     */
    public function rechercheFacture(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $ref = $request->get("key");
            $facture = $this->factureRepository->findInvoiceByUser($ref, $user);
            $response = $this->json($facture, 200, ["Content-Type" => "appication/json"], ['groups' => 'invoice:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * @Route("/creer", name="new_invoice", options={"expose"=true})
     */
    public function nouveauFacture(FactureRepository $factureRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $user = $this->getUser();
        $num = $this->calclulNum($user);
        return $this->render('invoice/newinvoice.html.twig', [
            'num' => $num
        ]);
    }
    /**
     * @Route("/file/invoice", name= "file_invoice", options={"expose"=true})
     */

    public function importInvoiceFile(Request $request, FactureRepository $factureRepository)
    {

        $user = $this->getUser();
        $file = $request->files->get('file-facture');
        $fileFolder = __DIR__ . '/../../public/uploads/';  //choose the folder in which the uploaded file will be stored
        $filePathName = md5(uniqid()) . $file->getClientOriginalName();

        // apply md5 function to generate an unique identifier for the file and concat it with the file extension
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            dd($e);
        }
        //$test= fopen($fileFolder.$filePathName, 'r');
        $filedata = $fileFolder . $filePathName;
        $fileExtension = pathinfo($filedata, PATHINFO_EXTENSION);
        $fileContent = file_get_contents($filedata);
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new XmlEncoder(), new JsonEncoder(), new CsvEncoder];
        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->decode($fileContent, $fileExtension);
        $entityManager = $this->getDoctrine()->getManager();
        $dataArranger = [];
        for ($i = 0; $i < count($data); $i++) {
            $produits = [
                "num" => $data[$i]["NUMERO"],
                "nomProduit" => $data[$i]["NOM_PRODUIT"],
                "TVA" => $data[$i]["TVA"],
                "QT" => $data[$i]["QUANTITE_PRODUIT"],
                "PU" => $data[$i]["PRIX_UNIT"],
                "REMISE" => $data[$i]["REMISE"]
            ];
            $infosFacture = [
                "num" => $data[$i]["NUMERO"],
                "client" => $data[$i]["REF_CLIENT"],
                "termDePaiement" => $data[$i]["TERME_DE_PAIEMENT"],
                "dateDeFacture" => $data[$i]["DATE_DE_FACTURE"],
                "prefixe" => $data[$i]["PREFIXE"],
                "produits" => [$produits]
            ];

            if ($i != 0 && ($produits['num'] == end($dataArranger)['num'])) {
                array_push($dataArranger[count($dataArranger) - 1]['produits'], $produits);
            } else {
                array_push($dataArranger, $infosFacture);
            }
        }
        // recuperer la dernier numéro

        for ($i = 0; $i < count($dataArranger); $i++) {
            $lastid = $factureRepository->findOneBy([], ['id' => 'desc']);
            if (is_null($lastid)) {
                $lastnum = 1;
                $num = str_pad($lastnum, 6, "0", STR_PAD_LEFT);
            } else {
                $num = $lastid->getNum();
                $num++;
                $numero = str_pad($num, 6, "0", STR_PAD_LEFT);
            }
            //dd($numero);
            //dd($ref);
            //verifie client
            $cli = $this->clientRepository->findOneBy(["ref" => $dataArranger[$i]["client"]]);
            if ($cli) {
                $idClient = $cli->getId();
            } else {
                $newClient = new Client();
                $newClient->setUser($user);
                $newClient->setRef($dataArranger[$i]["client"]);
                $entityManager->persist($newClient);
                $entityManager->flush();
                $idClient = $newClient->getId();
            }
            // nouvelle facture
            $newFacture = new Facture();
            $prefixe = $dataArranger[$i]["prefixe"];
            $ref = $prefixe . "-" . $numero;
            $client = $idClient;
            $termDePaiement = $dataArranger[$i]["termDePaiement"];
            $dateDeFacture = $dataArranger[$i]["dateDeFacture"];
            // calcule date d'echeance
            $dateEcheance = new DateTime($dateDeFacture);
            $echeance = $dateEcheance->modify('+' . $termDePaiement . ' day')->format('Y-m-d');
            // ligne produit
            $newFacture->setUser($user);
            $newFacture->setRef($ref);
            $newFacture->setNum($numero);
            $newFacture->setDate($dateDeFacture);
            $newFacture->setEtat("1");
            $newFacture->setEcheance($echeance);
            $cli = $this->clientRepository->findOneBy(["id" => $client]);
            $newFacture->setClent($cli);
            $newFacture->setConditionDePayment($termDePaiement);
            $entityManager->persist($newFacture);
            $entityManager->flush();
            $idFact = $newFacture->getId();
            $lignePoduit = $dataArranger[$i]["produits"];
            for ($y = 0; $y < count($lignePoduit); $y++) {
                $lignesFacture = new LigneFacture();
                $lignesFacture->setPu($lignePoduit[$y]["PU"]);
                $lignesFacture->setQt($lignePoduit[$y]["QT"]);
                $ht = $lignePoduit[$y]["QT"] * $lignePoduit[$y]["PU"];
                $lignesFacture->setTotalHT($ht);
                $ttva = $ht * $lignePoduit[$y]["TVA"] / 100;
                // si remise > 0
                if ($lignePoduit[$y]["REMISE"] > 0) {
                    $tremise = $ht * $lignePoduit[$y]["REMISE"] / 100;
                    $ttc_sans_remise = $ht + $ttva;
                    $ttc = $ttc_sans_remise - $tremise;
                } else {
                    $tremise = 0;
                    $ttc = $ht + $ttva;
                }
                $f = $this->factureRepository->findOneBy(["id" => $idFact]);
                $lignesFacture->setFacture($f);
                $lignesFacture->setRemise($lignePoduit[$y]["REMISE"]);
                $lignesFacture->setTotalRemise($tremise);
                $lignesFacture->setTotalTTC($ttc);
                $lignesFacture->setTotalTVA($ttva);
                $lignesFacture->setDesignation($lignePoduit[$y]["nomProduit"]);
                $lignesFacture->setTva($lignePoduit[$y]["TVA"]);
                $entityManager->persist($lignesFacture);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('invoice');


        // dd($dataArranger);

    }
    /**
     * @Route("/aperçu/{id}", name="aperçu_facture", methods={"GET"}, options={"expose"=true}) 
     */

    public function aperçuFacture($id)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $user = $this->getUser();
        $items = $this->factureRepository->recentFacture($user);
        //dd($items);
        $dataInvoice = $this->factureRepository->getDataInvoice($id, $user);
        $sumTTC = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumTTC += $var->getTotalTTC();
        }
        $sumHT = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumHT += $var->getTotalHT();
        }
        $sumTVA = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumTVA += $var->getTotalTVA();
        }
        $sumRemise = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumRemise += $var->getTotalRemise();
        }
        //dd($dataInvoice);
        return $this->render('invoice/invoice.html.twig', [
            'dataInvoice' => $dataInvoice,
            'items' => $items,
            'totalHT' => $sumHT,
            'totalTTC' => $sumTTC,
            'totalTVA' => $sumTVA,
            'totalRemise' => $sumRemise
        ]);
    }

    /**
     * @Route("/delete", name="supprimer_facture", methods={"DELETE"}, options={"expose"=true}) 
     */
    public function deleteInvoice(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXMLHttpRequest()) {
            $ref = $request->get("id");
            $facture = $this->factureRepository->findOneBy(["id" => $ref]);
            $entityManager->remove($facture);
            $entityManager->flush();
            $response = $this->json(["status" => "success", "message" => "facture bien supprimer"], 200, []);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * @Route("/edit/{id}", name="edit_facture", methods={"GET"}, options={"expose"=true}) 
     */
    public function updateInvoice($id)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $facture = $this->factureRepository->findOneBy(["id" => $id]);
        return $this->render('invoice/editInvoice.html.twig', ["facture" => $facture]);
    }
    /**
     * recupérer tous les poduits to select
     * @Route("/nouveau", name="bruillon", methods={"POST"}, options={"expose"=true})
     */
    public function addLineInvoice(Request $request, FactureRepository $factureRepository, ProduitRepository $produitRepository)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            //génerer num facture
            //GET last ref
            if ($user) {
                $lastid = $factureRepository->findOneBy([], ['id' => 'desc']);
                if (is_null($lastid)) {
                    $lastnum = 1;
                    $num = str_pad($lastnum, 7, "0", STR_PAD_LEFT);
                } else {
                    $num = $lastid->getRef();
                    $num++;
                    $ref = str_pad($num, 7, "0", STR_PAD_LEFT);
                }
                //recupérer les données du facture
                $client = $request->get("clientid");
                $cli = $this->clientRepository->findOneBy(["id" => $client]);
                $prefixe = $request->get("prefixe");
                $date = $request->get("date");
                $condition = $request->get("condition");
                $num = $request->get("num");
                $ref = $prefixe . "-" . $num;
                $note = $request->get("note");
                $dateEcheance = $request->get("echeance");
                $facture = new Facture();
                $facture->setUser($user);
                $facture->setRef($ref);
                $facture->setNum($num);
                $facture->setDate($date);
                $facture->setNote($note);
                $facture->setClent($cli);
                $facture->setEcheance($dateEcheance);
                $facture->setEtat("0");
                $facture->setConditionDePayment($condition);
                $refProduit = $request->get('ref');
                $qty = $request->get('qt');
                $pu = $request->get('prixUnit');
                $remise = $request->get('remise');
                $produit = $request->get('produit');
                $tva = $request->get('tva');
                $sumref = sizeof($request->get("ref"));
                for ($i = 0; $i < $sumref; $i++) {
                    $lineInvoice = new LigneFacture();
                    $lineInvoice->setPu($pu[$i]);
                    $lineInvoice->setQt($qty[$i]);
                    $ht = $qty[$i] * $pu[$i];
                    $lineInvoice->setTotalHT($ht);
                    $ttva = $ht * $tva[$i] / 100;
                    // si remise > 0
                    if ($remise[$i] > 0) {
                        $tremise = $ht * $remise[$i] / 100;
                        $ttc_sans_remise = $ht + $ttva;
                        $ttc = $ttc_sans_remise - $tremise;
                    } else {
                        $tremise = 0;
                        $ttc = $ht + $ttva;
                    }
                    $lineInvoice->setRemise($remise[$i]);
                    $lineInvoice->setRefProduit($refProduit[$i]);
                    $lineInvoice->setTotalRemise($tremise);
                    $lineInvoice->setTotalTTC($ttc);
                    $lineInvoice->setTotalTVA($ttva);
                    $lineInvoice->setDesignation($produit[$i]);
                    $lineInvoice->setTva($tva[$i]);
                    $facture->addLigneFacture($lineInvoice);
                    $entityManager->persist($facture);
                    $entityManager->flush();
                }
                $response = $this->json(["status" => "success", "message" => "Facture en bruillon"], 200, []);
                return $response;
            }
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * recupérer tous les poduits to select
     * @Route("/enregistrer", name="enregister_facture", methods={"POST"}, options={"expose"=true})
     */
    public function saveInvoice(Request $request, FactureRepository $factureRepository, ProduitRepository $produitRepository)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            //génerer num facture
            //GET last ref
            if ($user) {
                $lastid = $factureRepository->findOneBy([], ['id' => 'desc']);
                if (is_null($lastid)) {
                    $lastnum = 1;
                    $num = str_pad($lastnum, 7, "0", STR_PAD_LEFT);
                } else {
                    $num = $lastid->getRef();
                    $num++;
                    $ref = str_pad($num, 7, "0", STR_PAD_LEFT);
                }
                //recupérer les données du facture
                $client = $request->get("clientid");
                $cli = $this->clientRepository->findOneBy(["id" => $client]);
                // $ref = $request->get("reference");
                $date = $request->get("date");
                $condition = $request->get("condition");
                $num = $request->get("num");
                $prefixe = $request->get("prefixe");
                $ref = $prefixe . "-" . $num;
                $note = $request->get("note");
                $dateEcheance = $request->get("echeance");

                $facture = new Facture();
                $facture->setUser($user);
                $facture->setRef($ref);
                $facture->setNum($num);
                $facture->setNote($note);
                $facture->setDate($date);
                $facture->setClent($cli);
                $facture->setEcheance($dateEcheance);
                $facture->setEtat("1");
                $facture->setConditionDePayment($condition);
                $refProduit = $request->get('ref');
                $qty = $request->get('qt');
                $pu = $request->get('prixUnit');
                $produit = $request->get('produit');
                $remise = $request->get('remise');
                $tva = $request->get('tva');
                $sumref = sizeof($request->get("ref"));
                for ($i = 0; $i < $sumref; $i++) {
                    $lineInvoice = new LigneFacture();
                    $lineInvoice->setPu($pu[$i]);
                    $lineInvoice->setRefProduit($refProduit[$i]);
                    $lineInvoice->setQt($qty[$i]);
                    $lineInvoice->setDesignation($produit[$i]);
                    $ht = $qty[$i] * $pu[$i];
                    $lineInvoice->setTotalHT($ht);
                    $ttva = $ht * $tva[$i] / 100;
                    // si remise > 0
                    if ($remise[$i] > 0) {
                        $tremise = $ht * $remise[$i] / 100;
                        $ttc_sans_remise = $ht + $ttva;
                        $ttc = $ttc_sans_remise - $tremise;
                    } else {
                        $tremise = 0;
                        $ttc = $ht + $ttva;
                    }
                    $lineInvoice->setRemise($remise[$i]);
                    $lineInvoice->setTotalRemise($tremise);
                    $lineInvoice->setTotalTTC($ttc);
                    $lineInvoice->setTotalTVA($ttva);
                    $prod = $produitRepository->findOneBy(["id" => $produit[$i]]);
                    // $lineInvoice->setProduit($prod);
                    $lineInvoice->setTva($tva[$i]);
                    $facture->addLigneFacture($lineInvoice);
                    $entityManager->persist($facture);
                    $entityManager->flush();
                }
                $response = $this->json(["status" => "succes", "message" => "Création facture avec success"], 200, []);
                return $response;
            }
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * edit facture
     * @Route("/edit", name="edit", methods={"POST"}, options={"expose"=true})
     */
    public function editFacture(Request $request, FactureRepository $factureRepository, ProduitRepository $produitRepository)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXMLHttpRequest()) {
            //génerer num facture
            //GET last ref
            if ($user) {
                $lastid = $factureRepository->findOneBy([], ['id' => 'desc']);
                if (is_null($lastid)) {
                    $lastnum = 1;
                    $num = str_pad($lastnum, 7, "0", STR_PAD_LEFT);
                } else {
                    $num = $lastid->getRef();
                    $num++;
                    $ref = str_pad($num, 7, "0", STR_PAD_LEFT);
                }
                //recupérer les données du facture
                $client = $request->get("idClient");
                $cli = $this->clientRepository->findOneBy(["id" => $client]);
                $ref = $request->get("reference");
                $date = $request->get("date");
                $condition = $request->get("conditionE");
                $num = $request->get("num");
                $dateEcheance = $request->get("echeance");
                // modifier facture
                $facture = $factureRepository->findOneBy(["num" => $num]);
                $facture->setUser($user);
                $facture->setRef($ref);
                $facture->setNum($num);
                $facture->setDate($date);
                $facture->setClent($cli);
                $facture->setEcheance($dateEcheance);
                $facture->setEtat("1");
                $facture->setConditionDePayment($condition);
                // get id facture
                $idFacture = $facture->getId();
                // on supprime les lignes des produits
                $lignesFactureSupprime = $this->lignesFacture->findBy(["facture" => $idFacture]);
                if ($lignesFactureSupprime) {
                    for ($i = 0; $i < count($lignesFactureSupprime); $i++) {
                        $entityManager->remove($lignesFactureSupprime[$i]);
                        $entityManager->flush();
                    }
                }
                $refProduit = $request->get('refE');
                $qty = $request->get('qtE');
                $pu = $request->get('prixUnitE');
                $produit = $request->get('produitE');
                $remise = $request->get('remiseE');
                $tva = $request->get('tvaE');
                $sumref = sizeof($request->get("refE"));
                for ($i = 0; $i < $sumref; $i++) {
                    $lineInvoice = new LigneFacture();
                    $lineInvoice->setPu($pu[$i]);
                    $lineInvoice->setQt($qty[$i]);
                    $ht = $qty[$i] * $pu[$i];
                    $lineInvoice->setTotalHT($ht);
                    $ttva = $ht * $tva[$i] / 100;
                    // si remise > 0
                    if ($remise[$i] > 0) {
                        $tremise = $ht * $remise[$i] / 100;
                        $ttc_sans_remise = $ht + $ttva;
                        $ttc = $ttc_sans_remise - $tremise;
                    } else {
                        $tremise = 0;
                        $ttc = $ht + $ttva;
                    }
                    $lineInvoice->setRemise($remise[$i]);
                    $lineInvoice->setRefProduit($refProduit[$i]);
                    $lineInvoice->setDesignation($produit[$i]);
                    $lineInvoice->setTotalRemise($tremise);
                    $lineInvoice->setTotalTTC($ttc);
                    $lineInvoice->setTotalTVA($ttva);
                    $prod = $produitRepository->findOneBy(["ref" => $produit[$i]]);
                    // $lineInvoice->setProduit($prod);
                    $lineInvoice->setTva($tva[$i]);
                    $facture->addLigneFacture($lineInvoice);
                    $entityManager->persist($facture);
                    $entityManager->flush();
                }
                $response = $this->json(["success" => "modification success!"], 200, []);
                return $response;
            }
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * 
     * @Route("/view", name="view_item", methods={"GET"}, options={"expose"=true})
     */
    public function viewItem(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $id = $request->get("id");
            $items = $this->factureRepository->findOneBy(['id' => $id]);
            $response = $this->json($items, 200, [], ['groups' => 'invoice:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }


    /**
     * recherche facture par date
     * @Route("/filtre", name="filter-date", methods={"GET"}, options={"expose"=true})
     */
    public function filterDate(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $date = $request->get("date");
            $date1 = $request->get("date1");
            $filterDate = $this->factureRepository->filterDate($date, $date1, $user);
            $response = $this->json($filterDate, 200, [], ['groups' => 'invoice:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * recherche facture par etat
     * @Route("/etat", name="filter-etat", methods={"GET"}, options={"expose"=true})
     */
    public function filterEtat(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $etat = $request->get("etat");
            $filterEtat = $this->factureRepository->filterEtat($etat, $user);
            $response = $this->json($filterEtat, 200, [], ['groups' => 'invoice:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * @Route("/email/{id}", name="invoice_envoyer", options={"expose"=true})
     */
    public function emailToClient($id, MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        $emailClient = $this->factureRepository->getDataInvoice($id, $user);

        // $email = (new Email())
        //     ->from('raphaelrandrianaivo1@gmail.com')
        //     ->to('raphael@gmail.com')
        //     //->cc('cc@example.com')
        //     //->bcc('bcc@example.com')
        //     //->replyTo('fabien@example.com')
        //     //->priority(Email::PRIORITY_HIGH)
        //     ->subject('Time for Symfony Mailer!')
        //     ->text('Sending emails is fun again!')
        //     ->html('<p>See Twig integration for better HTML integration!</p>');
        // try {
        //     $mailer->send($email);
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        // }

        // Create a message
        // dd($emailClient->getClent()->getEmail());
        // $message = (new Swift_Message('FACTURE ECAMSON'))
        //     ->setFrom('raphaelrandrianaivo1@gmail.com')
        //     ->setTo($emailClient->getClent()->getEmail())
        //     ->setBody('My <em>amazing</em> body', 'text/html');
        // // Send the message
        // try {
        //     $mailer->send($message);
        //     $facture = new Facture;
        //     $facture->setEtat("3");
        // } catch (Swift_TransportException $e) {
        //     echo $e->getMessage();
        // } catch (\Exception $e) {
        //     dd($e->getMessage());
        // }

        return $this->redirectToRoute("invoice");
    }
    /**
     * invoice print function
     * @Route("/print/{id}", name="print_invoice", options={"expose"=true})
     * @return void
     */
    public function printInvoice($id)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $user = $this->getUser();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', '12');
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->setIsHtml5ParserEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $dataInvoice = $this->factureRepository->getDataInvoice($id, $user);
        $sumTTC = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumTTC += $var->getTotalTTC();
        }
        $sumHT = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumHT += $var->getTotalHT();
        }
        $sumTVA = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumTVA += $var->getTotalTVA();
        }
        $sumRemise = 0;
        foreach ($dataInvoice->getLigneFacture() as $key => $var) {
            $sumRemise += $var->getTotalRemise();
        }
        //dd($dataInvoice);
        $dompdf->loadHtml($this->render('email/invoice.html.twig', [
            'dataInvoice' => $dataInvoice,
            'totalHT' => $sumHT,
            'totalTTC' => $sumTTC,
            'totalTVA' => $sumTVA,
            'totalRemise' => $sumRemise
        ])->getContent());
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont("helvetica", "bold");
        $canvas->page_text(
            500,
            770,
            "Page: {PAGE_NUM} / {PAGE_COUNT}",
            $font,
            6,
            array(0, 0, 0)
        );
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("facture.pdf", [
            "Attachment" => false
        ]);
    }
}