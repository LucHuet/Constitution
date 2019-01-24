<?php

namespace App\Controller;

use App\Entity\ActeurPartie;
use App\Entity\DesignationPartie;
use App\Entity\PouvoirPartie;
use App\Form\ActeurPartieCompletType;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirRepository;
use App\Repository\PouvoirPartieRepository;
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
use App\Controller\Base\BaseController;

/**
 * @Route("/acteurPartie")
 */
class ActeurPartieController extends BaseController
{
    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/", name="acteur_partie_new", methods="POST", options={"expose"=true})
     * @Method("POST")
     */
    public function createActeurPartie(Request $request, PouvoirRepository $pouvoirRepository, PouvoirPartieRepository $pouvoirPartieRepository)
    {
        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        $form = $this->createForm(ActeurPartieCompletType::class, null, [
          'csrf_protection' => false
        ]);

        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return $this->createApiResponse([
                'errors' => $errors
            ], 400);
        }

        $data=$form->getData();
        /** @var Acteur $acteur */

        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);

        $acteur = $data['acteurPartie'];
        $acteur->setPartie($partieCourante);

        $designation = $data['designation'];
        $designation->setActeurDesigne($acteur);
        $designation->setPartie($partieCourante);

        $pouvoirsId = $data['pouvoirs'];

        foreach($pouvoirsId as $pouvoirId){
          $pouvoirRef = $pouvoirRepository->find($pouvoirId);
          $pouvoirPartie = $pouvoirPartieRepository->findOneBy(['pouvoir' => $pouvoirRef]);
          if($pouvoirPartie == null)
          {
            $pouvoirPartie = new PouvoirPartie();
            $pouvoirPartie->setNom($pouvoirRef->getNom());
            $pouvoirPartie->setPartie($partieCourante);
            $pouvoirPartie->setPouvoir($pouvoirRef);
          }
          $pouvoirPartie->addActeurPossedant($acteur);
          $em->persist($pouvoirPartie);
        }

        $em->persist($designation);
        $em->persist($acteur);

        $em->flush();

        $apiModel = $this->createActeurPartieApiModel($acteur);

        $response = $this->createApiResponse($apiModel);
        //$response = new Response(null, 204);
        // setting the Location header... it's a best-practice
        $response->headers->set(
            'Location',
            $this->generateUrl('acteur_partie_get', ['id' => $acteur->getId()])
        );

        return $response;
    }

    /**
     * @Route("/", name="acteur_partie_list", methods="GET")
     * @Method("GET")
     */
    public function getActeursPartie()
    {
        $models = $this->findAllActeursPartieModels();
        return $this->createApiResponse([
            'items' => $models
        ]);
    }



    /**
     * @Route("/{id<\d+>}", name="acteur_partie_get" , methods="GET")
     * @Method("GET")
     */
    public function getActeurPartie(ActeurPartie $acteurPartie)
    {
        $apiModel = $this->createActeurPartieApiModel($acteurPartie);

        return $this->createApiResponse($apiModel);
    }

    /**
     * @Route("/{id<\d+>}", name="acteur_partie_edit", methods="PUT")
     */
    public function editActeurPartie(Request $request, ActeurPartie $acteurPartie): Response
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
            'acteur_partie_get' => $acteurPartie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="acteur_partie_delete", methods="DELETE")
     * @Method("DELETE")
     */
    public function deleteActeurPartie(ActeurPartie $acteurPartie)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $session = new Session();
        $partieCourante = $session->get('partieCourante');

        $em = $this->getDoctrine()->getManager();
        foreach($acteurPartie->getPouvoirParties() as $pouvoirPartie)
        {
          if(count($pouvoirPartie->getActeurPossedant())==1)
          {
            $em->remove($pouvoirPartie);
          }
        }
        $em->remove($acteurPartie);
        $em->flush();
        return new Response(null, 204);
    }
}
