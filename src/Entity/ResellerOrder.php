<?php

namespace App\Entity;

use App\Repository\ResellerOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Monolog\DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=ResellerOrderRepository::class)
 */
class ResellerOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingAddress;

    /**
     * @ORM\Column(type="integer")
     */
    private $billingPostalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shippingAddress;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $shippingPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shippingCity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $shippingMethod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shippingCode;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="resellerOrders")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paymentMethod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shippingNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orderNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $packages;

    /**
     * @ORM\OneToMany(targetEntity=ResellerOrderItem::class, mappedBy="resellerOrder")
     */
    private $resellerOrderItems;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    public function __construct()
    {
        $this->resellerOrderItems = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable(true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingPostalCode(): ?int
    {
        return $this->billingPostalCode;
    }

    public function setBillingPostalCode(int $billingPostalCode): self
    {
        $this->billingPostalCode = $billingPostalCode;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getShippingAddress(): ?string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?string $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    public function getShippingPostalCode(): ?int
    {
        return $this->shippingPostalCode;
    }

    public function setShippingPostalCode(?int $shippingPostalCode): self
    {
        $this->shippingPostalCode = $shippingPostalCode;

        return $this;
    }

    public function getShippingCity(): ?string
    {
        return $this->shippingCity;
    }

    public function setShippingCity(?string $shippingCity): self
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    public function getShippingMethod(): ?int
    {
        return $this->shippingMethod;
    }

    public function setShippingMethod(?int $shippingMethod): self
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    public function getShippingCode(): ?string
    {
        return $this->shippingCode;
    }

    public function setShippingCode(?string $shippingCode): self
    {
        $this->shippingCode = $shippingCode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPaymentMethod(): ?int
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?int $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getShippingNumber(): ?string
    {
        return $this->shippingNumber;
    }

    public function setShippingNumber(?string $shippingNumber): self
    {
        $this->shippingNumber = $shippingNumber;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getPackages(): ?int
    {
        return $this->packages;
    }

    public function setPackages(?int $packages): self
    {
        $this->packages = $packages;

        return $this;
    }

    /**
     * @return Collection|ResellerOrderItem[]
     */
    public function getResellerOrderItems(): Collection
    {
        return $this->resellerOrderItems;
    }

    public function addResellerOrderItem(ResellerOrderItem $resellerOrderItem): self
    {
        if (!$this->resellerOrderItems->contains($resellerOrderItem)) {
            $this->resellerOrderItems[] = $resellerOrderItem;
            $resellerOrderItem->setResellerOrder($this);
        }

        return $this;
    }

    public function removeResellerOrderItem(ResellerOrderItem $resellerOrderItem): self
    {
        if ($this->resellerOrderItems->removeElement($resellerOrderItem)) {
            // set the owning side to null (unless already changed)
            if ($resellerOrderItem->getResellerOrder() === $this) {
                $resellerOrderItem->setResellerOrder(null);
            }
        }

        return $this;
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

    public function findStatus(): string
    {
        return match ($this->status) {
            3 => 'Prise en compte',
            4 => 'En pr??paration',
            5 => 'D??coup??e',
            6 => 'Emball??e',
            7 => 'Exp??di??e',
            8 => 'Sold??e',
            default => '-',
        };
    }

    public function findShippingMethod(): string
    {
        return match ($this->shippingMethod) {
            1 => 'Livraison ?? domicile',
            2 => 'Point relai',
            3 => 'En magasin',
            default => '-',
        };
    }

    public function findColor(): string
    {
        return match ($this->status) {
            1 => '#D3D3D3',
            2 => '#D1A5A5',
            3 => '#D553FF',
            4 => '#CC3300',
            5 => '#58ACFA',
            6 => '#FB0606E6',
            7 => '#47A619',
            8 => '#D3D3D3',
            default => '#D3D3D3',
        };
    }
}
