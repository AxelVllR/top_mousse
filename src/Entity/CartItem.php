<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=CartItemRepository::class)
 */
class CartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $volume;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Plate::class)
     */
    private $plate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cartItems")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shape;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $thickness;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $length;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $diameter;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $A;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $B;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $C;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $D;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getPlate(): ?Plate
    {
        return $this->plate;
    }

    public function setPlate(?Plate $plate): self
    {
        $this->plate = $plate;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(string $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getThickness(): ?int
    {
        return $this->thickness;
    }

    public function setThickness(?int $thickness): self
    {
        $this->thickness = $thickness;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getDiameter(): ?int
    {
        return $this->diameter;
    }

    public function setDiameter(?int $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getA(): ?int
    {
        return $this->A;
    }

    public function setA(?int $A): self
    {
        $this->A = $A;

        return $this;
    }

    public function getB(): ?int
    {
        return $this->B;
    }

    public function setB(?int $B): self
    {
        $this->B = $B;

        return $this;
    }

    public function getC(): ?int
    {
        return $this->C;
    }

    public function setC(?int $C): self
    {
        $this->C = $C;

        return $this;
    }

    public function getD(): ?int
    {
        return $this->D;
    }

    public function setD(?int $D): self
    {
        $this->D = $D;

        return $this;
    }
}
