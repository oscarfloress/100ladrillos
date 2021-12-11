<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brick
 *
 * @ORM\Table(name="brick", indexes={@ORM\Index(name="property_id", columns={"property_id"})})
 * @ORM\Entity
 */
class Brick
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="property_id", type="integer", nullable=false)
     */
    private $propertyId;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=17, scale=2, nullable=false)
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(int $propertyId): self
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }


}
