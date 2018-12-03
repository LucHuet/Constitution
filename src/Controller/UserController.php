<?php
// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Form\ImageType;

class UserController extends AbstractController
{

  /**
   * @Route("/profile", name="user_profile", methods="GET|POST")
   */
  public function profile(Request $request){

    $user = $this->getUser();

    $image= $this->getDoctrine()
        ->getRepository(Image::class)
        ->findOneByUser($user);

    if($image == null){
      $image = new Image();
    }

    $form = $this->createForm(ImageType::class, $image);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      $image->setUser($user);
      $em = $this->getDoctrine()->getManager();
      $em->persist($image);
      $em->flush();

      return $this->redirectToRoute('user_profile');
    }


    return $this->render('user/userProfile.html.twig', array("user"=>$user, 'form' => $form->createView()));
  }

}
