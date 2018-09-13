<?php
namespace App\DataFixtures;

use App\Entity\ConditionPouvoir;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ConditionsPouvoirFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $conditions = [];
      $conditions[] = new ConditionPouvoir("L’application du pouvoir est obligatoire ou non.");
      $conditions[] = new ConditionPouvoir("L’exécution du pouvoir doit être déclenché par un acteur extérieur.");
      $conditions[] = new ConditionPouvoir("Une proportion des membres du groupe est nécessaire pour provoquer l’application du pouvoir.");
      $conditions[] = new ConditionPouvoir("Plusieurs acteurs doivent être réunis pour appliquer ce pouvoir.");
      $conditions[] = new ConditionPouvoir("Le déclenchement du pouvoir doit être soumis à d’autres acteurs.");
      $conditions[] = new ConditionPouvoir("L’application du pouvoir peut être stoppé par un autre acteur.");
      $conditions[] = new ConditionPouvoir("L’application du pouvoir peut être stoppé par plusieurs acteurs communément d’accord.");

      foreach ($conditions as $condition) {
            $manager->persist($condition);
      }

      $manager->flush();
    }
}
