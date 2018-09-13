<?php

namespace App\Controller;

use App\Entity\ConditionDesignationPartie;
use App\Form\ConditionDesignationPartieType;
use App\Repository\ConditionDesignationPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/condition/designation/partie")
 */
class ConditionDesignationPartieController extends AbstractController
{
    /**
     * @Route("/", name="condition_designation_partie_index", methods="GET")
     */
    public function index(ConditionDesignationPartieRepository $conditionDesignationPartieRepository): Response
    {
        return $this->render('condition_designation_partie/index.html.twig', ['condition_designation_parties' => $conditionDesignationPartieRepository->findAll()]);
    }

    /**
     * @Route("/new", name="condition_designation_partie_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $conditionDesignationPartie = new ConditionDesignationPartie();
        $form = $this->createForm(ConditionDesignationPartieType::class, $conditionDesignationPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($conditionDesignationPartie);
            $em->flush();

            return $this->redirectToRoute('condition_designation_partie_index');
        }

        return $this->render('condition_designation_partie/new.html.twig', [
            'condition_designation_partie' => $conditionDesignationPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_designation_partie_show", methods="GET")
     */
    public function show(ConditionDesignationPartie $conditionDesignationPartie): Response
    {
        return $this->render('condition_designation_partie/show.html.twig', ['condition_designation_partie' => $conditionDesignationPartie]);
    }

    /**
     * @Route("/{id}/edit", name="condition_designation_partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, ConditionDesignationPartie $conditionDesignationPartie): Response
    {
        $form = $this->createForm(ConditionDesignationPartieType::class, $conditionDesignationPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('condition_designation_partie_edit', ['id' => $conditionDesignationPartie->getId()]);
        }

        return $this->render('condition_designation_partie/edit.html.twig', [
            'condition_designation_partie' => $conditionDesignationPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condition_designation_partie_delete", methods="DELETE")
     */
    public function delete(Request $request, ConditionDesignationPartie $conditionDesignationPartie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conditionDesignationPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conditionDesignationPartie);
            $em->flush();
        }

        return $this->redirectToRoute('condition_designation_partie_index');
    }
}
