<?php

namespace App\Controller;

use DateTime;
use App\Entity\Tva;
use App\Entity\Produit;
use App\Repository\TvaRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    private $produitRepository;
    private $em;
    public function __construct(ProduitRepository $produitRepository, EntityManagerInterface $em)
    {
        $this->produitRepository = $produitRepository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="produit", options={"expose"=true})
     */
    public function index(PaginatorInterface $paginator, Request $request, ProduitRepository $produitRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $total = $produitRepository->getTotalProduits($user);
        $produits = $produitRepository->findAllProduit($user);
        $pagination = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'produits' => $pagination,
            'total' => $total
        ]);
    }

    /**
     * recupérer tous les poduits to select
     * @Route("/lists", name="produits", methods={"POST"}, options={"expose"=true})
     */
    public function produits(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $produit = $request->get("produit");
            $produits = $this->produitRepository->getProduitToSelect($produit, $user);
            //$produits= $this->produitRepository->findAll();;
            $response = $this->json($produits, 200, [], ['groups' => 'produit:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * @Route("/delete", name="supprimer_produit", methods={"DELETE"}, options={"expose"=true}) 
     */
    public function deleteProduit(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        $entityManager = $this->getDoctrine()->getManager();
        if ($request->isXMLHttpRequest()) {
            $ref = $request->get("id");
            for ($i = 0; $i < sizeof($ref); $i++) {
                $facture = $this->produitRepository->findOneBy(["id" => $ref[$i]]);
                $entityManager->remove($facture);
                $entityManager->flush();
            }
            $response = $this->json(['status' => 'success', 'message' => "produit bien supprimer"], 200, ["Content-Type" => "appication/json"]);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * recupérer tous les poduits to select
     * @Route("/produits", name="produit_ajax", methods={"GET"}, options={"expose"=true})
     */
    public function produitsAjax(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $produits = $this->produitRepository->findAllProduit($user);
            $response = $this->json($produits, 200, [], ['groups' => 'produit:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    // gerer automatique le numéro du produit
    private function prodouit_num($input, $pad_len = 6, $prefix = null)
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate product number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
    /**
     * ajout produit
     * @Route("/nouveau", name="ajout_produit", methods={"POST"}, options={"expose"=true})
     */
    public function ajoutProduits(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $produit = new Produit;
            $nomProduit = $request->get("nomProduit");
            $comment = $request->get("comment");
            $prixBase = $request->get("prixbase");
            $prixUTTC = $request->get("prixTTC");
            $prixUHT = $request->get("prixHT");
            $tva = $request->get("tva");

            //GET last ref
            $lastid = $this->produitRepository->findOneBy(["user" => $user], ['id' => 'desc'],);
            if (is_null($lastid)) {
                $lastref = 1;
                $ref = $this->prodouit_num($lastref, 6, "P");
            } else {
                $lastref = $lastid->getId();
                $lastref++;
                $ref = $this->prodouit_num($lastref, 6, "P");
            }
            if ($user) {
                $produit->setNomProduit($nomProduit);
                $produit->setComment($comment);
                $produit->setPrixUHT($prixUHT);
                $produit->setPrixUTTC($prixUTTC);
                $produit->setPrixBase($prixBase);
                $produit->setTva($tva);
                $produit->setRef($ref);
                $produit->setUser($user);
                $this->em->persist($produit);
                $this->em->flush();
                $response = $this->json(['status' => 'success', 'message' => "ajout avec success!"], 200, [], ['groups' => 'produit:read']);
                return $response;
            } else {
                return new JsonResponse(['error' => 'pas connecté']);
            }
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * recherche un produit
     * @Route("/recherche", name="recherche_produit", methods={"POST"}, options={"expose"=true})
     */
    public function rechercheProduit(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        if ($request->isXMLHttpRequest()) {
            $produit = $request->get("key");
            $produits = $this->produitRepository->getProduitToSelect($produit, $user);
            $response = $this->json($produits, 200, [], ['groups' => 'produit:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * 
     * @Route("/infos", name="infos_produit", methods={"POST"}, options={"expose"=true})
     */
    public function getInfos(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        // $produits= $this->produitRepository->getProduitToSelect("pro");
        if ($request->isXMLHttpRequest()) {

            $id = $request->get("id");
            $produits = $this->produitRepository->findBy(['id' => $id]);
            $response = $this->json($produits, 200, [], ['groups' => 'produit:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * 
     * @Route("/editInfos", name="edit_pro", methods={"GET"}, options={"expose"=true})
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        // $produits= $this->produitRepository->getProduitToSelect("pro");
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $id = $request->get("id");
            $produits = $this->produitRepository->findOneBy(['id' => $id]);
            $response = $this->json($produits, 200, [], ['groups' => 'produit:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }

    /**
     * 
     * @Route("/edit", name="edit_action", methods={"POST"}, options={"expose"=true})
     */
    public function editAction(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute("app_login");
        }
        // $produits= $this->produitRepository->getProduitToSelect("pro");
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            $id = $request->get("id");
            $nomProduit = $request->get("nomProduitE");
            $comment = $request->get("commentE");
            $prixBase = $request->get("prixBaseE");
            $prixUTTC = $request->get("prixTTCE");
            $prixUHT = $request->get("prixHTE");
            $tva = $request->get("tvaE");

            $produit = $this->produitRepository->findOneBy(['id' => $id]);
            $produit->setNomProduit($nomProduit);
            $produit->setComment($comment);
            $produit->setPrixUHT($prixUHT);
            $produit->setPrixUTTC($prixUTTC);
            $produit->setPrixBase($prixBase);
            $produit->setTva($tva);
            $produit->setUser($user);
            $this->em->persist($produit);
            $this->em->flush();
            $response = $this->json(['status' => 'success', 'message' => "modification avec success!"], 200, [], ['groups' => 'produit:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
}