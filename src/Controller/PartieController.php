<?php

namespace App\Controller;

use App\Entity\Partie;
use App\Form\PartieType;
use App\Repository\PartieRepository;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\CheckStepService;

/**
 * @Route("/partie")
 */
class PartieController extends AbstractController
{

    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/liste", name="partie_liste", methods="GET")
     */
    public function liste(PartieRepository $partieRepository): Response
    {
        // verification qu'un utilisateur est loggé
        if($this->checkStep->checkLogin() != null){
          return $this->redirectToRoute($this->checkStep->checkLogin());
        }

        return $this->render('partie/index.html.twig', [
          'parties' => $partieRepository->findAll()
        ]);

    }


    /**
     * @Route("/new", name="partie_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        // verification qu'un utilisateur est loggé
        if($this->checkStep->checkLogin() != null){
          return $this->redirectToRoute($this->checkStep->checkLogin());
        }

        $partieCourante = new Partie();
        $form = $this->createForm(PartieType::class, $partieCourante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partieCourante->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($partieCourante);
            $em->flush();
            $session = new Session();
            $session->set('partieCourante', $partieCourante);
            return $this->redirectToRoute('partie_show', ['id' =>$partieCourante->getId()]);
        }

        return $this->render('partie/new.html.twig', [
            'partie' => $partieCourante,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partie_show", methods="GET")
     */
    public function show(
      Partie $partieCourante,
      ActeurPartieRepository $acteurPartieRepository,
      PouvoirPartieRepository $pouvoirPartieRepository
    ): Response
    {
        // verification de la partie courante
        if($this->checkStep->checkPartie($partieCourante) != null){
          return $this->redirectToRoute($this->checkStep->checkPartie($partieCourante));
        }

        $session = new Session();
        $session->set('partieCourante', $partieCourante);

        return $this->render('partie/show.html.twig', [
          'partieCourante' => $partieCourante,
          'acteurs' => $acteurPartieRepository->findBy(['partie' => $partieCourante]),
          'pouvoir_parties' => $pouvoirPartieRepository->findBy(['partie' => $partieCourante])
        ]);
    }


    /**
     * @Route("/{id}/edit", name="partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, Partie $partieCourante): Response
    {
        // verification de la partie courante
        if($this->checkStep->checkPartie($partieCourante) != null){
          return $this->redirectToRoute($this->checkStep->checkPartie($partieCourante));
        }

        $form = $this->createForm(PartieType::class, $partieCourante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partie_edit', ['id' => $partieCourante->getId()]);
        }

        return $this->render('partie/edit.html.twig', [
            'partie' => $partieCourante,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partie_delete", methods="DELETE")
     */
    public function delete(Request $request, Partie $partieCourante): Response
    {
        // verification de la partie courante
        if($this->checkStep->checkPartie($partieCourante) != null){
          return $this->redirectToRoute($this->checkStep->checkPartie($partieCourante));
        }

        if ($this->isCsrfTokenValid('delete'.$partieCourante->getId(), $request->request->get('_token'))) {
            $session = new Session();
            $session->remove('partieCourante');
            $em = $this->getDoctrine()->getManager();
            $em->remove($partieCourante);
            $em->flush();
        }

        return $this->redirectToRoute('partie_liste');
    }
}
