<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ControlePartieRepository")
 */
class ControlePartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ActeurPartie", inversedBy="controlesParties")
     */
    private $ActeursParties;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PouvoirPartie", inversedBy="controlesParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $PouvoirPartie;

    public function __construct()
    {
        $this->ActeursParties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ActeurPartie[]
     */
    public function getActeursParties(): Collection
    {
        return $this->ActeursParties;
    }

    public function addActeursParty(ActeurPartie $acteursParty): self
    {
        if (!$this->ActeursParties->contains($acteursParty)) {
            $this->ActeursParties[] = $acteursParty;
        }

        return $this;
    }

    public function removeActeursParty(ActeurPartie $acteursParty): self
    {
        if ($this->ActeursParties->contains($acteursParty)) {
            $this->ActeursParties->removeElement($acteursParty);
        }

        return $this;
    }

    public function getPouvoirPartie(): ?PouvoirPartie
    {
        return $this->PouvoirPartie;
    }

    public function setPouvoirPartie(?PouvoirPartie $PouvoirPartie): self
    {
        $this->PouvoirPartie = $PouvoirPartie;

        return $this;
    }
}
