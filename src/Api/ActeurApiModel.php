<?php

namespace App\Api;

class ActeurApiModel
{
    public $id;

    public $nom;

    public $nombreIndividus;

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
