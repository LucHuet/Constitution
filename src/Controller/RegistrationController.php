<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Form\UserType;
use App\Form\UserUpdateType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration", methods="GET|POST")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->container->get('security.token_storage')->setToken($token);
            $this->container->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('partie_liste');

        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
    * @Route("/login", name="login")
    */
   public function login(AuthenticationUtils $authenticationUtils)
   {
       // get the login error if there is one
       $error = $authenticationUtils->getLastAuthenticationError();

       // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render('security/login.html.twig', array(
           'last_username' => $lastUsername,
           'error'         => $error,
       ));
   }

   /**
    * @Route("/updateProfile", name="update_profile", methods="GET|POST")
    */
   public function updateProfile(Request $request){

     $user = $this->getUser();
     $password = $user->getPassword();
     dump($password);
     $user->setPlainPassword($password);

     $form = $this->createForm(UserUpdateType::class, $user);

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid())
     {
       dump($form);
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($user);
         $entityManager->flush();

         return $this->redirectToRoute('user_profile');

     }

     return $this->render(
         'user/userUpdateForm.html.twig',
         array('user' => $user, 'form' => $form->createView())
     );
   }
}
