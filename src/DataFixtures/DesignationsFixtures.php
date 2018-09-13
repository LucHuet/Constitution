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
      $designations[] = new Designation("Election");
      $designations[] = new Designation("Nomination");
      $designations[] = new Designation("Tirage au sort");
      $designations[] = new Designation("Hérédité");
      $designations[] = new Designation("Concours");

      foreach ($designations as $designation) {
            $manager->persist($designation);
      }

      $manager->flush();
    }
}
