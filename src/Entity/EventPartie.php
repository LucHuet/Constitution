<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventPartieRepository")
 */
class EventPartie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventReference")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eventReference;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partie;

    /**
     * @ORM\Column(type="integer")
     */
    private $resultat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $explicationResultat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getEventReference(): ?EventReference
    {
        return $this->eventReference;
    }

    public function setEventReference(?EventReference $eventReference): self
    {
        $this->eventReference = $eventReference;

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

    public function getResultat(): ?int
    {
        return $this->resultat;
    }

    public function setResultat(int $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getExplicationResultat(): ?string
    {
        return $this->explicationResultat;
    }

    public function setExplicationResultat(string $explicationResultat): self
    {
        $this->explicationResultat = $explicationResultat;

        return $this;
    }
}
