<?php
namespace App\DataFixtures;

use App\Entity\Designation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DesignationsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $designations = [];
      $designations[] = new Designation(
        "Election",
        "L'acteur est élu"
      );
      $designations[] = new Designation(
        "Nomination",
        "L'acteur est nommé"
      );
      $designations[] = new Designation(
        "Tirage au sort",
        "L'acteur est tiré au sort"
      );
      $designations[] = new Designation(
        "Hérédité",
        "L'acteur a hérité de sa situation à la naissance"
      );
      $designations[] = new Designation(
        "Concours",
        "L'acteur a accedé à sa situation apres un concours"
      );

      foreach ($designations as $designation) {
            $manager->persist($designation);
      }

      $manager->flush();
    }
}
