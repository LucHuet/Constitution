<?php

namespace App\Controller;

use App\Entity\DesignationPartie;
use App\Form\DesignationPartieType;
use App\Repository\DesignationPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/designation/partie")
 */
class DesignationPartieController extends AbstractController
{
    /**
     * @Route("/", name="designation_partie_index", methods="GET")
     */
    public function index(DesignationPartieRepository $designationPartieRepository): Response
    {
        return $this->render('designation_partie/index.html.twig', ['designation_parties' => $designationPartieRepository->findAll()]);
    }

    /**
     * @Route("/new", name="designation_partie_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $designationPartie = new DesignationPartie();
        $form = $this->createForm(DesignationPartieType::class, $designationPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($designationPartie);
            $em->flush();

            return $this->redirectToRoute('condition_designation_partie_new');
        }

        return $this->render('designation_partie/new.html.twig', [
            'designation_partie' => $designationPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="designation_partie_show", methods="GET")
     */
    public function show(DesignationPartie $designationPartie): Response
    {
        return $this->render('designation_partie/show.html.twig', ['designation_partie' => $designationPartie]);
    }

    /**
     * @Route("/{id}/edit", name="designation_partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, DesignationPartie $designationPartie): Response
    {
        $form = $this->createForm(DesignationPartieType::class, $designationPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('designation_partie_edit', ['id' => $designationPartie->getId()]);
        }

        return $this->render('designation_partie/edit.html.twig', [
            'designation_partie' => $designationPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="designation_partie_delete", methods="DELETE")
     */
    public function delete(Request $request, DesignationPartie $designationPartie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$designationPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($designationPartie);
            $em->flush();
        }

        return $this->redirectToRoute('designation_partie_index');
    }
}
