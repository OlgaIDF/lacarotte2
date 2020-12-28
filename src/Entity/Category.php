<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ItemMenu::class, mappedBy="category", orphanRemoval=true)
     */
    private $itemMenus;

    public function __construct()
    {
        $this->itemMenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ItemMenu[]
     */
    public function getItemMenus(): Collection
    {
        return $this->itemMenus;
    }

    public function addItemMenu(ItemMenu $itemMenu): self
    {
        if (!$this->itemMenus->contains($itemMenu)) {
            $this->itemMenus[] = $itemMenu;
            $itemMenu->setCategory($this);
        }

        return $this;
    }

    public function removeItemMenu(ItemMenu $itemMenu): self
    {
        if ($this->itemMenus->removeElement($itemMenu)) {
            // set the owning side to null (unless already changed)
            if ($itemMenu->getCategory() === $this) {
                $itemMenu->setCategory(null);
            }
        }

        return $this;
    }
}
