<?php

namespace App\Api;

class ActeurRefApiModel
{
    public $id;

    public $type;

    public $description;

    public $countryDescriptions = [];

    public $image;

    public $pouvoirsBase = [];

    public function addLink($ref, $url)
    {
        $this->links[$ref] = $url;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
