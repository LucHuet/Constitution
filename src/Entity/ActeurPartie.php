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
     */
    private $nombreIndividus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partie", inversedBy="acteurParties", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PouvoirPartie", mappedBy="acteurPossedant", cascade={"remove"})
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Acteur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeActeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $stabilite;

    /**
     * @ORM\Column(type="integer")
     */
    private $equilibre;

    /**
     * @ORM\Column(type="integer")
     */
    private $democratie;

    /**
     * @ORM\Column(type="integer")
     */
    private $forceActeur;

    public function __construct()
    {
        $this->pouvoirParties = new ArrayCollection();
        $this->acteurRecepteur = new ArrayCollection();
        $this->designationParties = new ArrayCollection();
        $this->acteursDesignes = new ArrayCollection();
        $this->acteursDesignants = new ArrayCollection();
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
            $pouvoirParty->addActeurDestinataire($this);
        }

        return $this;
    }

    public function removePouvoirParty(PouvoirPartie $pouvoirParty): self
    {
        if ($this->pouvoirParties->contains($pouvoirParty)) {
            $this->pouvoirParties->removeElement($pouvoirParty);
            $pouvoirParty->removeActeurDestinataire($this);
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
            if ($acteursDesigne->getActeurDesigne() === $this) {
                $acteursDesigne->setActeurDesigne(null);
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

    public function addActeursDesignant(DesignationPartie $acteursDesignant): self
    {
        if (!$this->acteursDesignants->contains($acteursDesignant)) {
            $this->acteursDesignants[] = $acteursDesignant;
            $acteursDesignant->setActeurRecepteur($this);
        }

        return $this;
    }

    public function removeActeursDesignant(DesignationPartie $acteursDesignant): self
    {
        if ($this->acteursDesignants->contains($acteursDesignant)) {
            $this->acteursDesignants->removeElement($acteursDesignant);
            // set the owning side to null (unless already changed)
            if ($acteursDesignant->getActeurRecepteur() === $this) {
                $acteursDesignant->setActeurRecepteur(null);
            }
        }

        return $this;
    }

    public function getTypeActeur(): ?Acteur
    {
        return $this->typeActeur;
    }

    public function setTypeActeur(?Acteur $typeActeur): self
    {
        $this->setForceActeur(0);

        if ($typeActeur->getType() == 'Groupe d\'individus')
        {
          if($this->getNombreIndividus() == 1)
          {
            $this->setDemocratie(0)->setStabilite(0)->setEquilibre(0);
          }
          elseif($this->getNombreIndividus() > 100)
          {
              $this->setDemocratie(2)->setStabilite(2)->setEquilibre(0);
          }else
          {
            $this->setDemocratie(1)->setStabilite(1)->setEquilibre(0);
          }
        }else {
          $this
          ->setStabilite($typeActeur->getStabilite())
          ->setEquilibre($typeActeur->getEquilibre())
          ->setDemocratie($typeActeur->getDemocratie());
        }

        $this->typeActeur = $typeActeur;

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

    public function getForceActeur(): ?int
    {
        return $this->forceActeur;
    }

    public function setForceActeur(int $forceActeur): self
    {
        $this->forceActeur = $forceActeur;

        return $this;
    }
    /*fin setter et getter de SED*/

}
