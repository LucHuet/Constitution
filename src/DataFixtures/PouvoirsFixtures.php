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

      $pouvoir1 = new Pouvoir(
        1,
        "Constitutionnel",
        "Ensemble des pouvoirs constitutionnels du pays",
        "Constitutionnel"
      );
      $manager->persist($pouvoir1);

      $pouvoir1_1 = new Pouvoir(
        11,
        "Modifie la constitution",
        "",
        "Constitutionnel",
        $pouvoir1
      );
      $manager->persist($pouvoir1_1);

      $pouvoirs1_1_1 = new Pouvoir(
        111,
        "Propose une modification de la constitution",
        "",
        "Constitutionnel",
        $pouvoir1_1
      );
      $manager->persist($pouvoirs1_1_1);

      $pouvoirs1_1_2 = new Pouvoir(
        112,
        "Adopte une modification de la constitution",
        "",
        "Constitutionnel",
        $pouvoir1_1
      );
      $manager->persist($pouvoirs1_1_2);

      $pouvoir1_2 = new Pouvoir(
        12,
        "Veil au respect de la constitution",
        "",
        "Constitutionnel",
        $pouvoir1
      );
      $manager->persist($pouvoir1_2);

      $pouvoir1_3 = new Pouvoir(
        13,
        "Juge conformité de la loi à la constitution",
        "",
        "Constitutionnel",
        $pouvoir1
      );
      $manager->persist($pouvoir1_3);

      $pouvoir2 = new Pouvoir(
        2,
        "Législatif",
        "Ensemble des pouvoirs législatifs du pays",
        "Législatif",
        null
      );
      $manager->persist($pouvoir2);

      $pouvoir2_1 = new Pouvoir(
        21,
        "Crée la loi",
        "Création complète de la loi",
        "Législatif",
        $pouvoir2
      );
      $manager->persist($pouvoir2_1);

      $pouvoir2_1_1 = new Pouvoir(
        211,
        "Propose la loi",
        "",
        "Législatif",
        $pouvoir2_1
      );
      $manager->persist($pouvoir2_1_1);

      $pouvoir2_1_2 = new Pouvoir(
        212,
        "Amende la loi",
        "Modification de la loi avant le vote",
        "Législatif",
        $pouvoir2_1
      );
      $manager->persist($pouvoir2_1_2);

      $pouvoir2_1_3 = new Pouvoir(
        213,
        "Vote la loi",
        "",
        "Législatif",
        $pouvoir2_1
      );
      $manager->persist($pouvoir2_1_3);

      $pouvoir2_1_4 = new Pouvoir(
        214,
        "Promulgue la loi",
        "Confirme la validité de la loi et la signe",
        "Législatif",
        $pouvoir2_1
      );
      $manager->persist($pouvoir2_1_4);

      $pouvoir2_2 = new Pouvoir(
        22,
        "Gestion des traités internationaux",
        "",
        "Législatif",
        $pouvoir2
      );
      $manager->persist($pouvoir2_2);

      $pouvoir2_3 = new Pouvoir(
        23,
        "Création de référundum",
        "",
        "Législatif",
        $pouvoir2
      );
      $manager->persist($pouvoir2_3);

      $pouvoir2_4 = new Pouvoir(
        24,
        "Gestion du budget de l'état",
        "",
        "Législatif",
        $pouvoir2
      );
      $manager->persist($pouvoir2_4);

      $pouvoir3 = new Pouvoir(
        3,
        "Exécutif",
        "Ensemble des pouvoirs exécutifs du pays",
        "Exécutif",
        null
      );
      $manager->persist($pouvoir3);

      $pouvoir3_1 = new Pouvoir(
        31,
        "Gère l'administration",
        "",
        "Exécutif",
        $pouvoir3
      );
      $manager->persist($pouvoir3_1);

      $pouvoir3_1_1 = new Pouvoir(
        311,
        "Gestion des ministres",
        "",
        "Exécutif",
        $pouvoir3_1
      );
      $manager->persist($pouvoir3_1_1);

      $pouvoir3_1_2 = new Pouvoir(
        312,
        "Création de textes réglementaires",
        "",
        "Exécutif",
        $pouvoir3_1
      );
      $manager->persist($pouvoir3_1_2);

      $pouvoir3_2 = new Pouvoir(
        32,
        "Préside le conseil des ministres",
        "",
        "Exécutif",
        $pouvoir3
      );
      $manager->persist($pouvoir3_2);

      $pouvoir3_3 = new Pouvoir(
        33,
        "Gères les pouvoirs militaires",
        "",
        "Exécutif",
        $pouvoir3
      );
      $manager->persist($pouvoir3_3);

      $pouvoir3_3_1 = new Pouvoir(
        331,
        "Gère l'armée",
        "",
        "Exécutif",
        $pouvoir3_3
      );
      $manager->persist($pouvoir3_3_1);

      $pouvoir3_3_2 = new Pouvoir(
        332,
        "Mets en place l'état de siège",
        "",
        "Exécutif",
        $pouvoir3_3
      );
      $manager->persist($pouvoir3_3_2);

      $pouvoir3_3_3 = new Pouvoir(
        333,
        "Prends les pleins pouvoirs",
        "",
        "Exécutif",
        $pouvoir3_3
      );
      $manager->persist($pouvoir3_3_3);

      $pouvoir3_3_4 = new Pouvoir(
        334,
        "Déclare la guerre et signe la paix",
        "",
        "Exécutif",
        $pouvoir3_3
      );
      $manager->persist($pouvoir3_3_4);

      $pouvoir3_4 = new Pouvoir(
        34,
        "Détermine la politique de la nation",
        "",
        "Exécutif",
        $pouvoir3
      );
      $manager->persist($pouvoir3_4);

      $pouvoir4 = new Pouvoir(
        4,
        "Judiciaire",
        "",
        "Judiciaire",
        null
      );
      $manager->persist($pouvoir4);

      $pouvoir4_1 = new Pouvoir(
        41,
        "Statut exceptionnel",
        "",
        "Judiciaire",
        $pouvoir4
      );
      $manager->persist($pouvoir4_1);

      $pouvoir4_1_1 = new Pouvoir(
        411,
        "Droit de grâce",
        "",
        "Judiciaire",
        $pouvoir4_1
      );
      $manager->persist($pouvoir4_1_1);

      $pouvoir4_1_2 = new Pouvoir(
        412,
        "Immunité",
        "",
        "Judiciaire",
        $pouvoir4_1
      );
      $manager->persist($pouvoir4_1_2);

      $pouvoir4_2 = new Pouvoir(
        42,
        "Juge le respect de la loi",
        "",
        "Judiciaire",
        $pouvoir4
      );
      $manager->persist($pouvoir4_2);

      $pouvoir5 = new Pouvoir(
        5,
        "Symbolique",
        "",
        "Symbolique",
        null
      );
      $manager->persist($pouvoir5);

      $pouvoir5_1 = new Pouvoir(
        51,
        "Père de la nation",
        "",
        "Symbolique",
        $pouvoir5
      );
      $manager->persist($pouvoir5_1);

      $pouvoir5_2 = new Pouvoir(
        52,
        "Représentant du peuple",
        "",
        "Symbolique",
        $pouvoir5
      );
      $manager->persist($pouvoir5_2);

      $pouvoir5_3 = new Pouvoir(
        53,
        "Déscendant de Dieu",
        "",
        "Symbolique",
        $pouvoir5
      );
      $manager->persist($pouvoir5_3);

      $manager->flush();
    }
}
