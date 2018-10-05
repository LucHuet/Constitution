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
          $acteurPossedant->setForceActeur(
              $acteurPossedant->getForceActeur() + $pouvoirPartie->getImportance()
            );
          //on diminue l'influence du pouvoir -1 car il n'a pas encore de condition
          $acteurPossedant->setStabilite($acteurPossedant->getStabilite()-1);
          $acteurPossedant->setEquilibre($acteurPossedant->getEquilibre()-1);
          $acteurPossedant->setDemocratie($acteurPossedant->getDemocratie()-1);
        }

        $partieCourante = $pouvoirPartie->getPartie();
        $partieCourante
          ->setStabilite($partieCourante->getStabilite() + $pouvoirPartie->getStabilite())
          ->setDemocratie($partieCourante->getDemocratie() + $pouvoirPartie->getDemocratie())
          ->setEquilibre($partieCourante->getEquilibre() + $pouvoirPartie->getEquilibre());

    }

    public function ajoutCondition()
    {

    }



}
