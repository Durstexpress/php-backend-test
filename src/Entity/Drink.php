<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DrinkRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Drink
{
    const PACKAGES = ['Cans', 'Glasses', 'Others'];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @SWG\Property(description="The unique identifier of the drink.")
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     * )
     * @SWG\Property(description="The name of the drink.")
     * @Serializer\Expose()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DrinkType", inversedBy="drinks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     * @SWG\Property(description="The type of the drink.", ref=@Model(type=DrinkType::class))
     * @Serializer\Expose()
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     * @SWG\Property(description="The name of the drink.")
     * @Serializer\Expose()
     */
    private $containsAlcohol;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @SWG\Property(description="Is the drink alcoholic.")
     * @Serializer\Expose()
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @SWG\Property(description="Drink deposit price.")
     * @Serializer\Expose()
     */
    private $bottleDepositPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Choice(choices=Drink::PACKAGES, message="Choose a valid package.")
     * @SWG\Property(description="Drink bottle deposit price.")
     * @Serializer\Expose()
     */
    private $package;

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

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

    public function getType(): ?DrinkType
    {
        return $this->type;
    }

    public function setType(?DrinkType $type): self
    {
        $this->type = $type;

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
