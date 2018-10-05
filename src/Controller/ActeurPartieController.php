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

    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/", name="acteur_partie_index", methods="GET")
     */
    public function index(ActeurPartieRepository $acteurPartieRepository): Response
    {
        //on verifie la partie actuelle
        if($this->checkStep->checkPartie() != null){
          return $this->redirectToRoute($this->checkStep->checkPartie());
        }

        //on récupere la partie courante afin de n'afficher que les acteurs de la partie courante
        $session = new Session();
        $partiCourante = $session->get('partieCourante');

        return $this->render('acteur_partie/index.html.twig',
                            ['acteur_parties' => $acteurPartieRepository->findBy(['partie' => $partiCourante])]);
    }

    /**
     * @Route("/new", name="acteur_partie_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        //on verifie la partie actuelle
        if($this->checkStep->checkPartie() != null){
          return $this->redirectToRoute($this->checkStep->checkPartie());
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

            return $this->redirectToRoute('designation_partie_new');
        }

        return $this->render('acteur_partie/new.html.twig', [
            'acteur_partie' => $acteurPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="acteur_partie_show", methods="GET")
     */
    public function show(ActeurPartie $acteurPartie): Response
    {
        //on verifie que l'acteur est bien de la partie actuelle
        if($this->checkStep->checkActeur($acteurPartie) != null){
          return $this->redirectToRoute($this->checkStep->checkActeur($acteurPartie));
        }

        return $this->render('acteur_partie/show.html.twig', ['acteur_partie' => $acteurPartie]);
    }

    /**
     * @Route("/{id}/edit", name="acteur_partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, ActeurPartie $acteurPartie): Response
    {
        //on verifie que l'acteur est bien de la partie actuelle
        if($this->checkStep->checkActeur($acteurPartie) != null){
          return $this->redirectToRoute($this->checkStep->checkActeur($acteurPartie));
        }

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
      $partieCourante = $session->get('partieCourante');

        if ($this->isCsrfTokenValid('delete'.$acteurPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($acteurPartie);
            $em->flush();
        }

        return $this->redirectToRoute('partie_show', ['id' => $partieCourante->getId()]);
    }
}
