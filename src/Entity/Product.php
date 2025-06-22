<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity]
#[ORM\Table(name: "products")]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $price;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getName(): string 
    { 
        return $this->name; 
    }
    public function setName(string $name): self 
    { 
        $this->name = $name; return $this; 
    }

    public function getDescription(): ?string 
    { 
        return $this->description; 
    }
    public function setDescription(?string $description): self 
    { 
        $this->description = $description; return $this; 
    }

    public function getPrice(): float 
    { 
        return $this->price; 
    }
    public function setPrice(float $price): self 
    { 
        $this->price = $price; return $this; 
    }

    public function getOwner(): User 
    { 
        return $this->owner; 
    }
    public function setOwner(User $owner): self 
    { 
        $this->owner = $owner; return $this; 
    }
}
