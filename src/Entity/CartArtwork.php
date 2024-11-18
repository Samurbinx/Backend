<?php

namespace App\Entity;

use App\Repository\CartArtworkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartArtworkRepository::class)]
#[ORM\UniqueConstraint(columns: ['cart_id', 'artwork_id'])]
class CartArtwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cartArtworks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $Cart = null;

    #[ORM\ManyToOne(inversedBy: 'cartArtworks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artwork $Artwork = null;

    #[ORM\Column]
    private ?bool $Selected = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCart(): ?Cart
    {
        return $this->Cart;
    }

    public function setCart(?Cart $Cart): static
    {
        $this->Cart = $Cart;

        return $this;
    }

    public function getArtwork(): ?Artwork
    {
        return $this->Artwork;
    }

    public function setArtwork(?Artwork $Artwork): static
    {
        $this->Artwork = $Artwork;

        return $this;
    }

    public function isSelected(): ?bool
    {
        return $this->Selected;
    }

    public function setSelected(bool $Selected): static
    {
        $this->Selected = $Selected;

        return $this;
    }
}
