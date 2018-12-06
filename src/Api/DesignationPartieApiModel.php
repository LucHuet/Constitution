<?php

namespace App\Api;

class DesignationPartieApiModel
{
    public $id;

    public $nom;

    public $designation;

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
