<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?float $downpayment = null;

    #[ORM\Column]
    private ?float $discount = null;

    #[ORM\Column]
    private ?float $delivery_fee = null;

    #[ORM\Column]
    private ?float $late_fee = null;

    #[ORM\Column]
    private ?float $balance = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\ManyToOne(inversedBy: 'customerId')]
    private ?Customer $customer = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
    private Collection $items;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $return_date = null;

    #[ORM\OneToOne(mappedBy: 'order_id', cascade: ['persist', 'remove'])]
    private ?Payment $payment = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrder($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrder() === $this) {
                $item->setOrder(null);
            }
        }

        return $this;
    }

    public function getDownpayment(): ?float
    {
        return $this->downpayment;
    }

    public function setDownpayment(float $downpayment): self
    {
        $this->downpayment = $downpayment;

        return $this;
    }

    public function getDeliveryFee(): ?float
    {
        return $this->delivery_fee;
    }

    public function setDeliveryFee(float $delivery_fee): self
    {
        $this->delivery_fee = $delivery_fee;

        return $this;
    }

    public function getLateFee(): ?float
    {
        return $this->late_fee;
    }

    public function setLateFee(float $late_fee): self
    {
        $this->late_fee = $late_fee;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->return_date;
    }

    public function setReturnDate(\DateTimeInterface $return_date): self
    {
        $this->return_date = $return_date;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): self
    {
        // set the owning side of the relation if necessary
        if ($payment->getOrderId() !== $this) {
            $payment->setOrderId($this);
        }

        $this->payment = $payment;

        return $this;
    }
}
