<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartieRepository")
 */
class Partie
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="parties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DroitDevoir", mappedBy="partie")
     */
    private $droitDevoirs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ValeurPrincipe", mappedBy="partie")
     */
    private $valeurPrincipes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActeurPartie", mappedBy="partie", orphanRemoval=true)
     */
    private $acteurParties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PouvoirPartie", mappedBy="partie", orphanRemoval=true)
     */
    private $pouvoirParties;

    public function __construct()
    {
        $this->droitDevoirs = new ArrayCollection();
        $this->valeurPrincipes = new ArrayCollection();
        $this->acteurParties = new ArrayCollection();
        $this->pouvoirParties = new ArrayCollection();
    }

    public function __toString()
    {
      return $this->nom;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|DroitDevoir[]
     */
    public function getDroitDevoirs(): Collection
    {
        return $this->droitDevoirs;
    }

    public function addDroitDevoir(DroitDevoir $droitDevoir): self
    {
        if (!$this->droitDevoirs->contains($droitDevoir)) {
            $this->droitDevoirs[] = $droitDevoir;
            $droitDevoir->addPartie($this);
        }

        return $this;
    }

    public function removeDroitDevoir(DroitDevoir $droitDevoir): self
    {
        if ($this->droitDevoirs->contains($droitDevoir)) {
            $this->droitDevoirs->removeElement($droitDevoir);
            $droitDevoir->removePartie($this);
        }

        return $this;
    }

    /**
     * @return Collection|ValeurPrincipe[]
     */
    public function getValeurPrincipes(): Collection
    {
        return $this->valeurPrincipes;
    }

    public function addValeurPrincipe(ValeurPrincipe $valeurPrincipe): self
    {
        if (!$this->valeurPrincipes->contains($valeurPrincipe)) {
            $this->valeurPrincipes[] = $valeurPrincipe;
            $valeurPrincipe->addPartie($this);
        }

        return $this;
    }

    public function removeValeurPrincipe(ValeurPrincipe $valeurPrincipe): self
    {
        if ($this->valeurPrincipes->contains($valeurPrincipe)) {
            $this->valeurPrincipes->removeElement($valeurPrincipe);
            $valeurPrincipe->removePartie($this);
        }

        return $this;
    }

    /**
     * @return Collection|ActeurPartie[]
     */
    public function getActeurParties(): Collection
    {
        return $this->acteurParties;
    }

    public function addActeurParty(ActeurPartie $acteurParty): self
    {
        if (!$this->acteurParties->contains($acteurParty)) {
            $this->acteurParties[] = $acteurParty;
            $acteurParty->setPartie($this);
        }

        return $this;
    }

    public function removeActeurParty(ActeurPartie $acteurParty): self
    {
        if ($this->acteurParties->contains($acteurParty)) {
            $this->acteurParties->removeElement($acteurParty);
            // set the owning side to null (unless already changed)
            if ($acteurParty->getPartie() === $this) {
                $acteurParty->setPartie(null);
            }
        }

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
            $pouvoirParty->setPartie($this);
        }

        return $this;
    }

    public function removePouvoirParty(PouvoirPartie $pouvoirParty): self
    {
        if ($this->pouvoirParties->contains($pouvoirParty)) {
            $this->pouvoirParties->removeElement($pouvoirParty);
            // set the owning side to null (unless already changed)
            if ($pouvoirParty->getPartie() === $this) {
                $pouvoirParty->setPartie(null);
            }
        }

        return $this;
    }
}
