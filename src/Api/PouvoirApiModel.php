<?php

namespace App\Api;

class PouvoirApiModel
{
    public $id;

    public $nom;

    public $description;

    public $type;

    public $pouvoirParent;

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
