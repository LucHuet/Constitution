<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConditionPouvoirPartieRepository")
 */
class ConditionPouvoirPartie
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
     * @ORM\ManyToOne(targetEntity="App\Entity\ConditionPouvoir")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conditionPouvoir;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $parametre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partie", inversedBy="conditionPouvoirParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PouvoirPartie", inversedBy="conditionsPouvoirs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pouvoirPartie;

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

    public function getConditionPouvoir(): ?ConditionPouvoir
    {
        return $this->conditionPouvoir;
    }

    public function setConditionPouvoir(?ConditionPouvoir $conditionPouvoir): self
    {
        $this->conditionPouvoir = $conditionPouvoir;
        return $this;
    }

    public function getParametre(): ?string
    {
        return $this->parametre;
    }

    public function setParametre(?string $parametre): self
    {
        $this->parametre = $parametre;

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

    public function getPouvoirPartie(): ?PouvoirPartie
    {
        return $this->pouvoirPartie;
    }

    public function setPouvoirPartie(?PouvoirPartie $pouvoirPartie): self
    {
        $this->pouvoirPartie = $pouvoirPartie;

        return $this;
    }
}
