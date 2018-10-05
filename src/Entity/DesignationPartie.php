<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DesignationPartieRepository")
 */
class DesignationPartie
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Designation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $designation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActeurPartie", inversedBy="acteursDesignes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acteurDesigne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActeurPartie", inversedBy="acteursDesignants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $acteurDesignant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partie", inversedBy="designationParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

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

    public function getDesignation(): ?Designation
    {
        return $this->designation;
    }

    public function setDesignation(?Designation $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getActeurDesigne(): ?ActeurPartie
    {
        return $this->acteurDesigne;
    }

    public function setActeurDesigne(?ActeurPartie $acteurDesigne): self
    {
        $this->acteurDesigne = $acteurDesigne;

        return $this;
    }

    public function getActeurDesignant(): ?ActeurPartie
    {
        return $this->acteurDesignant;
    }

    public function setActeurDesignant(?ActeurPartie $acteurDesignant): self
    {
        $this->acteurDesignant = $acteurDesignant;

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
