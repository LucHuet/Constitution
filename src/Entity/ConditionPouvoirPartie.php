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
