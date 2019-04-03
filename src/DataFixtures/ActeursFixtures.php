<?php
namespace App\DataFixtures;

use App\Entity\Acteur;
use App\Entity\CountryDescription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\PouvoirsFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActeursFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $acteurs = [];

        $pouvoir = [];
        $pouvoir[]=$this->getReference('promulgueLaLoi');
        $pouvoir[]=$this->getReference('traiteInternationaux');
        $pouvoir[]=$this->getReference('textesReglementaires');
        $pouvoir[]=$this->getReference('gestionMinistres');
        $pouvoir[]=$this->getReference('conseilMinistres');
        $pouvoir[]=$this->getReference('gestionArmee');
        $pouvoir[]=$this->getReference('pleinsPouvoirs');
        $pouvoir[]=$this->getReference('determinePolitique');
        $acteurs[] = new Acteur(
          "Chef d'état",
          "Le chef d'État est la personne qui exerce l'autorité suprême d'un Etat, qui représente l'ensemble de la nation dans le pays et dans les relations internationales.",
          "chef.png",
          $pouvoir
      );
        $acteurs[] = new Acteur(
          "Peuple",
          "Le peuple, un peuple l'ensemble des personnes soumises aux mêmes lois et qui forment une nation.",
          "peuple.png",
          $pouvoir
      );

        $pouvoir = [];
        $pouvoir[]=$this->getReference('proposeLaLoi');
        $pouvoir[]=$this->getReference('amendeLaLoi');
        $pouvoir[]=$this->getReference('voteLaLoi');
        $pouvoir[]=$this->getReference('gestionBudgetEtat');
        $pouvoir[]=$this->getReference('guerreEtPaix');
        $acteurs[] = new Acteur(
          "Parlement",
          "Assemblée ou ensemble des chambres qui détiennent le pouvoir législatif.",
          "parlement.png",
          $pouvoir
      );

        $pouvoir = [];
        $pouvoir[]=$this->getReference('proposeLaLoi');
        $pouvoir[]=$this->getReference('gestionAdministration');
        $pouvoir[]=$this->getReference('textesReglementaires');
        $pouvoir[]=$this->getReference('etatSiege');
        $acteurs[] = new Acteur(
          "Gouvernement",
          "Le gouvernement est l'organe (personnes ou services) investi du pouvoir exécutif afin de diriger un Etat.",
          "gouvernement.png",
          $pouvoir
      );

        $pouvoir = [];
        $pouvoir[]=$this->getReference('jugeLaLoi');
        $acteurs[] = new Acteur(
          "Institution Judiciaire",
          "Ensemble des juridictions nationales (tribunaux, cours, conseils) chargées de juger les litiges des personne privées et des personnes publiques, et de sanctionner les auteurs d'infractions à la loi pénale.",
          "justice.png",
          $pouvoir
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
            $acteur->addCountryDescription(new CountryDescription("France", "Description de l'acteur ".$acteur->getType()." à completer.", "fr"));
            $manager->persist($acteur);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['all', 'acteur'];
    }

    public function getDependencies()
    {
        return array(
            PouvoirsFixtures::class,
        );
    }
}
