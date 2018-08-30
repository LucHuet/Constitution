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
    private $ActeurDestinataire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActeurPartie", inversedBy="acteursDesignants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acteurRecepteur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ConditionDesignationPartie", cascade={"persist", "remove"})
     */
    private $conditionDesignation;

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

    public function getActeurDestinataire(): ?ActeurPartie
    {
        return $this->ActeurDestinataire;
    }

    public function setActeurDestinataire(?ActeurPartie $ActeurDestinataire): self
    {
        $this->ActeurDestinataire = $ActeurDestinataire;

        return $this;
    }

    public function getActeurRecepteur(): ?ActeurPartie
    {
        return $this->acteurRecepteur;
    }

    public function setActeurRecepteur(?ActeurPartie $acteurRecepteur): self
    {
        $this->acteurRecepteur = $acteurRecepteur;

        return $this;
    }

    public function getConditionDesignation(): ?ConditionDesignationPartie
    {
        return $this->conditionDesignation;
    }

    public function setConditionDesignation(?ConditionDesignationPartie $conditionDesignation): self
    {
        $this->conditionDesignation = $conditionDesignation;

        return $this;
    }

}
