<?php

namespace App\Service;
use App\Entity\EventPartie;
use App\Repository\ActeurRepository;
use App\Repository\PouvoirRepository;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;
use App\Repository\EventReferenceRepository;

use Symfony\Component\HttpFoundation\Session\Session;

class CheckEvents
{

  private $acteurPartieRepository;
  private $acteurRepository;
  private $pouvoirPartieRepository;
  private $eventReferenceRepository;

  public function __construct(
    ActeurPartieRepository $acteurPartieRepository,
    ActeurRepository $acteurRepository,
    PouvoirPartieRepository $pouvoirPartieRepository,
    EventReferenceRepository $eventReferenceRepository
  )
  {
      $this->acteurPartieRepository = $acteurPartieRepository;
      $this->acteurRepository = $acteurRepository;
      $this->pouvoirPartieRepository = $pouvoirPartieRepository;
      $this->eventReferenceRepository = $eventReferenceRepository;
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
    $eventReference = $this->eventReferenceRepository->findOneBy(['ref' => 'e1']);
    $eventPartie = new EventPartie();
    $eventPartie->setPartie($partieCourante);
    $eventPartie->setEventReference($eventReference);
    $chefEtatType = $this->acteurRepository->findOneBy(['type' => 'Chef d\'état']);
    $chefsEtatPartie = $this->acteurPartieRepository->findBy(['partie' => $partieCourante->getId(), 'typeActeur' => $chefEtatType->getId()]);
    $listePouvoirsDangereuxPartie = $this->pouvoirPartieRepository->findByListOfPouvoirId($listePouvoirsDangereux, $partieCourante);
    if(count($chefsEtatPartie) == 0 or count($listePouvoirsDangereuxPartie) == 0)
    {//il n'y a pas d'acteurs qui sont des chef d'état
    //ou il n'y a pas de pouvoir dangereux dans cette partie
    //donc ce test n'a pas de sens
      $eventPartie->setResultat(0);
      $eventPartie->setExplicationResultat("");
      return $eventPartie;
    }else{
      //on verifie si les pouvoirs dangereux sont partagé, il n'y a pas de problème
      $tableauPouvoirsDangereux = [];
      $tableauPouvoirsNonDangereux = [];
      foreach($listePouvoirsDangereuxPartie as $pouvoirDangereuxPartie)
      {
        //si le pouvoir dangereux n'est possedé que par 1 seule personne
        //et que cette personne est un chef d'état, alors c'est un pouvoir dangereux
        if(
          count($pouvoirDangereuxPartie->getActeurPossedant()) == 1
          and
          ($pouvoirDangereuxPartie->getActeurPossedant()->get(0)->getTypeActeur()->getType() == "Chef d'état")
        )
        {
            $tableauPouvoirsDangereux[] = $pouvoirDangereuxPartie;
        }else {
            $tableauPouvoirsNonDangereux[] = $pouvoirDangereuxPartie;
        }
      }

      if(!empty($tableauPouvoirsDangereux))
      {
        //il y a certains pouvoirs que l'on qualifie de dangereux
        $explication = "Les pouvoirs suivant sont dangereux et détenus par un chef d'état seulement :";
        foreach($tableauPouvoirsDangereux as $pouvoirPartie)
        {
          $explication.= "<br> - ".$pouvoirPartie->getPouvoir()->getNom();
        }
        $eventPartie->setResultat(2);
        $eventPartie->setExplicationResultat($explication);
        return $eventPartie;
      }else {
        $explication = "L'ensemble des pouvoirs potentielement dangereux sont partagés :";
        foreach($tableauPouvoirsNonDangereux as $pouvoirPartie)
        {
          $explication.= "<br> - ".$pouvoirPartie->getPouvoir()->getNom();
        }
        $eventPartie->setResultat(2);
        $eventPartie->setExplicationResultat($explication);
        return $eventPartie;
      }
    }
  }

}
