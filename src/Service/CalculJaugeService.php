<?php
namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\DesignationPartie;
use App\Entity\ConditionPouvoirPartie;
use App\Entity\PouvoirPartie;

class CalculJaugeService implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preRemove',
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // only act on some "Product" entity
        if ($entity instanceof DesignationPartie) {

            dump("persist designation partie");
            $this->ajoutDesignation($entity);

        }elseif($entity instanceof PouvoirPartie)
        {
            dump("persist pouvoir partie");
            $this->ajoutPouvoir($entity);

        }elseif($entity instanceof ConditionPouvoirPartie)
        {
            dump("persist condition pouvoir partie");
            $this->ajoutCondition($entity);
        }

    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // only act on some "Product" entity
        if ($entity instanceof DesignationPartie) {

            dump("remove designation partie");
            $this->removeDesignation($entity);

        }elseif($entity instanceof PouvoirPartie)
        {
            dump("remove pouvoir partie");
            $this->removePouvoir($entity);

        }elseif($entity instanceof ConditionPouvoirPartie)
        {
            dump("remove condition pouvoir partie");
            $this->removeCondition($entity);
        }
    }

    public function ajoutDesignation(DesignationPartie $designationPartie)
    {
      $session = new Session();
      $session->getFlashBag()->add('notice', "NOUVELLE DESIGNATION DE ".$designationPartie->getActeurDesignant()." A ".$designationPartie->getActeurDesigne());
      //la force de l'acteur qui désigne est augmentée de 1
      $session->getFlashBag()->add('notice', "la force de l'acteur qui désigne ($acteurDesignant) est augmentée de 1");
      $acteurDesignant = $designationPartie->getActeurDesignant();
      $acteurDesignant->setForceActeur($acteurDesignant->getForceActeur() + 1);

      //on enregistre les scores des jauges après la désignation
      $partieCourante = $designationPartie->getPartie();

      $session->getFlashBag()->add('notice', "la partie courante (".$partieCourante->getStabilite().", ".$partieCourante->getEquilibre().", ".$partieCourante->getDemocratie().")
                                reçoit la designation (".$designationPartie->getStabilite().", ".$designationPartie->getEquilibre().", ".$designationPartie->getDemocratie().")
                                + l'acteur designant (".$acteurDesignant->getStabilite().", ".$acteurDesignant->getEquilibre().", ".$acteurDesignant->getDemocratie().")");
      $partieCourante
        ->setStabilite($partieCourante->getStabilite() + $acteurDesignant->getStabilite() + $designationPartie->getStabilite())
        ->setDemocratie($partieCourante->getDemocratie() + $acteurDesignant->getDemocratie() + $designationPartie->getDemocratie())
        ->setEquilibre($partieCourante->getEquilibre() + $acteurDesignant->getEquilibre() + $designationPartie->getEquilibre());

    }

    public function ajoutPouvoir(PouvoirPartie $pouvoirPartie)
    {
        $session = new Session();
        $session->getFlashBag()->add('notice', "NOUVEAU POUVOIR POUR ".$pouvoirPartie->getActeurPossedant()." : ".$pouvoirPartie);

        foreach($pouvoirPartie->getActeurPossedant() as $acteurPossedant)
        {
          //on ajoute la force du pouvoir à l'acteur, on ajoute + 1 car pour le moment, le pouvoir n'a pas de condition
          $session->getFlashBag()->add('notice', "le pouvoir n'a pas de condition : la force de l'acteur qui possede le pouvoir ($acteurPossedant) est augmentée de 1");
          $acteurPossedant->setForceActeur(
              $acteurPossedant->getForceActeur() + $pouvoirPartie->getImportance() +1
            );

        }

        //on diminue l'influence du pouvoir -1 car il n'a pas encore de condition
        $session->getFlashBag()->add('notice', "le pouvoir n'a pas de condition : son influence (".$pouvoirPartie->getStabilite().", ".$pouvoirPartie->getEquilibre().", ".$pouvoirPartie->getDemocratie().") diminue de -1");
        $pouvoirPartie->setStabilite($pouvoirPartie->getStabilite()-1);
        $pouvoirPartie->setEquilibre($pouvoirPartie->getEquilibre()-1);
        $pouvoirPartie->setDemocratie($pouvoirPartie->getDemocratie()-1);

        $partieCourante = $pouvoirPartie->getPartie();
        $session->getFlashBag()->add('notice', "la partie courante (".$partieCourante->getStabilite().", ".$partieCourante->getEquilibre().", ".$partieCourante->getDemocratie().")
                                  reçoit le pouvoir (".$pouvoirPartie->getStabilite().", ".$pouvoirPartie->getEquilibre().", ".$pouvoirPartie->getDemocratie().")");

        $partieCourante
          ->setStabilite($partieCourante->getStabilite() + $pouvoirPartie->getStabilite())
          ->setDemocratie($partieCourante->getDemocratie() + $pouvoirPartie->getDemocratie())
          ->setEquilibre($partieCourante->getEquilibre() + $pouvoirPartie->getEquilibre());

    }

    public function ajoutCondition(ConditionPouvoirPartie $conditionPouvoirPartie)
    {
      $session = new Session();
      $session->getFlashBag()->add('notice', "NOUVELLE CONDITION ".$conditionPouvoirPartie." POUR LE POUVOIR ".$conditionPouvoirPartie->getPouvoirPartie());

      if(1 == count($conditionPouvoirPartie->getPouvoirPartie()->getConditionsPouvoirs()))
      {
        $session->getFlashBag()->add('notice', "on retablie l'influence du pouvoir à +1 car il a une condition maintenant");

        $conditionPouvoirPartie->getPouvoirPartie()->setStabilite($conditionPouvoirPartie->getPouvoirPartie()->getStabilite()+1);
        $conditionPouvoirPartie->getPouvoirPartie()->setEquilibre($conditionPouvoirPartie->getPouvoirPartie()->getEquilibre()+1);
        $conditionPouvoirPartie->getPouvoirPartie()->setDemocratie($conditionPouvoirPartie->getPouvoirPartie()->getDemocratie()+1);
      }

      foreach($conditionPouvoirPartie->getPouvoirPartie()->getActeurPossedant() as $acteurPossedant)
      {
        //on retire -1 à la force du possedant du pouvoir car maintenant, il y a une condition
        $session->getFlashBag()->add('notice', "on retire -1 à la force du possedant du pouvoir car maintenant, il y a une condition");
        $acteurPossedant->setForceActeur(
            $acteurPossedant->getForceActeur() - 1
          );
        if($acteurPossedant->getTypeActeur() == "Peuple")
        {
          $session->getFlashBag()->add('notice', "l'acteur qui possede le pouvoir conditionné est le peuple donc on ajoute (0,1,2) à l'influence de la condition");
          $conditionPouvoirPartie->setStabilite($conditionPouvoirPartie->getStabilite() + 0);
          $conditionPouvoirPartie->setEquilibre($conditionPouvoirPartie->getEquilibre() + 1);
          $conditionPouvoirPartie->setDemocratie($conditionPouvoirPartie->getDemocratie() + 2);
        }elseif($acteurPossedant->getTypeActeur() == "Autorité Indépendante")
        {
          $session->getFlashBag()->add('notice', "l'acteur qui possede le pouvoir conditionné est une authorité indépendante donc on ajoute (1,1,1) à l'influence de la condition");
          $conditionPouvoirPartie->setStabilite($conditionPouvoirPartie->getStabilite() + 1);
          $conditionPouvoirPartie->setEquilibre($conditionPouvoirPartie->getEquilibre() + 1);
          $conditionPouvoirPartie->setDemocratie($conditionPouvoirPartie->getDemocratie() + 1);
        }elseif($acteurPossedant->getTypeActeur() == "Groupe d'individus")
        {
          $session->getFlashBag()->add('notice', "l'acteur qui possede le pouvoir conditionné est un groupe d'individus donc on ajoute (X,X,X) à l'influence de la condition");
          //a definir
        }

        $partieCourante = $conditionPouvoirPartie->getPartie();
        $session->getFlashBag()->add('notice', "la partie courante (".$partieCourante->getStabilite().", ".$partieCourante->getEquilibre().", ".$partieCourante->getDemocratie().")
                                  reçoit la condition (".$conditionPouvoirPartie->getStabilite().", ".$conditionPouvoirPartie->getEquilibre().", ".$conditionPouvoirPartie->getDemocratie().")");
        $partieCourante
          ->setStabilite($partieCourante->getStabilite() + $conditionPouvoirPartie->getStabilite())
          ->setDemocratie($partieCourante->getDemocratie() + $conditionPouvoirPartie->getDemocratie())
          ->setEquilibre($partieCourante->getEquilibre() + $conditionPouvoirPartie->getEquilibre());
      }

    }

    public function removeDesignation(DesignationPartie $designationPartie)
    {
      $session = new Session();
      $session->getFlashBag()->add('notice', "REMOVE DESIGNATION DE ".$designationPartie->getActeurDesignant()." A ".$designationPartie->getActeurDesigne());

      //la force de l'acteur qui désigne est augmentée de 1
      $session->getFlashBag()->add('notice', "la force de l'acteur qui désigne ($acteurDesignant) est diminuée de 1");
      $acteurDesignant = $designationPartie->getActeurDesignant();
      $acteurDesignant->setForceActeur($acteurDesignant->getForceActeur() - 1);
      //on enregistre les scores des jauges après la désignation
      $partieCourante = $designationPartie->getPartie();
      $session->getFlashBag()->add('notice', "la partie courante (".$partieCourante->getStabilite().", ".$partieCourante->getEquilibre().", ".$partieCourante->getDemocratie().")
                                est retirée de la designation (".$designationPartie->getStabilite().", ".$designationPartie->getEquilibre().", ".$designationPartie->getDemocratie().")
                                - l'acteur designant (".$acteurDesignant->getStabilite().", ".$acteurDesignant->getEquilibre().", ".$acteurDesignant->getDemocratie().")");

      $partieCourante
        ->setStabilite($partieCourante->getStabilite() - $acteurDesignant->getStabilite() - $designationPartie->getStabilite())
        ->setDemocratie($partieCourante->getDemocratie() - $acteurDesignant->getDemocratie() - $designationPartie->getDemocratie())
        ->setEquilibre($partieCourante->getEquilibre() - $acteurDesignant->getEquilibre() - $designationPartie->getEquilibre());

    }

    public function removePouvoir(PouvoirPartie $pouvoirPartie)
    {
      $session = new Session();
      $session->getFlashBag()->add('notice', "REMOVE POUVOIR POUR ".$pouvoirPartie->getActeurPossedant()." : ".$pouvoirPartie);

        foreach($pouvoirPartie->getActeurPossedant() as $acteurPossedant)
        {
          //on ajoute la force du pouvoir à l'acteur, on ajoute + 1 car pour le moment, le pouvoir n'a pas de condition
          $session->getFlashBag()->add('notice', "le pouvoir n'a pas de condition : la force de l'acteur qui possedait le pouvoir ($acteurPossedant) est diminuée de 1");
          $acteurPossedant->setForceActeur(
              $acteurPossedant->getForceActeur() - $pouvoirPartie->getImportance() - 1
            );
        }

        //on diminue l'influence du pouvoir -1 car il n'a pas encore de condition
        $session->getFlashBag()->add('notice', "le pouvoir n'avait pas de condition : son influence (".$pouvoirPartie->getStabilite().", ".$pouvoirPartie->getEquilibre().", ".$pouvoirPartie->getDemocratie().") augnmente de +1");
        $pouvoirPartie->setStabilite($pouvoirPartie->getStabilite()+1);
        $pouvoirPartie->setEquilibre($pouvoirPartie->getEquilibre()+1);
        $pouvoirPartie->setDemocratie($pouvoirPartie->getDemocratie()+1);

        $partieCourante = $pouvoirPartie->getPartie();
        $session->getFlashBag()->add('notice', "la partie courante (".$partieCourante->getStabilite().", ".$partieCourante->getEquilibre().", ".$partieCourante->getDemocratie().")
                                  est retirée du pouvoir (".$pouvoirPartie->getStabilite().", ".$pouvoirPartie->getEquilibre().", ".$pouvoirPartie->getDemocratie().")");

        $partieCourante
          ->setStabilite($partieCourante->getStabilite() - $pouvoirPartie->getStabilite())
          ->setDemocratie($partieCourante->getDemocratie() - $pouvoirPartie->getDemocratie())
          ->setEquilibre($partieCourante->getEquilibre() - $pouvoirPartie->getEquilibre());

    }

    public function removeCondition(ConditionPouvoirPartie $conditionPouvoirPartie)
    {
      $session = new Session();
      $session->getFlashBag()->add('notice', "REMOVE CONDITION ".$conditionPouvoirPartie." POUR LE POUVOIR ".$conditionPouvoirPartie->getPouvoirPartie());


      if(1 == count($conditionPouvoirPartie->getPouvoirPartie()->getConditionsPouvoirs()))
      {
        $session->getFlashBag()->add('notice', "on retire -1 à l'influence du pouvoir (inversion de : car il a une condition maintenant)");

        $conditionPouvoirPartie->getPouvoirPartie()->setStabilite($conditionPouvoirPartie->getPouvoirPartie()->getStabilite()-1);
        $conditionPouvoirPartie->getPouvoirPartie()->setEquilibre($conditionPouvoirPartie->getPouvoirPartie()->getEquilibre()-1);
        $conditionPouvoirPartie->getPouvoirPartie()->setDemocratie($conditionPouvoirPartie->getPouvoirPartie()->getDemocratie()-1);
      }

      foreach($conditionPouvoirPartie->getPouvoirPartie()->getActeurPossedant() as $acteurPossedant)
      {
        //on retire -1 à la force du possedant du pouvoir car maintenant, il y a une condition
        $acteurPossedant->setForceActeur(
            $acteurPossedant->getForceActeur() + 1
          );
        if($acteurPossedant->getTypeActeur() == "Peuple")
        {
          $session->getFlashBag()->add('notice', "l'acteur qui possedait le pouvoir conditionné est le peuple donc on retire (0,1,2) à l'influence de la condition");
          $conditionPouvoirPartie->setStabilite($conditionPouvoirPartie->getStabilite() - 0);
          $conditionPouvoirPartie->setEquilibre($conditionPouvoirPartie->getEquilibre() - 1);
          $conditionPouvoirPartie->setDemocratie($conditionPouvoirPartie->getDemocratie() - 2);
        }elseif($acteurPossedant->getTypeActeur() == "Autorité Indépendante")
        {
          $session->getFlashBag()->add('notice', "l'acteur qui possedait le pouvoir conditionné est une authorité indépendante donc on retire (1,1,1) à l'influence de la condition");
          $conditionPouvoirPartie->setStabilite($conditionPouvoirPartie->getStabilite() - 1);
          $conditionPouvoirPartie->setEquilibre($conditionPouvoirPartie->getEquilibre() - 1);
          $conditionPouvoirPartie->setDemocratie($conditionPouvoirPartie->getDemocratie() - 1);
        }elseif($acteurPossedant->getTypeActeur() == "Groupe d'individus")
        {
          $session->getFlashBag()->add('notice', "l'acteur qui possedait le pouvoir conditionné est un groupe d'individus donc on retire (X,X,X) à l'influence de la condition");
          //a definir
        }

        $partieCourante = $conditionPouvoirPartie->getPartie();
        $session->getFlashBag()->add('notice', "la partie courante (".$partieCourante->getStabilite().", ".$partieCourante->getEquilibre().", ".$partieCourante->getDemocratie().")
                                  retire la condition (".$conditionPouvoirPartie->getStabilite().", ".$conditionPouvoirPartie->getEquilibre().", ".$conditionPouvoirPartie->getDemocratie().")");

        $partieCourante
          ->setStabilite($partieCourante->getStabilite() - $conditionPouvoirPartie->getStabilite())
          ->setDemocratie($partieCourante->getDemocratie() - $conditionPouvoirPartie->getDemocratie())
          ->setEquilibre($partieCourante->getEquilibre() - $conditionPouvoirPartie->getEquilibre());
      }
    }



}
