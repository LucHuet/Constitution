<?php
namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;

class CheckStepService
{
    private $token_storage;
    private $acteurPartieRepository;
    private $pouvoirPartieRepository;

    function __construct(
      TokenStorageInterface $token_storage,
      ActeurPartieRepository $acteurPartieRepository,
      PouvoirPartieRepository $pouvoirPartieRepository
    )
    {
      $this->token_storage = $token_storage;
      $this->acteurPartieRepository = $acteurPartieRepository;
      $this->pouvoirPartieRepository = $pouvoirPartieRepository;
    }

    /**
     * function checkLogin
     *
     * verification qu'un utilisateur est loggé
     * si aucun utilisateur n'est loggé, on doit se logger
     *
     * @return null ou la route appropriée
     */
    public function checkLogin( )
    {
      if('anon.' == $this->token_storage->getToken()->getUser())
      {
        $session = new Session();
        $errorMessage = 'Redirection car il n\'y a pas d\'utilisateur';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'index';
      }
        return null;
    }

    /**
     * function checkPartie
     *
     * verification qu'une partie est en cours
     * si aucune partie n'est en cours, on doit en choisir une
     *
     * @return null ou la route appropriée
     */
    public function checkPartie()
    {
      if(null != $this->checkLogin())
      {
        return $this->checkLogin();
      }

      $session = new Session();
      //on verifie qu'il y a une partie en cours
      if(null == $session->get('partieCourante')){
        $errorMessage = 'Redirection car il n\'y a pas de partie';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'partie_liste';
      }

      //on verifie que la partie en cours est bien à l'utilisateur courant
      $partieCourante = $session->get('partieCourante');
      if($partieCourante->getUser()->getId() != $this->token_storage->getToken()->getUser()->getId())
      {
        $errorMessage = 'Redirection car la partie séléctionnée n\'est pas votre partie';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'index';
      }
      return null;
    }

    /**
     * function ckeck2Acteurs
     *
     * verification qu'une partie a aux moins 2 acteurs
     * si moins de 2 acteurs ont été crées, on doit créer un acteur
     *
     * @return null ou la route appropriée
     */
    public function ckeck2Acteurs()
    {
      if(null != $this->checkPartie())
      {
        return $this->checkPartie();
      }

      $session = new Session();
      $partieCourante = $session->get('partieCourante');
      $acteurs = $this->acteurPartieRepository->findBy(['partie' => $partieCourante]);
      if(count($acteurs) < 2)
      {
        $session = new Session();
        $errorMessage = 'Redirection car il faut 2 acteurs';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'acteur_partie_new';
      }
      return null;

    }

    /**
     * function ckeckActeur
     *
     * verification qu'une partie a aux moins 1 acteur
     * si il n'y a pas d'acteur, on doit en créer
     *
     * @return null ou la route appropriée
     */
    public function ckeckActeur()
    {
      if(null != $this->checkPartie())
      {
        return $this->checkPartie();
      }

      $session = new Session();
      $partieCourante = $session->get('partieCourante');
      //merge à faire ?
      $acteurs = $this->acteurPartieRepository->findBy(['partie' => $partieCourante]);
      if(count($acteurs) < 1)
      {
        $session = new Session();
        $errorMessage = 'Redirection car il n\'y a pas d\'acteur';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'acteur_partie_new';
      }

      return null;

    }

    /**
     * function checkPouvoir
     *
     * verification qu'une partie a aux moins 1 pouvoir
     * si il n'y a pas de pouvoir, on doit en créer
     *
     * @return null ou la route appropriée
     */
    public function checkPouvoir()
    {
      $session = new Session();
      $partieCourante = $session->get('partieCourante');
      $pouvoirsPartie = $this->pouvoirPartieRepository->findBy(['partie' => $partieCourante]);
      if(count($pouvoirsPartie) < 1)
      {
        return 'pouvoir_partie_new';
      }

      return null;

    }

}
