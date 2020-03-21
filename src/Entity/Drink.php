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
    use DrinkDetail;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\DrinkType", inversedBy="drinks")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     * @SWG\Property(description="The type of the drink.", ref=@Model(type=DrinkType::class))
     * @Serializer\Expose()
     */
    private $type;

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
