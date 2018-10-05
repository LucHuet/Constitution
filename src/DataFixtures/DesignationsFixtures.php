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
        "L'acteur est élu",
        0,
        0,
        2
      );
      $designations[] = new Designation(
        "Nomination",
        "L'acteur est nommé",
        -1,
        -1,
        0
      );
      $designations[] = new Designation(
        "Tirage au sort",
        "L'acteur est tiré au sort",
        0,
        1,
        3
      );
      $designations[] = new Designation(
        "Hérédité",
        "L'acteur a hérité de sa situation à la naissance",
        1,
        -1,
        -1
      );
      $designations[] = new Designation(
        "Concours",
        "L'acteur a accedé à sa situation apres un concours",
        1,
        0,
        1
      );

      foreach ($designations as $designation) {
            $manager->persist($designation);
      }

      $manager->flush();
    }
}
