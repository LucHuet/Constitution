<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Partie;
use App\Service\CheckStepService;

class IndexController extends AbstractController
{
      /**
     * @Route("/", name="index")
     */
     public function index(CheckStepService $checkStep)
     {

$checkStep->ckeck2Acteurs();
       $parties = $this->getDoctrine()
           ->getRepository(Partie::class)
           ->findBy(['user' => $this->getUser()]);
       $this->getUser();
         return $this->render('index/index.html.twig', ['parties'=>$parties]);
     }
}
