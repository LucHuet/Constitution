<?php

namespace App\Controller;

use App\Entity\ActeurPartie;
use App\Entity\DesignationPartie;
use App\Entity\PouvoirPartie;
use App\Entity\ControlePartie;
use App\Entity\Pouvoir;
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
     * @Route("/{id<\d+>}", name="acteur_partie_get" , methods="GET")
     */
    public function getActeurPartie(ActeurPartie $acteurPartie)
    {
        $apiModel = $this->createActeurPartieApiModel($acteurPartie);

        return $this->createApiResponse($apiModel);
    }

    /**
     * @Route("/", name="acteur_partie_list", methods="GET")
     */
    public function getActeursPartie()
    {
        $models = $this->findAllActeursPartieModels();
        return $this->createApiResponse([
            'items' => $models
        ]);
    }

    /**
     * @Route("/", name="acteur_partie_new", methods="POST")
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

        $em = $this->getDoctrine()->getManager();
        $partieCourante = $em->merge($partieCourante);

        $acteurPartie = $data['acteurPartie'];
        $acteurPartie->setPartie($partieCourante);

        $designation = $data['designation'];
        $designation->setActeurDesigne($acteurPartie);
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
          $pouvoirPartie->addActeurPossedant($acteurPartie);
          $em->persist($pouvoirPartie);
        }

        $pouvoirsControlesId = $data['pouvoirsControles'];
        foreach($pouvoirsControlesId as $pouvoirControleId){
          $newControlePartie = new ControlePartie(); //dump($pouvoirsControlesId); die();
          $newControlePartie->setPouvoirPartie($pouvoirPartieRepository->find($pouvoirControleId));
          $acteurPartie->addControlesParty($newControlePartie);
          $em->persist($newControlePartie);
        }

        $em->persist($designation);
        $em->persist($acteurPartie);

        $em->flush();

        $apiModel = $this->createActeurPartieApiModel($acteurPartie);

        $response = $this->createApiResponse($apiModel);
        //$response = new Response(null, 204);
        // setting the Location header... it's a best-practice
        $response->headers->set(
            'Location',
            $this->generateUrl('acteur_partie_get', ['id' => $acteurPartie->getId()])
        );

        return $response;
    }

    /**
     * @Route("/{id<\d+>}", name="acteur_partie_edit", methods="PUT")
     */
    public function editActeurPartie(Request $request, ActeurPartie $acteurPartie, PouvoirPartieRepository $pouvoirPartieRepository): Response
    {
      $session = new Session();
      $partieCourante = $session->get('partieCourante');
      $em = $this->getDoctrine()->getManager();
      $partieCourante = $em->merge($partieCourante);

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



      $acteurPartie->setNom($data['acteurPartie']->getNom());
      $acteurPartie->setNombreIndividus($data['acteurPartie']->getNombreIndividus());
      foreach($acteurPartie->getActeursDesignes() as $designationEntrante)
      {
        $designationEntrante->setActeurDesignant($data['designation']->getActeurDesignant());
        $designationEntrante->setDesignation($data['designation']->getDesignation());
      }

      $acteurPartie->emptyPouvoirParty();

      $listOfPouvoirsAlreadyInGame = $em->getRepository(PouvoirPartie::class)->findByListOfPouvoirId($data['pouvoirs'], $partieCourante);
      foreach($data['pouvoirs'] as $pouvoirRefToAdd)
      {
        $added = false;
        foreach($listOfPouvoirsAlreadyInGame as $pouvoirAlreadyInGame)
        {
          if($pouvoirRefToAdd == $pouvoirAlreadyInGame->getPouvoir()->getId())
          {
            $acteurPartie->addPouvoirParty($pouvoirAlreadyInGame);
            $added = true;
          }
        }
        if(!$added)
        {
          $pouvoirRefToAdd = $em->getRepository(Pouvoir::class)->find($pouvoirRefToAdd);
          $pouvoirPartieToAdd = new PouvoirPartie();
          $pouvoirPartieToAdd->setNom($pouvoirRefToAdd->getNom());
          $pouvoirPartieToAdd->setPouvoir($pouvoirRefToAdd);
          $pouvoirPartieToAdd->setPartie($partieCourante);
          $em->persist($pouvoirPartieToAdd);
          $acteurPartie->addPouvoirParty($pouvoirPartieToAdd);
        }
      }

      //on supprime tous les controles qui ne sont pas dans la liste envoyé
      foreach ($acteurPartie->getControlesParties() as $controlePartie) {
        if(in_array($controlePartie->getPouvoirPartie()->getId(), $data['pouvoirsControles']))
        {
          unset($data['pouvoirsControles'][array_search($controlePartie->getPouvoirPartie()->getId(), $data['pouvoirsControles'])]);
        }else {
          $acteurPartie->removeControlesParty($controlePartie);
        }
      }
      //on ajoute tous les nouveaux controles
      foreach($data['pouvoirsControles'] as $pouvoirControleId){
        $newControlePartie = new ControlePartie();
        $newControlePartie->setPouvoirPartie($pouvoirPartieRepository->find($pouvoirControleId));
        $acteurPartie->addControlesParty($newControlePartie);
        $em->persist($newControlePartie);
      }

      $em->flush();

      $apiModel = $this->createActeurPartieApiModel($acteurPartie);

      $response = $this->createApiResponse($apiModel);
      //$response = new Response(null, 204);
      // setting the Location header... it's a best-practice
      $response->headers->set(
          'Location',
          $this->generateUrl('acteur_partie_get', ['id' => $acteurPartie->getId()])
      );

      return $response;
    }

    /**
     * @Route("/{id<\d+>}", name="acteur_partie_delete", methods="DELETE")
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
