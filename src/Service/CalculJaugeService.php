<?php
namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\DesignationPartie;
use App\Entity\PouvoirPartie;

class CalculJaugeService
{


    function __construct()
    {

    }

    public function ajoutActeur()
    {

    }

    public function ajoutDesignation(DesignationPartie $designationPartie)
    {
      //la force de l'acteur qui désigne est augmentée de 1
      $acteurDesignant = $designationPartie->getActeurDesignant();
      $acteurDesignant->setForceActeur($acteurDesignant->getForceActeur() + 1);
      //on enregistre les scores des jauges après la désignation
      $partieCourante = $designationPartie->getPartie();
      $partieCourante
        ->setStabilite($partieCourante->getStabilite() + $acteurDesignant->getStabilite() + $designationPartie->getStabilite())
        ->setDemocratie($partieCourante->getDemocratie() + $acteurDesignant->getDemocratie() + $designationPartie->getDemocratie())
        ->setEquilibre($partieCourante->getEquilibre() + $acteurDesignant->getEquilibre() + $designationPartie->getEquilibre());

    }

    public function ajoutPouvoir(PouvoirPartie $pouvoirPartie)
    {
        foreach($pouvoirPartie->getActeurPossedant() as $acteurPossedant)
        {
          //on ajoute la force du pouvoir à l'acteur, on ajoute + 1 car pour le moment, le pouvoir n'a pas de condition
          $acteurPossedant->setForceActeur(
              $acteurPossedant->getForceActeur() + $pouvoirPartie->getImportance() +1
            );
        }

        //on diminue l'influence du pouvoir -1 car il n'a pas encore de condition
        $pouvoirPartie->setStabilite($pouvoirPartie->getStabilite()-1);
        $pouvoirPartie->setEquilibre($pouvoirPartie->getEquilibre()-1);
        $pouvoirPartie->setDemocratie($pouvoirPartie->getDemocratie()-1);

        $partieCourante = $pouvoirPartie->getPartie();
        $partieCourante
          ->setStabilite($partieCourante->getStabilite() + $pouvoirPartie->getStabilite())
          ->setDemocratie($partieCourante->getDemocratie() + $pouvoirPartie->getDemocratie())
          ->setEquilibre($partieCourante->getEquilibre() + $pouvoirPartie->getEquilibre());

    }

    public function ajoutCondition($conditionPouvoirPartie)
    {
      if(1 == count($conditionPouvoirPartie->getPouvoirPartie()->getConditionsPouvoirs()))
      {
        $conditionPouvoirPartie->getPouvoirPartie()->setStabilite($conditionPouvoirPartie->getPouvoirPartie()->getStabilite()+1);
        $conditionPouvoirPartie->getPouvoirPartie()->setEquilibre($conditionPouvoirPartie->getPouvoirPartie()->getEquilibre()+1);
        $conditionPouvoirPartie->getPouvoirPartie()->setDemocratie($conditionPouvoirPartie->getPouvoirPartie()->getDemocratie()+1);
      }

      foreach($conditionPouvoirPartie->getPouvoirPartie()->getActeurPossedant() as $acteurPossedant)
      {
        //on retire -1 à la force du possedant du pouvoir car maintenant, il y a une condition
        $acteurPossedant->setForceActeur(
            $acteurPossedant->getForceActeur() - 1
          );
        if($acteurPossedant->getTypeActeur() == "Peuple")
        {
          $conditionPouvoirPartie->setStabilite($conditionPouvoirPartie->getStabilite() + 0);
          $conditionPouvoirPartie->setEquilibre($conditionPouvoirPartie->getEquilibre() + 1);
          $conditionPouvoirPartie->setDemocratie($conditionPouvoirPartie->getDemocratie() + 2);
        }elseif($acteurPossedant->getTypeActeur() == "Autorité Indépendante")
        {
          $conditionPouvoirPartie->setStabilite($conditionPouvoirPartie->getStabilite() + 1);
          $conditionPouvoirPartie->setEquilibre($conditionPouvoirPartie->getEquilibre() + 1);
          $conditionPouvoirPartie->setDemocratie($conditionPouvoirPartie->getDemocratie() + 1);
        }elseif($acteurPossedant->getTypeActeur() == "Groupe d'individus")
        {
          //a definir
        }

        $partieCourante = $conditionPouvoirPartie->getPartie();
        $partieCourante
          ->setStabilite($partieCourante->getStabilite() + $conditionPouvoirPartie->getStabilite())
          ->setDemocratie($partieCourante->getDemocratie() + $conditionPouvoirPartie->getDemocratie())
          ->setEquilibre($partieCourante->getEquilibre() + $conditionPouvoirPartie->getEquilibre());


      }


    }



}
