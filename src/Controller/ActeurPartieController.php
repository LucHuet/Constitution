<?php

namespace App\Controller;

//use App\Api\ApiRoute;
use App\Entity\ActeurPartie;
use App\Form\ActeurPartieType;
use App\Repository\ActeurPartieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Partie;
use App\Service\CheckStepService;

/**
 * @Route("/acteur")
 */
class ActeurPartieController extends BaseController
{
    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/", name="acteur_new", methods="POST", options={"expose"=true})
     * @Method("POST")
     */
    public function createActeur(Request $request)
    {
        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        $form = $this->createForm(ActeurPartieType::class, null, [
          'csrf_protection' => false
        ]);

        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return $this->createApiResponse([
                'errors' => $errors
            ], 400);
        }

        /** @var Acteur $acteur */
        $acteur = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);
        $acteur->setPartie($partieCourante);
        $em->persist($acteur);
        $em->flush();

        $apiModel = $this->createActeurApiModel($acteur);

        $response = $this->createApiResponse($apiModel);
        //$response = new Response(null, 204);
        // setting the Location header... it's a best-practice
        $response->headers->set(
            'Location',
            $this->generateUrl('acteur_partie', ['id' => $acteur->getId()])
        );

        return $response;
    }


    /**
     * @Route("/", name="acteur_partie_list", methods="GET", options={"expose"=true})
     * @Method("GET")
     */
    public function getActeursPartie(ActeurPartieRepository $acteurPartieRepository)
    {
        $models = $this->findAllUsersActeursModels();
        return $this->createApiResponse([
            'items' => $models
        ]);
    }

    /**
     * @Route("/{id}", name="acteur_partie" , methods="GET")
     * @Method("GET")
     */
    public function getActeurPartie(ActeurPartie $acteurPartie)
    {
        $apiModel = $this->createActeurApiModel($acteurPartie);

        return $this->createApiResponse($apiModel);
    }

    public function getFormActeur(): Response
    {
        $form = $this->createForm(ActeurPartieType::class, null, [
          'csrf_protection' => false
        ]);

        return $this->render('acteur_partie/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="acteur_partie_edit", methods="PUT")
     */
    public function edit(Request $request, ActeurPartie $acteurPartie): Response
    {
        //on verifie que l'acteur est bien de la partie actuelle
        if ($this->checkStep->checkActeur($acteurPartie) != null) {
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
    public function deleteActeurPartie(ActeurPartie $acteurPartie)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $em = $this->getDoctrine()->getManager();
        $em->remove($acteurPartie);
        $em->flush();
        return new Response(null, 204);
    }
}
