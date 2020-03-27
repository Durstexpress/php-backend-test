<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var DrinkType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\DrinkType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $containsAlcohol;

    /**
     * @var Money
     *
     * @ORM\Embedded(class="Money")
     */
    private $price;

    /**
     * @var Money
     *
     * @ORM\Embedded(class="Money")
     */
    private $bottleDepositPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $package;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DrinkType|null
     */
    public function getType(): ?DrinkType
    {
        return $this->type;
    }

    /**
     * @param DrinkType $type
     * @return $this
     */
    public function setType(DrinkType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getContainsAlcohol(): ?bool
    {
        return $this->containsAlcohol;
    }

    /**
     * @param bool $containsAlcohol
     * @return $this
     */
    public function setContainsAlcohol(bool $containsAlcohol): self
    {
        $this->containsAlcohol = $containsAlcohol;

        return $this;
    }

    /**
     * @return Money|null
     */
    public function getPrice(): ?Money
    {
        return $this->price;
    }

    /**
     * @param Money|string $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = Money::convertToMoney($price);

        return $this;
    }

    /**
     * @return Money|null
     */
    public function getBottleDepositPrice(): ?Money
    {
        return $this->bottleDepositPrice;
    }

    /**
     * @param Money|string $price
     * @return $this
     */
    public function setBottleDepositPrice($price)
    {
        $this->bottleDepositPrice = Money::convertToMoney($price);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPackage(): ?string
    {
        return $this->package;
    }

    /**
     * @param string $package
     * @return $this
     */
    public function setPackage(string $package): self
    {
        $this->package = $package;

        return $this;
    }
}
