<?php
namespace App\DataFixtures;

use App\Entity\Acteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActeursFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $acteurs = [];
      $acteurs[] = new Acteur(
        "Groupe d'individus",
        0,
        0,
        0
      );
      $acteurs[] = new Acteur(
        "Peuple",
        0,
        3,
        4
      );
      $acteurs[] = new Acteur(
        "Autorité Indépendante",
        3,
        2,
        1
      );

      foreach ($acteurs as $acteur) {
            $manager->persist($acteur);
      }

      $manager->flush();
    }
}
