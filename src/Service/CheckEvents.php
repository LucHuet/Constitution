<?php

namespace App\Service;
use App\Repository\ActeurRepository;
use App\Repository\PouvoirRepository;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;

use Symfony\Component\HttpFoundation\Session\Session;

class CheckEvents
{

  private $acteurPartieRepository;
  private $acteurRepository;
  private $pouvoirPartieRepository;
  private $pouvoirRepository;

  public function __construct(
    ActeurPartieRepository $acteurPartieRepository,
    ActeurRepository $acteurRepository,
    PouvoirPartieRepository $pouvoirPartieRepository,
    PouvoirRepository $pouvoirRepository
  )
  {
      $this->acteurPartieRepository = $acteurPartieRepository;
      $this->acteurRepository = $acteurRepository;
      $this->pouvoirPartieRepository = $pouvoirPartieRepository;
      $this->pouvoirRepository = $pouvoirRepository;
  }

  public function checkEvent1()
  {
    /*scénario de cet event :
    le chef d'état est devenu fou, il pourrait utiliser certains de ses pouvoirs
    pour mettre le chao dans le pays.
    Il faut vérifier si il y a au moins 1 chef d'état et si il possede des pouvoirs
    qui peuvent mettre en danger le pays.
    Si il en possede mais qu'il n'est pas le seul, ça va : return true
    mais si il est le seul alors cet evenement est un echec : return false
    */
    $listePouvoirsDangereux = [33, 331, 332, 333];
    $session = new Session();
    $partieCourante = $session->get('partieCourante');

    $chefEtatType = $this->acteurRepository->findOneBy(['type' => 'Chef d\'état']);
    $chefsEtatPartie = $this->acteurPartieRepository->findBy(['partie' => $partieCourante->getId(), 'typeActeur' => $chefEtatType->getId()]);
    $listePouvoirsDangereuxPartie = $this->pouvoirPartieRepository->findByListOfPouvoirId($listePouvoirsDangereux, $partieCourante);
    if(count($chefsEtatPartie) == 0 or count($listePouvoirsDangereuxPartie) == 0)
    {//il n'y a pas d'acteurs qui sont des chef d'état
    //ou il n'y a pas de pouvoir dangereux dans cette partie
    //donc ce test n'a pas de sens
      return null;
    }else{
      //on verifie si les pouvoirs dangereux sont partagé, il n'y a pas de problème
      foreach($listePouvoirsDangereuxPartie as $pouvoirDangereuxPartie)
      { $duplicat = 0;
        foreach($listePouvoirsDangereuxPartie as $pouvoirDangereuxPartie2)
        {
          if($pouvoirDangereuxPartie->getPouvoir()==$pouvoirDangereuxPartie2->getPouvoir())
          {
            $duplicat++;
          }
        }
        if($duplicat>1)
        {
          return true;
        }
      }
      //les pouvoirs dangereux ne sont pas partagé,
      //on vérifie si c'est un chef d'état (seul acteur à pouvoir être seul)
      //qui possede le pouvoir
      foreach($chefsEtatPartie as $chefEtat)
      {
        foreach($chefEtat->getPouvoirParties() as $pouvoirPartie)
        {
          if(in_array($pouvoirPartie->getPouvoir()->getId(), $listePouvoirsDangereux))
          {
            return false;
          }
        }
      }
      return true;
    }
  }

}
