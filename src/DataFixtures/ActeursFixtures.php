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
      $acteurs[] = new Acteur("Groupe d'individus");
      $acteurs[] = new Acteur("Peuple");
      $acteurs[] = new Acteur("Autorité Indépendante");

      foreach ($acteurs as $acteur) {
            $manager->persist($acteur);
      }

      $manager->flush();
    }
}
