<?php

namespace App\Entity;

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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $importance;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isControle;

    public function __construct($description, $type, $importance, $isControle)
    {
      $this->setDescription($description)
      ->setType($type)
      ->setImportance($importance)
      ->setIsControle($isControle);

    }

    public function __toString()
    {
      return $this->getDescription();
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
}
