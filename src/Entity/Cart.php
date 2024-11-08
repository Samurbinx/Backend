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

    /**
     * @var Collection<int, Artwork>
     */
    #[ORM\ManyToMany(targetEntity: Artwork::class, inversedBy: 'carts')]
    private Collection $Artworks;

    public function __construct()
    {
        $this->Artworks = new ArrayCollection();
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

    /**
     * @return Collection<int, Artwork>
     */
    public function getArtworks(): Collection
    {
        return $this->Artworks;
    }

    public function addArtwork(Artwork $artwork): static
    {
        if (!$this->Artworks->contains($artwork)) {
            $this->Artworks->add($artwork);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): static
    {
        $this->Artworks->removeElement($artwork);

        return $this;
    }
}
