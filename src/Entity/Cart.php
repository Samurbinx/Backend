<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'cart', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column]
    private ?float $Total_amount = null;

    // /**
    //  * @var Collection<int, Artwork>
    //  */
    // #[ORM\ManyToMany(targetEntity: Artwork::class, inversedBy: 'carts')]
    // private Collection $Artworks;

    /**
     * @var Collection<int, CartArtwork>
     */
    #[ORM\OneToMany(targetEntity: CartArtwork::class, mappedBy: 'Cart')]
    private Collection $cartArtworks;

    public function __construct()
    {
        // $this->Artworks = new ArrayCollection();
        $this->cartArtworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->User;
    }

    public function setUserId(User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->Total_amount;
    }

    public function setTotalAmount(float $Total_amount): static
    {
        $this->Total_amount = $Total_amount;

        return $this;
    }

    // /**
    //  * @return Collection<int, Artwork>
    //  */
    // public function getArtworks(): Collection
    // {
    //     return $this->Artworks;
    // }

    // public function getArtworksId(): array {
    //     $ids = [];

    //     foreach ($this->Artworks as $artwork) {
    //         $ids[] = $artwork->getId();
    //     }

    //     return $ids;
    // }

    // public function addArtwork(Artwork $artwork): static
    // {
    //     if (!$this->Artworks->contains($artwork)) {
    //         $this->Artworks->add($artwork);
    //     }

    //     return $this;
    // }

    // public function removeArtwork(Artwork $artwork): static
    // {
    //     $this->Artworks->removeElement($artwork);

    //     return $this;
    // }

    /**
     * @return Collection<int, CartArtwork>
     */
    public function getCartArtworks(): Collection
    {
        return $this->cartArtworks;
    }
    public function getCartArtworksSelected(): array
    {
        $selected = [];
        foreach ($this->cartArtworks as $cartArtwork) {
            if ($cartArtwork->isSelected()) {
                $selected[] = $cartArtwork->getArtwork()->getArtworkDetail();
            }
        }
        return $selected;
    }

    public function addCartArtwork(CartArtwork $cartArtwork): static
    {
        if (!$this->cartArtworks->contains($cartArtwork)) {
            $this->cartArtworks->add($cartArtwork);
            $cartArtwork->setCart($this);
        }

        return $this;
    }

    public function removeCartArtwork(CartArtwork $cartArtwork): static
    {
        if ($this->cartArtworks->removeElement($cartArtwork)) {
            // set the owning side to null (unless already changed)
            if ($cartArtwork->getCart() === $this) {
                $cartArtwork->setCart(null);
            }
        }

        return $this;
    }
}
