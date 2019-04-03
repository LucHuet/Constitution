<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\DroitDevoir;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DroitsDevoirsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $droitsDevoirs = [];
        $droitsDevoirs[]= new DroitDevoir("Droit d'asile");
        $droitsDevoirs[]= new DroitDevoir("Droit au travail");
        $droitsDevoirs[]= new DroitDevoir("Droit syndical");
        $droitsDevoirs[]= new DroitDevoir("Droit de greve");
        $droitsDevoirs[]= new DroitDevoir("Protection santé");
        $droitsDevoirs[]= new DroitDevoir("Sécurité matérielle");
        $droitsDevoirs[]= new DroitDevoir("Droit à l’instruction");
        $droitsDevoirs[]= new DroitDevoir("Droit à la culture");
        $droitsDevoirs[]= new DroitDevoir("Droit de vote");
        $droitsDevoirs[]= new DroitDevoir("Droit de l’homme");
        $droitsDevoirs[]= new DroitDevoir("Nul ne peut être détenu arbitrairement");
        $droitsDevoirs[]= new DroitDevoir("Nul ne peut être condamné à mort");

        foreach ($droitsDevoirs as $droitDevoir) {
            $manager->persist($droitDevoir);
        }
        $manager->flush();
    }
}
