<?php

namespace App\Controller;

use App\Entity\Partie;
use App\Entity\Acteur;
use App\Entity\ActeurPartie;
use App\Entity\DroitDevoir;
use App\Form\PartieType;
use App\Repository\PartieRepository;
use App\Repository\ActeurRepository;
use App\Repository\PouvoirRepository;
use App\Repository\DesignationRepository;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;
use App\Repository\DroitDevoirRepository;
use App\Service\CheckStepService;
use App\Controller\Base\BaseController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Route("/partie")
 */
class PartieController extends BaseController
{

    private $checkStep;

    public function __construct(CheckStepService $checkStep)
    {
        $this->checkStep = $checkStep;
    }

    /**
     * @Route("/{id<\d+>}", name="partie_get" , methods="GET")
     * @Method("GET")
     */
    public function getPartie(Partie $partie)
    {
        $apiModel = $this->createPartieApiModel($partie);

        return $this->createApiResponse($apiModel);
    }

    /**
     * @Route("/", name="partie_list", methods="GET")
     * @Method("GET")
     */
    public function getParties()
    {
        $models = $this->findAllUserPartiesModels();
        return $this->createApiResponse([
            'items' => $models
        ]);
    }



    /**
     * @Route("/", name="partie_new", methods="POST")
     * @Method("POST")
     */
    public function createPartie(Request $request, ActeurPartieRepository $acteurPartieRepository, ActeurRepository $acteurRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new BadRequestHttpException('Invalid JSON');
        }

        $form = $this->createForm(PartieType::class, null, [
          'csrf_protection' => false
        ]);

        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return $this->createApiResponse([
                'errors' => $errors
            ], 400);
        }

        /** @var Partie $partie */
        $partie = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $partie->setUser($this->getUser());

        $peuple = new ActeurPartie();
        $peuple->setTypeActeur($acteurRepository->findOneBy(['type' => 'Peuple']));
        $peuple->setPartie($partie);
        $peuple->setNombreIndividus(1);
        $peuple->setNom('Le peuple');
        $em->persist($peuple);

        $partie->addActeurParty($peuple);
        $em->persist($partie);
        $em->flush();

        $apiModel = $this->createPartieApiModel($partie);

        $response = $this->createApiResponse($apiModel);
        //$response = new Response(null, 204);
        // setting the Location header... it's a best-practice
        $response->headers->set(
            'Location',
            $this->generateUrl('partie_get', ['id' => $partie->getId()])
        );

        return $response;
    }

    /**
     * @Route("/{id<\d+>}", name="partie_delete", methods="DELETE")
     */
    public function deletePartie(Partie $partie)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $em = $this->getDoctrine()->getManager();
        $em->remove($partie);
        $em->flush();
        return new Response(null, 204);
    }

    /**
     * @Route("/droitDevoir/", name="droits_devoirs_partie_liste", methods="GET")
     */
    public function getDroitsDevoirs(DroitDevoirRepository $DroitDevoirRepository)
    {
      $models = $this->findAllDroitsDevoirsModels();
      return $this->createApiResponse([
          'items' => $models
      ]);
    }

    /**
     * @Route("/droitDevoir/{id<\d+>}", name="droit_devoir_partie_new")
     */
     public function addDroitDevoir(Request $request, DroitDevoir $droitDevoir){

       $session = new Session();
       $partieCourante = $session->get('partieCourante');
       $em = $this->getDoctrine()->getManager();
       $partieCourante = $em->merge($partieCourante);

       //récupération de tous les droits et devoirs de la partie en cours
       $droitsDevoirsPartieNoms = array();
       $droitsDevoirsPartie = $partieCourante->getDroitDevoirs();

       foreach($droitsDevoirsPartie as $droitDevoirPartie){
         $droitDevoirPartieNom = $droitDevoirPartie->getNom();
         array_push($droitsDevoirsPartieNoms, $droitDevoirPartieNom);
       }

       //si le droit devoir envoyé n'est pas encore présent dans la partie on le rajoute
       if(!in_array($droitDevoir->getNom(), $droitsDevoirsPartieNoms)){
         $partieCourante->addDroitDevoir($droitDevoir);
       }
       //si le droit devoir est déjà présent dans la partie, on l'enlève
       else{
         $partieCourante->removeDroitDevoir($droitDevoir);
       }

       $em->persist($partieCourante);
       $em->flush();

       $models = $this->findAllDroitsDevoirsModels();
       return $this->createApiResponse([
           'items' => $models
       ]);
      }

}
