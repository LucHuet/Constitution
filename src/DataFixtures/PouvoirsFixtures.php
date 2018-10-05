<?php
namespace App\DataFixtures;

use App\Entity\Pouvoir;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PouvoirsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $pouvoirs = [];
      $pouvoirs[] = new Pouvoir(
        "Propose une modification de la constitution",
        "",
        "Constitutionnel",
        3,
        -2,-2,0
      );
      $pouvoirs[] = new Pouvoir(
        "Adopte une modification de la constitution",
        "",
        "Constitutionnel",
        3,
        -2,-2,0
      );
      $pouvoirs[] = new Pouvoir(
        "Juge le respect des normes à la constitution",
        "",
        "Judiciaire",
        3,
        1,1,1
      );
      $pouvoirs[] = new Pouvoir(
        "Négocie et ratifie les traités internationaux",
        "",
        "Législatif",
        2,
        0,-1,0
      );
      $pouvoirs[] = new Pouvoir(
        "Propose des lois",
        "",
        "Législatif",
        3,
        1,-1,0
      );
      $pouvoirs[] = new Pouvoir(
        "Vote la loi",
        "",
        "Législatif",
        3,
        1,-1,0
      );
      $pouvoirs[] = new Pouvoir(
        "Mise en place et réalisation des loi",
        "",
        "Exécutif",
        3,
        0,1,0
      );
      $pouvoirs[] = new Pouvoir(
        "Provoque un référendum",
        "",
        "Autre",
        2,
        -1,1,2
      );
      $pouvoirs[] = new Pouvoir(
        "Dirige l’armée",
        "",
        "Exécutif",
        3,
        1,-1,0
      );
      $pouvoirs[] = new Pouvoir(
        "Prend les pleins pouvoirs",
        "",
        "Exécutif",
        3,
        0,-4,-4
      );
      $pouvoirs[] = new Pouvoir(
        "Droit de grâce",
        "",
        "Judiciaire",
        1,
        1,-3,-2
      );
      $pouvoirs[] = new Pouvoir(
        "Immunité judiciaire",
        "",
        "Judiciaire",
        1,
        1,-3,-2
      );
      $pouvoirs[] = new Pouvoir(
        "Sanctionne le non respect de la loi",
        "",
        "Judiciaire",
        7,
        2,-1,1
      );
      $pouvoirs[] = new Pouvoir(
        "Peut annuler la réalisation d’un autre pouvoir",
        "Le pouvoir est réalisé, on vérifie juste après",
        "Contrôle-Pouvoir",
        2,
        2,2,1
      );
      $pouvoirs[] = new Pouvoir(
        "Peut destituer un autre acteur",
        "Peut destituer un autre acteur (et donc l’ensemble de son travail au quotidien)",
        "Contrôle-Acteur",
        2,
        1,2,1
      );
      $pouvoirs[] = new Pouvoir(
        "Peut refuser une désignation",
        "",
        "Contrôle-Désignation",
        2,
        1,2,1
      );
      $pouvoirs[] = new Pouvoir(
        "Peut refuser une désignation",
        "",
        "Contrôle-Pouvoir",
        3,
        1,3,1
      );
      $pouvoirs[] = new Pouvoir(
        "Contrôle les droits et les libertés",
        "",
        "Contrôle-DroitsLibertés",
        2,
        1,2,2
      );

      foreach ($pouvoirs as $pouvoir) {
            $manager->persist($pouvoir);
      }

      $manager->flush();
    }
}
