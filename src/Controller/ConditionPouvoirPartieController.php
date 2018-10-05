<?php

namespace App\Controller;

use App\Entity\ConditionPouvoirPartie;
use App\Form\ConditionPouvoirPartieType;
use App\Repository\ConditionPouvoirPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Partie;
use App\Repository\ActeurPartieRepository;
use App\Service\CheckStepService;
use App\Service\CalculJaugeService;

/**
 * @Route("/condition/pouvoir/partie")
 */
class ConditionPouvoirPartieController extends AbstractController
{
    /**
     * @Route("/", name="condition_pouvoir_partie_index", methods="GET")
     */
    public function index(ConditionPouvoirPartieRepository $conditionPouvoirPartieRepository): Response
    {
        return $this->render('condition_pouvoir_partie/index.html.twig', ['condition_pouvoir_parties' => $conditionPouvoirPartieRepository->findAll()]);
    }

    /**
     * @Route("/new", name="condition_pouvoir_partie_new", methods="GET|POST")
     */
    public function new(Request $request, CheckStepService $checkStep, CalculJaugeService $calculJauge): Response
    {
        if($checkStep->checkPouvoir() != null){
          return $this->redirectToRoute($checkStep->checkPouvoir());
        }

        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $conditionPouvoirPartie = new ConditionPouvoirPartie();
        $form = $this->createForm(ConditionPouvoirPartieType::class, $conditionPouvoirPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $partieCourante = $em->merge($partieCourante);
            $conditionPouvoirPartie->setPartie($partieCourante);
            $calculJauge->ajoutCondition($conditionPouvoirPartie);
            $em->persist($conditionPouvoirPartie);
            $em->flush();

            return $this->redirectToRoute('partie_show', ['id'=>$partieCourante->getId()]);
        }

        return $this->render('condition_pouvoir_partie/new.html.twig', [
            'condition_pouvoir_partie' => $conditionPouvoirPartie,
            'partieCourante' => $partieCourante,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_pouvoir_partie_show", methods="GET")
     */
    public function show(ConditionPouvoirPartie $conditionPouvoirPartie): Response
    {
        return $this->render('condition_pouvoir_partie/show.html.twig', ['condition_pouvoir_partie' => $conditionPouvoirPartie]);
    }

    /**
     * @Route("/{id}/edit", name="condition_pouvoir_partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, ConditionPouvoirPartie $conditionPouvoirPartie): Response
    {
        $form = $this->createForm(ConditionPouvoirPartieType::class, $conditionPouvoirPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('condition_pouvoir_partie_edit', ['id' => $conditionPouvoirPartie->getId()]);
        }

        return $this->render('condition_pouvoir_partie/edit.html.twig', [
            'condition_pouvoir_partie' => $conditionPouvoirPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_pouvoir_partie_delete", methods="DELETE")
     */
    public function delete(Request $request, ConditionPouvoirPartie $conditionPouvoirPartie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conditionPouvoirPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conditionPouvoirPartie);
            $em->flush();
        }

        return $this->redirectToRoute('condition_pouvoir_partie_index');
    }
}
