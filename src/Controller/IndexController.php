<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Partie;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $parties = $this->getDoctrine()
           ->getRepository(Partie::class)
           ->findBy(['user' => $this->getUser()]);
        $this->getUser();
        return $this->render('index/index.html.twig', ['parties'=>$parties]);
    }
}
