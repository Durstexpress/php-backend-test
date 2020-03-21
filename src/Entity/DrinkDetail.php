<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DrinkDetail.
 */
trait DrinkDetail
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     * )
     * @SWG\Property(description="The name of the drink.")
     * @Serializer\Type("string")
     * @Serializer\Expose()
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     * @Assert\Type(type="bool")
     * @SWG\Property(description="The name of the drink.")
     * @Serializer\Type("bool")
     * @Serializer\Expose()
     */
    private $containsAlcohol;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @SWG\Property(description="Is the drink alcoholic.")
     * @Serializer\Type("float")
     * @Serializer\Expose()
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @SWG\Property(description="Drink deposit price.")
     * @Serializer\Type("float")
     * @Serializer\Expose()
     */
    private $bottleDepositPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Choice(choices=Drink::PACKAGES, message="Choose a valid package.")
     * @SWG\Property(description="Drink bottle deposit price.")
     * @Serializer\Type("string")
     * @Serializer\Expose()
     */
    private $package;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContainsAlcohol(): ?bool
    {
        return $this->containsAlcohol;
    }

    public function setContainsAlcohol(bool $containsAlcohol): self
    {
        $this->containsAlcohol = $containsAlcohol;

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
        return $this->bottleDepositPrice;
    }

    public function setBottleDepositPrice(float $bottleDepositPrice): self
    {
        $this->bottleDepositPrice = $bottleDepositPrice;

        return $this;
    }

    public function getPackage(): ?string
    {
        return $this->package;
    }

    public function setPackage(?string $package): self
    {
        $this->package = $package;

        return $this;
    }
}
