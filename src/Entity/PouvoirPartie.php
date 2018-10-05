<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PouvoirPartieRepository")
 */
class PouvoirPartie
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Partie", inversedBy="pouvoirParties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pouvoir")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pouvoir;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ActeurPartie", inversedBy="pouvoirParties")
     */
    private $acteurPossedant;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PouvoirPartie", cascade={"persist", "remove"})
     */
    private $pouvoirDestinataire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConditionPouvoirPartie", mappedBy="pouvoirPartie", orphanRemoval=true)
     */
    private $conditionsPouvoirs;


    public function __construct()
    {
        $this->acteurPossedant = new ArrayCollection();
        $this->conditionsPouvoirs = new ArrayCollection();
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

    public function getPartie(): ?Partie
    {
        return $this->partie;
    }

    public function setPartie(?Partie $partie): self
    {
        $this->partie = $partie;

        return $this;
    }

    public function getPouvoir(): ?Pouvoir
    {
        return $this->pouvoir;
    }

    public function setPouvoir(?Pouvoir $pouvoir): self
    {
        $this->pouvoir = $pouvoir;

        return $this;
    }

    /**
     * @return Collection|ActeurPartie[]
     */
    public function getActeurPossedant(): Collection
    {
        return $this->acteurPossedant;
    }

    public function addActeurPossedant(ActeurPartie $acteurPossedant): self
    {
        if (!$this->acteurPossedant->contains($acteurPossedant)) {
            $this->acteurPossedant[] = $acteurPossedant;
        }

        return $this;
    }

    public function removeActeurPossedant(ActeurPartie $acteurPossedant): self
    {
        if ($this->acteurPossedant->contains($acteurPossedant)) {
            $this->acteurPossedant->removeElement($acteurPossedant);
        }

        return $this;
    }

    public function getPouvoirDestinataire(): ?self
    {
        return $this->pouvoirDestinataire;
    }

    public function setPouvoirDestinataire(?self $pouvoirDestinataire): self
    {
        $this->pouvoirDestinataire = $pouvoirDestinataire;

        return $this;
    }

    /**
     * @return Collection|ConditionPouvoirPartie[]
     */
    public function getConditionsPouvoirs(): Collection
    {
        return $this->conditionsPouvoirs;
    }

    public function addConditionsPouvoir(ConditionPouvoirPartie $conditionsPouvoir): self
    {
        if (!$this->conditionsPouvoirs->contains($conditionsPouvoir)) {
            $this->conditionsPouvoirs[] = $conditionsPouvoir;
            $conditionsPouvoir->setPouvoirPartie($this);
        }

        return $this;
    }

    public function removeConditionsPouvoir(ConditionPouvoirPartie $conditionsPouvoir): self
    {
        if ($this->conditionsPouvoirs->contains($conditionsPouvoir)) {
            $this->conditionsPouvoirs->removeElement($conditionsPouvoir);
            // set the owning side to null (unless already changed)
            if ($conditionsPouvoir->getPouvoirPartie() === $this) {
                $conditionsPouvoir->setPouvoirPartie(null);
            }
        }

        return $this;
    }

}
