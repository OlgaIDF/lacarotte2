<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
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
    private $company_name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): self
    {
        $this->company_name = $company_name;

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
    public function __tostring()
    {
        return $this->getCompanyName().'[br]'.$this->getPrice() .' €';
    }

    
}
