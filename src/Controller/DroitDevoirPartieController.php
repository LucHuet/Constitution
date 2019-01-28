<?php
namespace App\Controller;

use App\Controller\Base\BaseController;
use App\Entity\DroitDevoir;
use App\Repository\DroitDevoirRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/droitDevoirPartie")
 */
class DroitDevoirPartieController extends BaseController
{

  /**
   * @Route("/", name="droits_devoirs_partie_liste", methods="GET")
   */
  public function getDroitsDevoirs()
  {
    $models = $this->findAllDroitsDevoirsModels();
    return $this->createApiResponse([
        'items' => $models
    ]);
  }

  /**
   * @Route("/{id<\d+>}", name="droit_devoir_partie_new")
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
