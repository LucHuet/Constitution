<?php

namespace App\Controller;

use App\Entity\DesignationPartie;
use App\Form\DesignationPartieType;
use App\Repository\DesignationPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Partie;
use App\Service\CheckStepService;
use App\Controller\Base\BaseController;

/**
 * @Route("/designation")
 */
class DesignationPartieController extends BaseController
{
    /**
     * @Route("/", name="designation_partie_index", methods="GET")
     */
    public function index(DesignationPartieRepository $designationPartieRepository): Response
      {
        //on verifie la partie actuelle
        if($this->checkStep->checkPartie() != null){
          return $this->redirectToRoute($this->checkStep->checkPartie());
        }

        //on récupere la partie courante afin de n'afficher que les acteurs de la partie courante
        $session = new Session();
        $partiCourante = $session->get('partieCourante');

        return $this->render('designation_partie/index.html.twig', ['designation_parties' => $designationPartieRepository->findBy(['partie' => $partiCourante])]);
    }

    /**
     * @Route("/", name="designation_partie_new_api", methods="POST")
     * @Method("POST")
     */
    public function createDesignationPartie(Request $request): Response
    {

        //recupération de la partie courante
        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');


        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }


        $form = $this->createForm(DesignationPartieType::class, null, [
          'csrf_protection' => false
        ]);

        $form->submit($data, false);
        dump($form->getData());
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return $this->createApiResponse([
                'errors' => $errors
            ], 400);
        }

        /** @var PouvoirPartie $pouvoirPartie */
        $designationPartie = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);
        $designationPartie->setPartie($partieCourante);
        $em->persist($designationPartie);
        $em->flush();

        $apiModel = $this->createDesignationPartieApiModel($designationPartie);

        $response = $this->createApiResponse($apiModel);

        $response->headers->set(
            'Location',
            $this->generateUrl('pouvoir_partie_show', ['id' => $designationPartie->getId()])
        );

        return $response;

    }

    /**
     * @Route("/new", name="designation_partie_new", methods="GET|POST")
     */
    public function new(Request $request, CheckStepService $checkStep): Response
    {
        if($checkStep->check2Acteurs() != null){
          return $this->redirectToRoute($checkStep->check2Acteurs());
        }

        $session = new Session();
        $partieCourante = $session->get('partieCourante');
        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);

        $designationPartie = new DesignationPartie();
        $designationPartie->setPartie($partieCourante);
        $form = $this->createForm(DesignationPartieType::class, $designationPartie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($designationPartie);
            $em->flush();

            return $this->redirectToRoute('partie_show', ['id' => $partieCourante->getId()]);
        }

        return $this->render('designation_partie/new.html.twig', [
            'designation_partie' => $designationPartie,
            'partieCourante' => $partieCourante,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="designation_partie_show", methods="GET")
     */
    public function show(DesignationPartie $designationPartie): Response
    {
        if($this->checkStep->checkDesignation($designationPartie) != null){
          return $this->redirectToRoute($this->checkStep->checkDesignation($designationPartie));
        }
        return $this->render('designation_partie/show.html.twig', ['designation_partie' => $designationPartie]);
    }

    /**
     * @Route("/{id}/edit", name="designation_partie_edit", methods="GET|POST")
     */
    public function edit(Request $request, DesignationPartie $designationPartie): Response
    {
      if($this->checkStep->checkDesignation($designationPartie) != null){
        return $this->redirectToRoute($this->checkStep->checkDesignation($designationPartie));
      }
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
      if($this->checkStep->checkDesignation($designationPartie) != null){
        return $this->redirectToRoute($this->checkStep->checkDesignation($designationPartie));
      }
        $session = new Session();
        $partieCourante = $session->get('partieCourante');
        if ($this->isCsrfTokenValid('delete'.$designationPartie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($designationPartie);
            $em->flush();
        }

        return $this->redirectToRoute('partie_show', ['id' => $partieCourante->getId()] );
    }
}
