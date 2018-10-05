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
      $conditions[] = new ConditionPouvoir(
        "Pas de condition",
        "Aucune condition n'a été choisi pour ce pouvoir pour le moment.",
         -1,
         -1,
         -1
       );
      $conditions[] = new ConditionPouvoir(
        "Déclenchement exterieur",
        "L’exécution du pouvoir doit être déclenché par un ou plusieurs acteurs extérieur.",
        1,
        1,
        1
      );
      $conditions[] = new ConditionPouvoir(
        "Authorisation exterieur necessaire",
        "Le déclenchement du pouvoir doit autorisé par d’autres acteurs.",
        1,
        1,
        1
      );
      $conditions[] = new ConditionPouvoir(
        "Plusieurs acteurs necessaires",
        "Plusieurs acteurs doivent être réunis pour appliquer ce pouvoir.",
        1,
        1,
        1
      );
      $conditions[] = new ConditionPouvoir(
        "Stoppable par acteurs exterieurs",
        "L’application du pouvoir peut être stoppé par un ou plusieurs acteurs communément d’accord.",
        0,
        1,
        2
      );

      foreach ($conditions as $condition) {
            $manager->persist($condition);
      }

      $manager->flush();
    }
}
