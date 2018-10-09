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
use App\Entity\ConditionPouvoirPartie;
use App\Service\CheckStepService;


/**
 * @Route("/pouvoir")
 */
class PouvoirPartieController extends AbstractController
{
    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/", name="pouvoir_partie_index", methods="GET")
     */
    public function index(PouvoirPartieRepository $pouvoirPartieRepository): Response
    {
        //on verifie la partie actuelle
        if($this->checkStep->checkPartie() != null){
          return $this->redirectToRoute($this->checkStep->checkPartie());
        }

        //on récupere la partie courante afin de n'afficher que les acteurs de la partie courante
        $session = new Session();
        $partiCourante = $session->get('partieCourante');

        return $this->render('pouvoir_partie/index.html.twig', ['pouvoir_parties' => $pouvoirPartieRepository->findBy(['partie' => $partiCourante])]);
    }

    /**
     * @Route("/new", name="pouvoir_partie_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if($this->checkStep->checkActeur() != null){
          return $this->redirectToRoute($this->checkStep->checkActeur());
        }

        //recupération de la partie courante
        $session = new Session();
        $partieCourante = $session->get('partieCourante');
        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);
        $pouvoirPartie = new PouvoirPartie();
        $pouvoirPartie->setPartie($partieCourante);

        $form = $this->createForm(PouvoirPartieType::class, $pouvoirPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $pouvoirPartie->setPartie($partieCourante);
            $em->persist($pouvoirPartie);
            $em->flush();

            return $this->redirectToRoute('partie_show', ['id' => $partieCourante->getId()] );
        }

        return $this->render('pouvoir_partie/new.html.twig', [
            'pouvoir_partie' => $pouvoirPartie,
            'form' => $form->createView(),
            'partieCouranteId' => $partieCourante->getId(),
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
        $session = new Session();
        $partieCourante = $session->get('partieCourante');
        
        if ($this->isCsrfTokenValid('delete'.$pouvoirPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pouvoirPartie);
            $em->flush();
        }

        return $this->redirectToRoute('partie_show', ['id' => $partieCourante->getId()] );
    }
}
