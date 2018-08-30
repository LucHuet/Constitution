<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConditionDesignationPartieRepository")
 */
class ConditionDesignationPartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ConditionDesignation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conditionDesignation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $renouvelabilite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCumulable;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConditionDesignation(): ?ConditionDesignation
    {
        return $this->conditionDesignation;
    }

    public function setConditionDesignation(?ConditionDesignation $conditionDesignation): self
    {
        $this->conditionDesignation = $conditionDesignation;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getRenouvelabilite(): ?int
    {
        return $this->renouvelabilite;
    }

    public function setRenouvelabilite(?int $renouvelabilite): self
    {
        $this->renouvelabilite = $renouvelabilite;

        return $this;
    }

    public function getIsCumulable(): ?bool
    {
        return $this->isCumulable;
    }

    public function setIsCumulable(bool $isCumulable): self
    {
        $this->isCumulable = $isCumulable;

        return $this;
    }

}
