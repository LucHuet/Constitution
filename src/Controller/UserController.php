<?php
// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

  /**
   * @Route("/profile", name="user_profile", methods="GET|POST")
   */
  public function profile(): Response{

    
    return $this->render('user/userProfile.html.twig');
  }

}
