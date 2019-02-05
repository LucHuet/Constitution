<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActeurPartieRepository")
 */
class ActeurPartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Quel est le nom de l'acteur ?")
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
      * @Assert\GreaterThan(value=0, message ="il vous faut au moins 1 membre")
     */
    private $nombreIndividus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partie", inversedBy="acteurParties", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PouvoirPartie", mappedBy="acteurPossedant")
     */
    private $pouvoirParties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DesignationPartie", mappedBy="acteurDesigne", cascade={"remove"})
     */
    private $acteursDesignes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DesignationPartie", mappedBy="acteurDesignant", cascade={"remove"})
     */
    private $acteursDesignants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Acteur", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeActeur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ControlePartie", mappedBy="ActeursParties")
     */
    private $controlesParties;

    public function __construct()
    {
        $this->pouvoirParties = new ArrayCollection();
        $this->acteurRecepteur = new ArrayCollection();
        $this->designationParties = new ArrayCollection();
        $this->acteursDesignes = new ArrayCollection();
        $this->acteursDesignants = new ArrayCollection();
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

    public function getNombreIndividus(): ?int
    {
        return $this->nombreIndividus;
    }

    public function setNombreIndividus(?int $nombreIndividus): self
    {
        $this->nombreIndividus = $nombreIndividus;

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

    /**
     * @return Collection|PouvoirPartie[]
     */
    public function getPouvoirParties(): Collection
    {
        return $this->pouvoirParties;
    }

    public function addPouvoirParty(PouvoirPartie $pouvoirParty): self
    {
        if (!$this->pouvoirParties->contains($pouvoirParty)) {
            $this->pouvoirParties[] = $pouvoirParty;
            $pouvoirParty->addActeurPossedant($this);
        }

        return $this;
    }

    public function removePouvoirParty(PouvoirPartie $pouvoirParty): self
    {
        if ($this->pouvoirParties->contains($pouvoirParty)) {
            $this->pouvoirParties->removeElement($pouvoirParty);
            $pouvoirParty->removeActeurPossedant($this);
        }

        return $this;
    }

    public function emptyPouvoirParty(): self
    {
      foreach($this->getPouvoirParties() as $pouvoirPartie)
      {
        $this->removePouvoirParty($pouvoirPartie);
      }
      return $this;
    }

    /**
     * @return Collection|DesignationPartie[]
     */
    public function getActeursDesignes(): Collection
    {
        return $this->acteursDesignes;
    }

    public function getActeursDesignesId(): Array
    {   $acteursDesignesId = [];
        foreach($this->acteursDesignes as $acteurDesigne)
        {
          $acteursDesignesId[] = $acteurDesigne->getId();
        }
        return $acteursDesignesId;
    }

    public function addActeursDesigne(DesignationPartie $acteursDesigne): self
    {
        if (!$this->acteursDesignes->contains($acteursDesigne)) {
            $this->acteursDesignes[] = $acteursDesigne;
            $acteursDesigne->setActeurDesigne($this);
        }

        return $this;
    }

    public function removeActeursDesigne(DesignationPartie $acteursDesigne): self
    {
        if ($this->acteursDesignes->contains($acteursDesigne)) {
            $this->acteursDesignes->removeElement($acteursDesigne);
            // set the owning side to null (unless already changed)

            if ($acteursDesigne->getActeurDesignant() === $this) {
                $acteursDesigne->setActeurDesignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DesignationPartie[]
     */
    public function getActeursDesignants(): Collection
    {
        return $this->acteursDesignants;
    }

    public function getActeursDesignantsId(): Array
    {   $acteursDesignantsId = [];
        foreach($this->acteursDesignants as $acteurDesignant)
        {
          $acteursDesignantsId[] = $acteurDesignant->getId();
        }
        return $acteursDesignantsId;
    }

    public function addActeursDesignant(DesignationPartie $acteursDesignant): self
    {
        if (!$this->acteursDesignants->contains($acteursDesignant)) {
            $this->acteursDesignants[] = $acteursDesignant;
            $acteursDesignant->setActeurDesignant($this);
        }

        return $this;
    }

    public function removeActeursDesignant(DesignationPartie $acteursDesignant): self
    {
        if ($this->acteursDesignants->contains($acteursDesignant)) {
            $this->acteursDesignants->removeElement($acteursDesignant);
            // set the owning side to null (unless already changed)
            if ($acteursDesignant->getActeurDesigne() === $this) {
                $acteursDesignant->setActeurDesigne(null);
            }
        }

        return $this;
    }

    public function emptyActeursDesignants(): self
    {
        $this->acteursDesignants = new ArrayCollection();

        return $this;
    }

    public function getTypeActeur(): ?Acteur
    {
        return $this->typeActeur;
    }

    public function setTypeActeur(?Acteur $typeActeur): self
    {
        $this->typeActeur = $typeActeur;

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
            $controlesParty->addActeursParty($this);
        }

        return $this;
    }

    public function removeControlesParty(ControlePartie $controlesParty): self
    {
        if ($this->controlesParties->contains($controlesParty)) {
            $this->controlesParties->removeElement($controlesParty);
            $controlesParty->removeActeursParty($this);
        }

        return $this;
    }

}
