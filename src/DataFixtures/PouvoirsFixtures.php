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
      $pouvoirs[] = new Pouvoir("Juge le respect des normes à la constitution", "Constitutionnel", 3, true);
      $pouvoirs[] = new Pouvoir("Promulgue les lois", "Exécutif", 3, false);
      $pouvoirs[] = new Pouvoir("Provoque un référendum sur une norme", "Législatif", 2, false);
      $pouvoirs[] = new Pouvoir("Change la constitution", "Constitutionnel", 3, false);
      $pouvoirs[] = new Pouvoir("Crée des textes réglementaires", "Exécutif", 2, false);
      $pouvoirs[] = new Pouvoir("Contrôle l’armée", "Exécutif", 3, false);
      $pouvoirs[] = new Pouvoir("Négocie et ratifie les traités", "Législatif", 2, false);
      $pouvoirs[] = new Pouvoir("Possède le droit de grâce", "Judiciaire", 1, false);
      $pouvoirs[] = new Pouvoir("Peut destituer un autre acteur", "Constitutionnel", 3, true);
      $pouvoirs[] = new Pouvoir("Peut prendre les pleins pouvoirs", "Constitutionnel", 3, false);
      $pouvoirs[] = new Pouvoir("Possède une immunité judiciaire", "Judiciaire", 1, false);
      $pouvoirs[] = new Pouvoir("Gère l’administration", "Exécutif", 3, false);
      $pouvoirs[] = new Pouvoir("Propose des lois", "Législatif", 3, false);
      $pouvoirs[] = new Pouvoir("Met en place la réalisation des lois", "Exécutif", 3, false);
      $pouvoirs[] = new Pouvoir("Vote la loi", "Législatif", 3, false);
      $pouvoirs[] = new Pouvoir("Contrôle la réalisation d’un autre pouvoir", "Constitutionnel", 2, true);
      $pouvoirs[] = new Pouvoir("Contrôle du travail d’un autre acteur", "Constitutionnel", 2, true);
      $pouvoirs[] = new Pouvoir("Contrôle une désignation", "Constitutionnel", 3, true);
      $pouvoirs[] = new Pouvoir("Contrôle l’indépendance des pouvoirs", "Constitutionnel", 3, true);
      $pouvoirs[] = new Pouvoir("Contrôle les droits et les libertés", "Constitutionnel", 2, true);
      $pouvoirs[] = new Pouvoir("Juge le respect de la loi", "Judiciaire", 3, false);

      foreach ($pouvoirs as $pouvoir) {
            $manager->persist($pouvoir);
      }

      $manager->flush();
    }
}
