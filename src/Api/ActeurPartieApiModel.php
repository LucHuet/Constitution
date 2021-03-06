<?php

namespace App\Api;

class ActeurPartieApiModel
{
    public $id;

    public $nom;

    public $nombreIndividus;

    public $image;

    public $pouvoirs;

    public $designations;

    public $pouvoirsControles;

    public $type;

    private $links = [];

    public function addLink($ref, $url)
    {
        $this->links[$ref] = $url;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
