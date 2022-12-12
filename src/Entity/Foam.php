<?php

namespace App\Entity;

use App\Repository\FoamRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FoamRepository::class)
 */
class Foam
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
    private $reference;

    /**
     * @ORM\Column(type="integer")
     */
    private $line;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $comfort;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $density;

    /**
     * @ORM\Column(type="integer")
     */
    private $various;

    /**
     * @ORM\Column(type="integer")
     */
    private $mattress;

    /**
     * @ORM\Column(type="integer")
     */
    private $cake;

    /**
     * @ORM\Column(type="integer")
     */
    private $sitting;

    /**
     * @ORM\Column(type="integer")
     */
    private $back;

    /**
     * @ORM\Column(type="integer")
     */
    private $cuff;

    /**
     * @ORM\Column(type="integer")
     */
    private $pillow;

    /**
     * @ORM\Column(type="integer")
     */
    private $cap;

    /**
     * @ORM\Column(type="integer")
     */
    private $wedging;

    /**
     * @ORM\Column(type="integer")
     */
    private $footstool;

    /**
     * @ORM\Column(type="float")
     */
    private $priceCube;

    /**
     * @ORM\Column(type="float")
     */
    private $priceCylinder;

    /**
     * @ORM\Column(type="integer")
     */
    private $promo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $resellerPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $resellerPriceHt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLine(): ?int
    {
        return $this->line;
    }

    public function setLine(int $line): self
    {
        $this->line = $line;

        return $this;
    }

    public function getComfort(): ?int
    {
        return $this->comfort;
    }

    public function setComfort(?int $comfort): self
    {
        $this->comfort = $comfort;

        return $this;
    }

    public function getDensity(): ?bool
    {
        return $this->density === 1;
    }

    public function setDensity(?int $density): self
    {
        $this->density = $density;

        return $this;
    }

    public function getVarious(): ?bool
    {
        return $this->various === 1;
    }

    public function setVarious(int $various): self
    {
        $this->various = $various;

        return $this;
    }

    public function getMattress(): ?bool
    {
        return $this->mattress === 1;
    }

    public function setMattress(int $mattress): self
    {
        $this->mattress = $mattress;

        return $this;
    }

    public function getCake(): ?bool
    {
        return $this->cake === 1;
    }

    public function setCake(int $cake): self
    {
        $this->cake = $cake;

        return $this;
    }

    public function getSitting(): ?bool
    {
        return $this->sitting === 1;
    }

    public function setSitting(int $sitting): self
    {
        $this->sitting = $sitting;

        return $this;
    }

    public function getBack(): ?bool
    {
        return $this->back === 1;
    }

    public function setBack(int $back): self
    {
        $this->back = $back;

        return $this;
    }

    public function getCuff(): ?bool
    {
        return $this->cuff === 1;
    }

    public function setCuff(int $cuff): self
    {
        $this->cuff = $cuff;

        return $this;
    }

    public function getPillow(): ?bool
    {
        return $this->pillow === 1;
    }

    public function setPillow(int $pillow): self
    {
        $this->pillow = $pillow;

        return $this;
    }

    public function getCap(): ?bool
    {
        return $this->cap === 1;
    }

    public function setCap(int $cap): self
    {
        $this->cap = $cap;

        return $this;
    }

    public function getWedging(): ?bool
    {
        return $this->wedging === 1;
    }

    public function setWedging(int $wedging): self
    {
        $this->wedging = $wedging;

        return $this;
    }

    public function getFootstool(): ?bool
    {
        return $this->footstool === 1;
    }

    public function setFootstool(int $footstool): self
    {
        $this->footstool = $footstool;

        return $this;
    }

    public function getPriceCube(): ?float
    {
        return $this->priceCube;
    }

    public function setPriceCube(float $priceCube): self
    {
        $this->priceCube = $priceCube;

        return $this;
    }

    public function getPriceCylinder(): ?float
    {
        return $this->priceCylinder;
    }

    public function setPriceCylinder(float $priceCylinder): self
    {
        $this->priceCylinder = $priceCylinder;

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo === 1;
    }

    public function setPromo(int $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function findLine(): string
    {
        $lines = [
            0 => '0 - Mousse calage',
            1 => '1 - Mousse polyéther',
            2 => '2 - Haute résilience',
            3 => '3 - Mousse bultex',
            4 => '4 - Haute résilience',
            6 => '6 - Mousse dryfeel',
            7 => '7 - Mousse pour filtres'
        ];

        return $lines[$this->line];
    }

    public function findComfort(): string
    {
        if ($this->comfort) {
            $comforts = [
                1 => '1 - Souple',
                2 => '2 - Médium',
                3 => '3 - Ferme',
                4 => '4 - Très ferme'
            ];

            return $comforts[$this->comfort];
        } else {
            return '-';
        }
    }

    public function findDensity(): string
    {
        if ($this->density) {
            $densities = [
                1 => 'Faible',
                2 => 'Moyenne',
                3 => 'Forte'
            ];

            return $densities[$this->density];
        } else {
            return '-';
        }
    }

    public function getResellerPrice(): ?float
    {
        return $this->resellerPrice;
    }

    public function setResellerPrice(?float $resellerPrice): self
    {
        $this->resellerPrice = $resellerPrice;

        return $this;
    }

    public function getResellerPriceHt(): ?float
    {
        return $this->resellerPriceHt;
    }

    public function setResellerPriceHt(?float $resellerPriceHt): self
    {
        $this->resellerPriceHt = $resellerPriceHt;

        return $this;
    }
}
