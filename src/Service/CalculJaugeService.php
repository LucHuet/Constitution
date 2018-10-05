<?php
namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\ActeurPartieRepository;
use App\Repository\PouvoirPartieRepository;
use App\Entity\Partie;
use App\Entity\ActeurPartie;
use App\Entity\DesignationPartie;

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

    public function ajoutPouvoir()
    {

    }

    public function ajoutCondition()
    {

    }



}
