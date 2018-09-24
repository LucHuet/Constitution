<?php

namespace App\Controller;

use App\Entity\ActeurPartie;
use App\Form\ActeurPartieType;
use App\Repository\ActeurPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Partie;
use App\Service\CheckStepService;

/**
 * @Route("/acteur")
 */
class ActeurPartieController extends AbstractController
{
    /**
     * @Route("/", name="acteur_partie_index", methods="GET")
     */
    public function index(ActeurPartieRepository $acteurPartieRepository): Response
    {

        return $this->render('acteur_partie/index.html.twig',
                            ['acteur_parties' => $acteurPartieRepository->findAll()]);
    }

    /**
     * @Route("/new", name="acteur_partie_new", methods="GET|POST")
     */
    public function new(Request $request, CheckStepService $checkStep): Response
    {
        if($checkStep->checkPartie() != null){
          return $this->redirectToRoute($checkStep->checkPartie());
        }

        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $acteurPartie = new ActeurPartie();
        $form = $this->createForm(ActeurPartieType::class, $acteurPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $partieCourante = $em->merge($partieCourante);
            $acteurPartie->setPartie($partieCourante);
            $em->persist($acteurPartie);
            $em->flush();

            return $this->redirectToRoute('pouvoir_partie_new');
        }

        return $this->render('acteur_partie/new.html.twig', [
            'acteur_partie' => $acteurPartie,
            'partieCourante' => $partieCourante,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="acteur_partie_show", methods="GET")
     */
    public function show(ActeurPartie $acteurPartie): Response
    {
        return $this->render('acteur_partie/show.html.twig', ['acteur_partie' => $acteurPartie]);
    }

    /**
     * @Route("/{id}/edit", name="acteur_partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, ActeurPartie $acteurPartie): Response
    {
        $form = $this->createForm(ActeurPartieType::class, $acteurPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('acteur_partie_edit', ['id' => $acteurPartie->getId()]);
        }

        return $this->render('acteur_partie/edit.html.twig', [
            'acteur_partie' => $acteurPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="acteur_partie_delete", methods="DELETE")
     */
    public function delete(Request $request, ActeurPartie $acteurPartie): Response
    {
      $session = new Session();
      $partie = $this->getDoctrine()
          ->getRepository(Partie::class)
          ->find($session->get('partie_courante_id'));

        if ($this->isCsrfTokenValid('delete'.$acteurPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($acteurPartie);
            $em->flush();
        }

        return $this->redirectToRoute('partie_show', ['id' => $partie->getId()]);
    }
}
