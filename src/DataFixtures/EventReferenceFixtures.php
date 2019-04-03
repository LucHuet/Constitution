<?php
namespace App\DataFixtures;

use App\Entity\EventReference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\PouvoirsFixtures;

class EventReferenceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $events = [];

        $events[] = new EventReference(
          "er1",
          "Le chef d'état est fou !",
          "Votre chef d'état est devenu fou ! J'espère pour vous qu'il n'a pas trop de pouvoir dangereux sinon cela pourrait détruire le pays !",
          "Il n'y a pas de Chef d'état ou de pouvoir dangereux dans cette partie, le test \" le chef d'état est fous\" n'est pas évalué.",
          "Malgré la folie de votre chef d'état, votre pays ne risque rien.",
          "Votre chef d'état possède des pouvoirs dangereux sans contrôle ni partage ! Sa folie va détruire le pays si vous n'en changez pas les règles !"
      );

        foreach ($events as $event) {
            $manager->persist($event);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['all', 'event'];
    }
}
