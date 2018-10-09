<?php
namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;
use App\Repository\DesignationPartieRepository;
use App\Entity\Partie;
use App\Entity\ActeurPartie;
use App\Entity\PouvoirPartie;
use App\Entity\DesignationPartie;

class CheckStepService
{
    private $token_storage;
    private $acteurPartieRepository;
    private $pouvoirPartieRepository;
    private $designationPartieRepository;

    function __construct(
      TokenStorageInterface $token_storage,
      ActeurPartieRepository $acteurPartieRepository,
      PouvoirPartieRepository $pouvoirPartieRepository,
      DesignationPartieRepository $designationPartieRepository
    )
    {
      $this->token_storage = $token_storage;
      $this->acteurPartieRepository = $acteurPartieRepository;
      $this->pouvoirPartieRepository = $pouvoirPartieRepository;
      $this->designationPartieRepository = $designationPartieRepository;
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
        $errorMessage = 'Il n\'y a pas d\'utilisateur connecté';
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
    public function checkPartie(Partie $partieCourante = null)
    {
        // verification que l'utilisateur est loggé
        if(null != $this->checkLogin())
        {
          return $this->checkLogin();
        }

        $session = new Session();
        //on verifie qu'il y a une partie en cours
        if(null == $session->get('partieCourante')){
          $errorMessage = 'Veuillez créer une partie pour continuer';
          if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
          {
            $session->getFlashBag()->add('notice', $errorMessage);
          }
          return 'partie_liste';
        }

        //on verifie que la partie en cours est bien à l'utilisateur courant
        if(null == $partieCourante)
        {
          $partieCourante = $session->get('partieCourante');
        }
        if($partieCourante->getUser()->getId() != $this->token_storage->getToken()->getUser()->getId())
        {
          $errorMessage = 'Redirection car la partie séléctionnée n\'est pas votre partie';
          if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
          {
            $session->getFlashBag()->add('notice', $errorMessage);
          }
          return 'partie_liste';
        }
        return null;
    }

    /**
     * function check2Acteurs
     *
     * verification qu'une partie a aux moins 2 acteurs
     * si moins de 2 acteurs ont été crées, on doit créer un acteur
     *
     * @return null ou la route appropriée
     */
    public function check2Acteurs()
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
    public function checkActeur(ActeurPartie $acteur = null)
    {
      if(null != $this->checkPartie())
      {
        return $this->checkPartie();
      }

      $session = new Session();
      $partieCourante = $session->get('partieCourante');

      $acteurs = $this->acteurPartieRepository->findBy(['partie' => $partieCourante]);
      // on verifie qu'il y a au moins 1 acteur
      if(count($acteurs) < 1)
      {
        $errorMessage = 'Redirection car il n\'y a pas d\'acteur';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'acteur_partie_new';
      }

      // verification que l'acteur est bien de la partie
      if(null != $acteur && !in_array($acteur, $acteurs))
      {
        $errorMessage = 'Cette acteur n\'est pas de la partie courante';
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
    public function checkPouvoir(PouvoirPartie $pouvoirPartie = null)
    {

      if(null != $this->checkPartie())
      {
        return $this->checkPartie();
      }

      $session = new Session();
      $partieCourante = $session->get('partieCourante');
      $pouvoirsPartie = $this->pouvoirPartieRepository->findBy(['partie' => $partieCourante]);

      if(count($pouvoirsPartie) < 1)
      {
        $errorMessage = 'Redirection car il n\'y a pas de pouvoir';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'pouvoir_partie_new';
      }

      // verification que la partie est bien de la partie
      if(null != $pouvoirPartie && !in_array($pouvoirPartie, $pouvoirsPartie))
      {
        $errorMessage = 'Ce pouvoir n\'est pas de la partie courante';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'pouvoir_partie_new';
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
    public function checkDesignation(DesignationPartie $designationPartie = null)
    {

      if(null != $this->checkPartie())
      {
        return $this->checkPartie();
      }

      $session = new Session();
      $partieCourante = $session->get('partieCourante');
      $designationsPartie = $this->designationPartieRepository->findBy(['partie' => $partieCourante]);

      if(count($designationsPartie) < 1)
      {
        $errorMessage = 'Redirection car il n\'y a pas de désignation';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'designation_partie_new';
      }

      // verification que la partie est bien de la partie
      if(null != $designationPartie && !in_array($designationPartie, $designationsPartie))
      {
        $errorMessage = 'Cette désignation n\'est pas de la partie courante';
        if(!in_array($errorMessage,$session->getFlashBag()->peek('notice')))
        {
          $session->getFlashBag()->add('notice', $errorMessage);
        }
        return 'designation_partie_new';
      }
      return null;
    }

}
