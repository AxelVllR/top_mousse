<?php

namespace App\Entity;

use App\Repository\WrapRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WrapRepository::class)
 */
class Wrap
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shipping;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $packageNumbers;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $packageMaxNumbers;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lengthMax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShipping(): ?string
    {
        return $this->shipping;
    }

    public function setShipping(?string $shipping): self
    {
        $this->shipping = $shipping;

        return $this;
    }

    public function getPackageNumbers(): ?int
    {
        return $this->packageNumbers;
    }

    public function setPackageNumbers(?int $packageNumbers): self
    {
        $this->packageNumbers = $packageNumbers;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPackageMaxNumbers(): ?int
    {
        return $this->packageMaxNumbers;
    }

    public function setPackageMaxNumbers(?int $packageMaxNumbers): self
    {
        $this->packageMaxNumbers = $packageMaxNumbers;

        return $this;
    }

    public function getLengthMax(): ?float
    {
        return $this->lengthMax;
    }

    public function setLengthMax(?float $lengthMax): self
    {
        $this->lengthMax = $lengthMax;

        return $this;
    }
}
