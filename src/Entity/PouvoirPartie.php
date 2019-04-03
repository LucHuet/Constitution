<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PouvoirPartieRepository")
 */
class PouvoirPartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partie", inversedBy="pouvoirParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pouvoir")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pouvoir;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ActeurPartie", inversedBy="pouvoirParties")
     */
    private $acteurPossedant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ControlePartie", mappedBy="PouvoirPartie", orphanRemoval=true)
     */
    private $controlesParties;


    public function __construct()
    {
        $this->acteurPossedant = new ArrayCollection();
        $this->conditionsPouvoirs = new ArrayCollection();
        $this->controlesParties = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPartie(): ?Partie
    {
        return $this->partie;
    }

    public function setPartie(?Partie $partie): self
    {
        $this->partie = $partie;

        return $this;
    }

    public function getPouvoir(): ?Pouvoir
    {
        return $this->pouvoir;
    }

    public function setPouvoir(?Pouvoir $pouvoir): self
    {
        $this->pouvoir = $pouvoir;
        return $this;
    }

    /**
     * @return Collection|ActeurPartie[]
     */
    public function getActeurPossedant(): Collection
    {
        return $this->acteurPossedant;
    }

    public function addActeurPossedant(ActeurPartie $acteurPossedant): self
    {
        if (!$this->acteurPossedant->contains($acteurPossedant)) {
            $this->acteurPossedant[] = $acteurPossedant;
        }

        return $this;
    }

    public function removeActeurPossedant(ActeurPartie $acteurPossedant): self
    {
        if ($this->acteurPossedant->contains($acteurPossedant)) {
            $this->acteurPossedant->removeElement($acteurPossedant);
        }

        return $this;
    }

    /**
     * @return Collection|ControlePartie[]
     */
    public function getControlesParties(): Collection
    {
        return $this->controlesParties;
    }

    public function addControlesParty(ControlePartie $controlesParty): self
    {
        if (!$this->controlesParties->contains($controlesParty)) {
            $this->controlesParties[] = $controlesParty;
            $controlesParty->setPouvoirPartie($this);
        }

        return $this;
    }

    public function removeControlesParty(ControlePartie $controlesParty): self
    {
        if ($this->controlesParties->contains($controlesParty)) {
            $this->controlesParties->removeElement($controlesParty);
            // set the owning side to null (unless already changed)
            if ($controlesParty->getPouvoirPartie() === $this) {
                $controlesParty->setPouvoirPartie(null);
            }
        }

        return $this;
    }
}
