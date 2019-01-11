<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventReferenceRepository")
 */
class EventReference
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
    private $explication;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultatNull;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultatOK;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultatNOK;

    public function __construct($ref, $nom, $explication)
    {
        $this->nom = $nom;
        $this->explication = $explication;
        $this->ref = $ref;
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

    public function getExplication(): ?string
    {
        return $this->explication;
    }

    public function setExplication(string $explication): self
    {
        $this->explication = $explication;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getResultatNull(): ?string
    {
        return $this->resultatNull;
    }

    public function setResultatNull(string $resultatNull): self
    {
        $this->resultatNull = $resultatNull;

        return $this;
    }

    public function getResultatOK(): ?string
    {
        return $this->resultatOK;
    }

    public function setResultatOK(string $resultatOK): self
    {
        $this->resultatOK = $resultatOK;

        return $this;
    }

    public function getResultatNOK(): ?string
    {
        return $this->resultatNOK;
    }

    public function setResultatNOK(string $resultatNOK): self
    {
        $this->resultatNOK = $resultatNOK;

        return $this;
    }
}
