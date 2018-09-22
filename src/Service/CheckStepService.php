<?php
namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;
use App\Repository\PartieRepository;

class CheckStepService
{
    private $token_storage;
    private $acteurPartieRepository;
    private $partieRepository;
    private $pouvoirPartieRepository;

    function __construct(TokenStorageInterface $token_storage,
    ActeurPartieRepository $acteurPartieRepository,
    PartieRepository $partieRepository,
    PouvoirPartieRepository $pouvoirPartieRepository)
    {
      $this->token_storage = $token_storage;
      $this->acteurPartieRepository = $acteurPartieRepository;
      $this->partieRepository = $partieRepository;
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
      if(null == $session->get('partie_courante_id')){
        return 'partie_liste';
      }

      //on verifie que la partie en cours est bien à l'utilisateur courant
      $partie_courante_id = $session->get('partie_courante_id');
      $partie_courante = $this->partieRepository->find($partie_courante_id);
      dump($partie_courante->getUser());
      dump($this->token_storage->getToken()->getUser());
      if($partie_courante->getUser() != $this->token_storage->getToken()->getUser())
      {
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
      $partie_courante_id = $session->get('partie_courante_id');
      $partie_courante = $this->partieRepository->find($partie_courante_id);
      $acteurs = $this->acteurPartieRepository->findBy(['partie' => $partie_courante]);
      if(count($acteurs) < 2)
      {
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
      $partie_courante_id = $session->get('partie_courante_id');
      $partie_courante = $this->partieRepository->find($partie_courante_id);
      $acteurs = $this->acteurPartieRepository->findBy(['partie' => $partie_courante]);
      if(count($acteurs) < 1)
      {
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
      $partie_courante_id = $session->get('partie_courante_id');
      $partie_courante = $this->partieRepository->find($partie_courante_id);
      $pouvoirsPartie = $this->pouvoirPartieRepository->findBy(['partie' => $partie_courante]);
      if(count($pouvoirsPartie) < 1)
      {
        return 'pouvoir_partie_new';
      }

      return null;

    }

}
