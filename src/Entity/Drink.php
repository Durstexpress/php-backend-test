<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DrinkRepository")
 * @UniqueEntity(fields="name", message="Name is already taken.")
 */
class Drink
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \App\Entity\Type
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $contains_alcohol;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $bottle_deposit_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $package;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getContainsAlcohol(): ?bool
    {
        return $this->contains_alcohol;
    }

    public function setContainsAlcohol(bool $contains_alcohol): self
    {
        $this->contains_alcohol = $contains_alcohol;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBottleDepositPrice(): ?float
    {
        return $this->bottle_deposit_price;
    }

    public function setBottleDepositPrice(float $bottle_deposit_price): self
    {
        $this->bottle_deposit_price = $bottle_deposit_price;

        return $this;
    }

    public function getPackage(): ?string
    {
        return $this->package;
    }

    public function setPackage(string $package): self
    {
        $this->package = $package;

        return $this;
    }
}
