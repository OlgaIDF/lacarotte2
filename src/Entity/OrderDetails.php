<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailsRepository::class)
 */
class OrderDetails
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=ItemMenu::class, inversedBy="orderDetails")
     * @ORM\JoinColumn(nullable=false)
     */

     
    private $itemMenu;

    /**
     * @ORM\ManyToOne(targetEntity=Orders::class, inversedBy="orderDetails", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $orders;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getItemMenu(): ?ItemMenu
    {
        return $this->itemMenu;
    }

    public function setItemMenu(?ItemMenu $itemMenu): self
    {
        $this->itemMenu = $itemMenu;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

        return $this;
    }
}
