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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DesignationPartie", mappedBy="partie", orphanRemoval=true)
     */
    private $designationParties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConditionPouvoirPartie", mappedBy="partie", orphanRemoval=true)
     */
    private $conditionPouvoirParties;

    /**
     * @ORM\Column(type="integer")
     * @ORM\JoinColumn(nullable=true)        
     */
    private $stabilite;

    /**
     * @ORM\Column(type="integer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $equilibre;

    /**
     * @ORM\Column(type="integer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $democratie;

    public function __construct()
    {
        $this->droitDevoirs = new ArrayCollection();
        $this->valeurPrincipes = new ArrayCollection();
        $this->acteurParties = new ArrayCollection();
        $this->pouvoirParties = new ArrayCollection();
        $this->designationParties = new ArrayCollection();
        $this->conditionPouvoirParties = new ArrayCollection();
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

    /**
     * @return Collection|DesignationPartie[]
     */
    public function getDesignationParties(): Collection
    {
        return $this->designationParties;
    }

    public function addDesignationParty(DesignationPartie $designationParty): self
    {
        if (!$this->designationParties->contains($designationParty)) {
            $this->designationParties[] = $designationParty;
            $designationParty->setPartie($this);
        }

        return $this;
    }

    public function removeDesignationParty(DesignationPartie $designationParty): self
    {
        if ($this->designationParties->contains($designationParty)) {
            $this->designationParties->removeElement($designationParty);
            // set the owning side to null (unless already changed)
            if ($designationParty->getPartie() === $this) {
                $designationParty->setPartie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConditionPouvoirPartie[]
     */
    public function getConditionPouvoirParties(): Collection
    {
        return $this->conditionPouvoirParties;
    }

    public function addConditionPouvoirParty(ConditionPouvoirPartie $conditionPouvoirParty): self
    {
        if (!$this->conditionPouvoirParties->contains($conditionPouvoirParty)) {
            $this->conditionPouvoirParties[] = $conditionPouvoirParty;
            $conditionPouvoirParty->setPartie($this);
        }

        return $this;
    }

    public function removeConditionPouvoirParty(ConditionPouvoirPartie $conditionPouvoirParty): self
    {
        if ($this->conditionPouvoirParties->contains($conditionPouvoirParty)) {
            $this->conditionPouvoirParties->removeElement($conditionPouvoirParty);
            // set the owning side to null (unless already changed)
            if ($conditionPouvoirParty->getPartie() === $this) {
                $conditionPouvoirParty->setPartie(null);
            }
        }

        return $this;
    }

    /*setter et getter de SED*/

    public function getStabilite(): ?int
    {
        return $this->stabilite;
    }

    public function setStabilite(int $stabilite): self
    {
        $this->stabilite = $stabilite;

        return $this;
    }

    public function getEquilibre(): ?int
    {
        return $this->equilibre;
    }

    public function setEquilibre(int $equilibre): self
    {
        $this->equilibre = $equilibre;

        return $this;
    }

    public function getDemocratie(): ?int
    {
        return $this->democratie;
    }

    public function setDemocratie(int $democratie): self
    {
        $this->democratie = $democratie;

        return $this;
    }
    /*fin setter et getter de SED*/

}
