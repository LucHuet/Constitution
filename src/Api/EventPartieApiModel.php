<?php

namespace App\Api;

class EventPartieApiModel
{
    public $id;

    public $nomReference;

    public $explicationReference;

    public $resultatReference;

    public $resultatEventPartie;

    public $explicationResultatEventPartie;     

    public function addLink($ref, $url)
    {
        $this->links[$ref] = $url;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
