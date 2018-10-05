<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PouvoirRepository")
 */
class Pouvoir
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * Designe le type du pouvoir : Executif, Judiciaire, Legislatif, Constitutionnel et Controle-Pouvoir/Acteur/Designation
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $importance;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $groupePouvoir;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pouvoir")
     */
    private $pouvoirParent;


    public function __construct(
      $nom,
      $description,
      $type,
      $importance,
      $stabilite,
      $equilibre,
      $democratie
      )
    {
      $this
      ->setNom($nom)
      ->setDescription($description)
      ->setType($type)
      ->setImportance($importance)
      ->setStabilite($stabilite)
      ->setEquilibre($equilibre)
      ->setDemocratie($democratie)
      ;
    }

    public function __toString()
    {
      return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getImportance(): ?int
    {
        return $this->importance;
    }

    public function setImportance(int $importance): self
    {
        $this->importance = $importance;

        return $this;
    }

    public function getIsControle(): ?bool
    {
        return $this->isControle;
    }

    public function setIsControle(bool $isControle): self
    {
        $this->isControle = $isControle;

        return $this;
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

    public function getGroupePouvoir(): ?string
    {
        return $this->groupePouvoir;
    }

    public function setGroupePouvoir(?string $groupePouvoir): self
    {
        $this->groupePouvoir = $groupePouvoir;

        return $this;
    }

    public function getPouvoirParent(): ?self
    {
        return $this->pouvoirParent;
    }

    public function setPouvoirParent(?self $pouvoirParent): self
    {
        $this->pouvoirParent = $pouvoirParent;

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
