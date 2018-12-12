<?php
namespace App\DataFixtures;

use App\Entity\Acteur;
use App\Entity\CountryDescription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActeursFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $acteurs = [];
      $acteurs[] = new Acteur(
        "Chef d'état",
        "Le chef d'État est la personne qui exerce l'autorité suprême d'un Etat, qui représente l'ensemble de la nation dans le pays et dans les relations internationales.",
        "chef.png"
      );
      $acteurs[] = new Acteur(
        "Peuple",
        "Le peuple, un peuple l'ensemble des personnes soumises aux mêmes lois et qui forment une nation.",
        "peuple.png"
      );
      $acteurs[] = new Acteur(
        "Parlement",
        "Assemblée ou ensemble des chambres qui détiennent le pouvoir législatif.",
        "parlement.png"
      );

      $acteurs[] = new Acteur(
        "Gouvernement",
        "Le gouvernement est l'organe (personnes ou services) investi du pouvoir exécutif afin de diriger un Etat.",
        "gouvernement.png"
      );

      $acteurs[] = new Acteur(
        "Institution Judiciaire",
        "Ensemble des juridictions nationales (tribunaux, cours, conseils) chargées de juger les litiges des personne privées et des personnes publiques, et de sanctionner les auteurs d'infractions à la loi pénale.",
        "justice.png"
      );

      $acteurs[] = new Acteur(
        "Conseil",
        "Réunion de personnes qui délibèrent, donnent leur avis sur des affaires publiques.",
        "conseil.png"
      );

      $acteurs[] = new Acteur(
        "Acteur personnalisé",
        "Un acteur dont vous décidez de la forme sans aide.",
        "question.png"
      );

      foreach ($acteurs as $acteur) {
            $acteur->addCountryDescription(new CountryDescription("France", "Description de l'acteur ".$acteur->getType()." à completer."));
            $manager->persist($acteur);
      }

      $manager->flush();
    }
}
