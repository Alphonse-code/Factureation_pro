<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\UserInfos;
use App\Form\UserInfosType;
use App\Repository\UserInfosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/parametre")
 */
class ReglageController extends AbstractController
{

    private $reglageRepository;
    private $em;
    public function __construct(UserInfosRepository $reglageRepository, EntityManagerInterface $em)
    {
        $this->reglageRepository = $reglageRepository;
        $this->em = $em;
    }
    /**
     * @Route("/", name="reglage", options={"expose"=true})
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $param = $this->reglageRepository->findOneBy(['user' => $user]);
        //dd($param);
        return $this->render('reglage/reglage.html.twig', [
            'param' => $param,
        ]);
    }
    /**
     * @Route("/creer", name="creer_reglage")
     */
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $param = new UserInfos();
        $form = $this->createForm(UserInfosType::class, $param);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get("logo")->getData();
            //on génére un nouveau nom de fichier
            $fichier = md5(uniqid()) . '.' . $logo->guessExtension();
            $param->setUser($user);
            $param->setLogo($fichier);
            $logo->move($this->getParameter("upload_file"), $fichier);
            $this->em->persist($param);
            $this->em->flush();
            return $this->redirectToRoute("reglage");
        }
        //dd($param);
        return $this->render('reglage/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="update_reglage")
     */
    public function edit(Request $request, UserInfos $userInfos): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserInfosType::class, $userInfos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get("logo")->getData();
            //on génére un nouveau nom de fichier
            $fichier = md5(uniqid()) . '.' . $logo->guessExtension();
            $userInfos->setUser($user);
            $userInfos->setLogo($fichier);
            $logo->move($this->getParameter("upload_file"), $fichier);
            $this->em->persist($userInfos);
            $this->em->flush();
            $this->addFlash('success', 'Modification avec success!');
            return $this->redirectToRoute("reglage");
        }
        //dd($param);
        return $this->render('reglage/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/param", name="get_all_param", methods={"GET"}, options={"expose"=true})
     */
    public function getAllParam(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $user = $this->getUser();
            // $param = $this->reglageRepository->findAll();
            $param = $this->reglageRepository->findOneBy(['user' => $user]);
            $response = $this->json($param, 200, [], ['groups' => 'param:read']);
            return $response;
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
    /**
     * @Route("/supprimer/{id}", name="delete_param", methods={"DELETE"}, options={"expose"=true})
     */
    public function deleteParam(Request $request, $id)
    {
        if ($request->isXMLHttpRequest()) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($request->isXMLHttpRequest()) {
                $param = $this->reglageRepository->findOneBy(["id" => $id]);
                $entityManager->remove($param);
                $entityManager->flush();
            }
            
            $response = $this->json(["success" => "produit bien supprimer"], 200, [], ['groups' => 'produit:read']);

            return $response;
            
        } else {
            return new JsonResponse(['error' => 'ajax not found']);
        }
    }
}