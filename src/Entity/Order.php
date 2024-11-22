<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column]
    private ?float $Total_amount = null;

    /**
     * @var Collection<int, Artwork>
     */
    #[ORM\OneToMany(targetEntity: Artwork::class, mappedBy: 'Order')]
    private Collection $Artworks;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 10)]
    private ?string $status = null;

    public function __construct()
    {
        $this->Artworks = new ArrayCollection();
    }

    public function getOrderDetails(): ?array {
        $data = [
            'id'=> $this->id,
            'user_id'=> $this->getUser()->getId(),
            'total_amount'=> $this->Total_amount,
            'created_at'=> $this->getDate(),
            'status'=> $this->status,
        ];
        $artworks = [];
     
        foreach ($this->getArtworks() as $artwork) {
            $artworks[] = $artwork->getArtworkDetail();
        }
        $data['artworks'] = $artworks;
    
        return $data;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
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
            $artwork->setOrderId($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): static
    {
        if ($this->Artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getOrderId() === $this) {
                $artwork->setOrderId(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    
    public function getDate(): ?string
    {
        if ($this->created_at) {
            return $this->created_at->format("Y-m-d H:i:s");
        }
        return null;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
