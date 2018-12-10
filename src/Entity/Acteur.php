<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActeurRepository")
 */
class Acteur
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
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CountryDescription", mappedBy="acteur", orphanRemoval=true, cascade={"persist"})
     */
    private $countryDescriptions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct($type, $description, $image)
    {
        $this->type = $type;
        $this->description = $description;
        $this->image = $image;
        $this->countryDescriptions = new ArrayCollection();
    }

    public function __toString()
    {
      return $this->type;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|CountryDescription[]
     */
    public function getCountryDescriptions(): Collection
    {
        return $this->countryDescriptions;
    }

    public function addCountryDescription(CountryDescription $countryDescription): self
    {
        if (!$this->countryDescriptions->contains($countryDescription)) {
            $this->countryDescriptions[] = $countryDescription;
            $countryDescription->setActeur($this);
        }

        return $this;
    }

    public function removeCountryDescription(CountryDescription $countryDescription): self
    {
        if ($this->countryDescriptions->contains($countryDescription)) {
            $this->countryDescriptions->removeElement($countryDescription);
            // set the owning side to null (unless already changed)
            if ($countryDescription->getActeur() === $this) {
                $countryDescription->setActeur(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

}
