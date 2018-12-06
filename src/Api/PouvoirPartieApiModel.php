<?php

namespace App\Api;

class PouvoirPartieApiModel
{
    public $id;

    public $nom;

    public $pouvoir;

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
