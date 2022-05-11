<?php

namespace App\Controller\Client;

use App\Entity\Client;
use App\Entity\UserInfos;
use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("client")
 */
class ClientController extends AbstractController
{
    private $manager;
    private $clientRepository;
    private $factureRepository;
    public function __construct(EntityManagerInterface $manager, ClientRepository $clientRepository, FactureRepository $factureRepository)
    {
        $this->manager = $manager;
        $this->clientRepository = $clientRepository;
        $this->factureRepository = $factureRepository;
    }
    /**
     * recupérer tous les clients
     * @Route("/list", name="mes_client", options={"expose"=true})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        $user = $this->getUser();
        //GET last ref
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $clients = $this->clientRepository->findAllByUser($user);
        $pagination = $paginator->paginate(
            $clients,
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        $total = $this->clientRepository->getTotalClients();
        return $this->render('client/index.html.twig', [
            'clients' => $pagination,
            'total' => $total
        ]);
    }
    private function client_num($input, $pad_len = 7, $prefix = null)
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
    /**
     * recupérer tous les clients to select
     * @Route("/lists", name="clients", methods={"POST"}, options={"expose"=true})
     */
    public function clients(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $nom = $request->get("nom");
            //$clients= $this->clientRepository->findAll();
            $clients = $this->clientRepository->getClientToSelect($nom);
            $response = $this->json($clients, 200, [], ['groups' => 'client:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * recupérer tous les clients to select
     * @Route("/clients", name="client_clients", methods={"GET"}, options={"expose"=true})
     */
    public function ClientsAjax(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $clients = $this->clientRepository->findAll();
            //$clients= $this->clientRepository->getClientToSelect($nom);
            $response = $this->json($clients, 200, [], ['groups' => 'client:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * recupérer tous les clients to select
     * @Route("/facture", name="client_facture", methods={"POST"}, options={"expose"=true})
     */
    public function infosClient(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $id = $request->get("id");
            $clients = $this->clientRepository->findBy(["id" => $id]);
            //$clients= $this->clientRepository->getClientToSelect($nom);
            $response = $this->json($clients, 200, [], ['groups' => 'client:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * @Route("/delete", name="supprimer_client", methods={"DELETE"}, options={"expose"=true}) 
     */
    public function deleteClient(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXMLHttpRequest()) {
            $ref = $request->get("id");
            for ($i = 0; $i < sizeof($ref); $i++) {
                $client = $this->clientRepository->findOneBy(["id" => $ref[$i]]);
                $clientFacture = $this->factureRepository->findOneBy(["clent" => $client]);
                // $response = $this->json($clientFacture, 200, []);
                //return $response;
                if ($clientFacture != null) {
                    $response = $this->json(['status' => 'error', 'message' => "Cette client ratcher à un facture"], 200, []);
                    return $response;
                } else {
                    $entityManager->remove($client);
                    $entityManager->flush();
                    $response = $this->json(['status' => 'success', 'message' => "Supression avec succès"], 200, []);
                    return $response;
                }
            }
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * recupérer tous les clients 
     * @Route("/recherche", name="filter-name", methods={"POST"}, options={"expose"=true})
     */
    public function rechercheClient(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $key = $request->get("key");
            //$clients= $this->clientRepository->findBy(["id"=>$key]);
            $clients = $this->clientRepository->getClientToSelect($key);
            $response = $this->json($clients, 200, ["Content-Type" => "appication/json"], ['groups' => 'client:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * 
     * @Route("/edit", name="client_edit", methods={"GET"}, options={"expose"=true})
     */
    public function editgetInfos(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        // $produits= $this->produitRepository->getProduitToSelect("pro");
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $id = $request->get("id");
            $clients = $this->clientRepository->findOneBy(['id' => $id]);
            $response = $this->json($clients, 200, [], ['groups' => 'client:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * 
     * @Route("/ajoutClient", name="ajoutClient", methods={"POST"}, options={"expose"=true})
     */
    public function ajoutClient(Request $request, EntityManagerInterface $entityManager)
    {
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            //GET last ref
            $lastid = $this->clientRepository->findOneBy(["user" => $user], ['id' => 'desc'],);
            if (is_null($lastid)) {
                $lastref = 1;
                $ref = $this->client_num($lastid, 6, "C");
            } else {
                $lastref = $lastid->getId();
                $lastref++;
                $ref = $this->client_num($lastref, 6, "C");
            }
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
            if ($nom === null) {
                $client->setNomClient($nomSociete);
            } else {
                $client->setNomClient($nom);
            }
            $client->setRef($ref);
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

            $client->setTitreEntrepriseClient($titreSociete);
            $client->setNumeroDeSerieClient($numSerie);
            $client->setAdresseFactureClient($adresse);
            $entityManager->persist($client);
            $entityManager->flush();
            // $facture = $this->factureRepository->findInvoiceByUser($ref, $user);
            $response = $this->json(['status' => 'success', 'message' => "Produit ajouté avec succès"], 200, ["Content-Type" => "appication/json"]);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * ajout client ajax
     * @Route("/edit", name="client_editAction", methods={"POST"}, options={"expose"=true})
     */
    public function ajaxEditClient(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
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
            $id = $request->get("id");
            $client = $this->clientRepository->findOneBy(["id" => $id]);
            $client->setUser($user);
            if ($nom === null) {
                $client->setNomClient($nomSociete);
            } else {
                $client->setNomClient($nom);
            }
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
            $this->manager->persist($client);
            $this->manager->flush();
            $response = $this->json(['status' => 'success', 'message' => "Modification client avec succès"], 200, ["Content-Type" => "appication/json"], ['groups' => 'client:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * modifier client
     * @Route("/edit/{cl}", name="edit_client", options={"expose"=true})
     *
     */
    public function editClient(Request $request, Client $client)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $client_edit = $this->clientRepository->findOneBy(['id' => $client]);
        $type = $client_edit->getType();
        if ($type == "false") {
            $t = 1;
        } else {
            $t = 0;
        }
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($client);
            $this->manager->flush();
            return $this->redirectToRoute("mes_client");
        }
        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client_edit,
            'type' => $t
        ]);
    }
    /**
     * 
     * @Route("/ajoutCliV1", name="ajoutClientV1", methods={"POST"}, options={"expose"=true})
     */
    public function ajoutClientV1(Request $request, EntityManagerInterface $entityManager)
    {
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            //GET last ref
            $lastid = $this->clientRepository->findOneBy(["user" => $user], ['id' => 'desc'],);
            if (is_null($lastid)) {
                $lastref = 1;
                $ref = $this->client_num($lastid, 6, "C");
            } else {
                $lastref = $lastid->getId();
                $lastref++;
                $ref = $this->client_num($lastref, 6, "C");
            }
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
            if ($nom === null) {
                $client->setNomClient($nomSociete);
            } else {
                $client->setNomClient($nom);
            }
            $client->setRef($ref);
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
            $client->setTitreEntrepriseClient($titreSociete);
            $client->setNumeroDeSerieClient($numSerie);
            $client->setAdresseFactureClient($adresse);
            $entityManager->persist($client);
            $entityManager->flush();
            //dernier id
            $infos = $this->clientRepository->findBy(["id" => $client->getId()]);;
            $response = $this->json($infos, 200, ["Content-Type" => "appication/json"], ['groups' => 'client:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
}