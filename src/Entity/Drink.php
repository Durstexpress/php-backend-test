<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DrinkRepository")
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
	 * @Assert\NotBlank
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 255,
	 *      minMessage = "Name must be at least {{ limit }} characters long",
	 *      maxMessage = "Name cannot be longer than {{ limit }} characters"
	 * )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
	 * @Assert\NotBlank
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 255,
	 *      minMessage = "Name must be at least {{ limit }} characters long",
	 *      maxMessage = "Name cannot be longer than {{ limit }} characters"
	 * )
     * @ORM\Column(type="string", length=55)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $contains_alcohol;

    /**
	 * @Assert\NotBlank
	 * @Assert\Type(
	 *     type="float",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
     * @ORM\Column(type="float")
     */
    private $price;

    /**
	 * @Assert\NotBlank
	 * @Assert\Type(
	 *     type="float",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
     * @ORM\Column(type="float")
     */
    private $bottle_deposit_price;

    /**
	 * @Assert\NotBlank
	 * @Assert\Length(
	 *      min = 2,
	 *      max = 255,
	 *      minMessage = "Name must be at least {{ limit }} characters long",
	 *      maxMessage = "Name cannot be longer than {{ limit }} characters"
	 * )
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
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
