<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdersRepository::class)
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetails::class, mappedBy="orders", orphanRemoval=true)
     */
    private $orderDetails;

    /**
     * @ORM\Column(type="integer")
     */
    private $State;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $delivery_name;

    /**
     * @ORM\Column(type="float")
     */
    private $delivery_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customer;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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

    /**
     * @return Collection|OrderDetails[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setOrders($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrders() === $this) {
                $orderDetail->setOrders(null);
            }
        }

        return $this;
    }

    public function getState(): ?int
    {
        return $this->State;
    }

    public function setState(int $State): self
    {
        $this->State = $State;

        return $this;
    }

    public function getDeliveryName(): ?string
    {
        return $this->delivery_name;
    }

    public function setDeliveryName(string $delivery_name): self
    {
        $this->delivery_name = $delivery_name;

        return $this;
    }
    public function __tostring()
    {
        return $this->getDeliveryName();
    }

    public function getDeliveryPrice(): ?float
    {
        return $this->delivery_price;
    }

    public function setDeliveryPrice(float $delivery_price): self
    {
        $this->delivery_price = $delivery_price;

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

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    
    
}
