<?php
namespace App\DataFixtures;

use App\Entity\ValeurPrincipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ValeursPrincipesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $valeursPrincipes = [];
      $valeursPrincipes[] = new ValeurPrincipe("Souveraineté nationale");
      $valeursPrincipes[] = new ValeurPrincipe("Libre détermination des peuples");
      $valeursPrincipes[] = new ValeurPrincipe("Liberté");
      $valeursPrincipes[] = new ValeurPrincipe("Egalité");
      $valeursPrincipes[] = new ValeurPrincipe("Fraternité");
      $valeursPrincipes[] = new ValeurPrincipe("Non discrimination (Origine, Opinion, Croyance)");
      $valeursPrincipes[] = new ValeurPrincipe("Aide aux plus démunis");
      $valeursPrincipes[] = new ValeurPrincipe("Laicité");
      $valeursPrincipes[] = new ValeurPrincipe("Pas de conquêtes d'autres pays");

      foreach ($valeursPrincipes as $valeurPrincipe) {
            $manager->persist($valeurPrincipe);
      }

      $manager->flush();
    }
}
