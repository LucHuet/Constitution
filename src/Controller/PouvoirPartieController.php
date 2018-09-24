<?php

namespace App\Controller;

use App\Entity\PouvoirPartie;
use App\Form\PouvoirPartieType;
use App\Repository\PouvoirPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Partie;
use App\Service\CheckStepService;


/**
 * @Route("/pouvoir")
 */
class PouvoirPartieController extends AbstractController
{
    /**
     * @Route("/", name="pouvoir_partie_index", methods="GET")
     */
    public function index(PouvoirPartieRepository $pouvoirPartieRepository): Response
    {
        return $this->render('pouvoir_partie/index.html.twig', ['pouvoir_parties' => $pouvoirPartieRepository->findAll()]);
    }

    /**
     * @Route("/new", name="pouvoir_partie_new", methods="GET|POST")
     */
    public function new(Request $request, CheckStepService $checkStep): Response
    {
      if($checkStep->ckeckActeur() != null){
        return $this->redirectToRoute($checkStep->ckeckActeur());
      }

      $session = new Session();
      $partie = $this->getDoctrine()
          ->getRepository(Partie::class)
          ->find($session->get('partie_courante_id'));


        $pouvoirPartie = new PouvoirPartie();
        $pouvoirPartie->setPartie($partie);
        $form = $this->createForm(PouvoirPartieType::class, $pouvoirPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pouvoirPartie->setPartie($partie);
            $em->persist($pouvoirPartie);
            $em->flush();

            return $this->redirectToRoute('condition_pouvoir_partie_new');
        }

        return $this->render('pouvoir_partie/new.html.twig', [
            'pouvoir_partie' => $pouvoirPartie,
            'form' => $form->createView(),
            'partie_courante_id' => $partie->getId(),
        ]);
    }

    /**
     * @Route("/{id}", name="pouvoir_partie_show", methods="GET")
     */
    public function show(PouvoirPartie $pouvoirPartie): Response
    {
        return $this->render('pouvoir_partie/show.html.twig', ['pouvoir_partie' => $pouvoirPartie]);
    }

    /**
     * @Route("/{id}/edit", name="pouvoir_partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, PouvoirPartie $pouvoirPartie): Response
    {
        $form = $this->createForm(PouvoirPartieType::class, $pouvoirPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pouvoir_partie_edit', ['id' => $pouvoirPartie->getId()]);
        }

        return $this->render('pouvoir_partie/edit.html.twig', [
            'pouvoir_partie' => $pouvoirPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pouvoir_partie_delete", methods="DELETE")
     */
    public function delete(Request $request, PouvoirPartie $pouvoirPartie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pouvoirPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pouvoirPartie);
            $em->flush();
        }

        return $this->redirectToRoute('pouvoir_partie_index');
    }
}
