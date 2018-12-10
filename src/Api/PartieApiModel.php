<?php

namespace App\Api;

class PartieApiModel
{
    public $id;

    public $nom;

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
