<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtworkRepository::class)]
class Artwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Artworks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Work $Work = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Creation_date = null;

    #[ORM\Column(nullable: true)]
    private ?float $Price = null;

    #[ORM\Column]
    private ?bool $Sold = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Display = null;

    /**
     * @var Collection<int, Piece>
     */
    #[ORM\OneToMany(targetEntity: Piece::class, mappedBy: 'Artwork')]
    private Collection $pieces;


    

    // /**
    //  * @var Collection<int, Cart>
    //  */
    // #[ORM\ManyToMany(targetEntity: Cart::class, mappedBy: 'Artworks')]
    // private Collection $carts;

    #[ORM\ManyToOne(inversedBy: 'Artworks')]
    private ?Order $Order = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Favorites')]
    private Collection $FavoritedBy;

    /**
     * @var Collection<int, CartArtwork>
     */
    #[ORM\OneToMany(targetEntity: CartArtwork::class, mappedBy: 'Artwork')]
    private Collection $cartArtworks;


    public function __construct()
    {
        $this->pieces = new ArrayCollection();
        // $this->carts = new ArrayCollection();
        $this->FavoritedBy = new ArrayCollection();
        $this->cartArtworks = new ArrayCollection();
    }

    public function getArtwork(): ?array {
        return [
            'id'=> $this->id,
            'workID'=> $this->Work->getId(),
            'title'=> $this->Title,
            'creation_date'=> $this->getCreationYear(),
            'price'=> $this->Price,
            'sold'=> $this->Sold,
            'display'=> $this->Display,
        ];
    }

    public function getArtworkDetail(): ?array {
        $data = [
            'id'=> $this->id,
            'workID'=> $this->Work->getId(),
            'work_title'=> $this->Work->getTitle(),
            'title'=> $this->Title,
            'creation_date'=> $this->getCreationYear(),
            'price'=> $this->Price,
            'sold'=> $this->Sold,
            'display'=> $this->Display,
        ];
        $pieces = [];
     
        foreach ($this->getPieces() as $piece) {
            $pieces[] = [
                'id' => $piece->getId(),
                'title' => $piece->getTitle(),
                'materials' => $piece->getMaterialsString(),
                'width' => $piece->getWidth(),
                'height' => $piece->getHeight(),
                'depth' => $piece->getDepth(),
                'dimensions' => $piece->getDimensions(),
                'images' => $piece->getImages(),
            ];
        }
        $data['pieces'] = $pieces;
    
        return $data;
    }

    public function getDimensions(): ?string {
        $width = 0;
        $height = 0;
        $depth = 0;
    
        foreach ($this->getPieces() as $piece) {
            $pw = $piece->getWidth();
            $ph = $piece->getHeight();
            $pd = $piece->getDepth();
            if ($pw) { $width += $pw; }
            if ($ph) { $height += $ph; }
            if ($pd) { $depth += $pd; }
        }
    
        $dimensions = [];
        if ($width > 0) { $dimensions[] = $width; }
        if ($height > 0) { $dimensions[] = $height; }
        if ($depth > 0) { $dimensions[] = $depth; }
    
        return !empty($dimensions) ? implode(" x ", $dimensions) : null;
    }
    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWork(): ?Work
    {
        return $this->Work;
    }

    public function setWork(?Work $Work): static
    {
        $this->Work = $Work;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->Creation_date;
    }

    public function setCreationDate(?\DateTimeInterface $Creation_date): static
    {
        $this->Creation_date = $Creation_date;

        return $this;
    }
    public function getCreationYear(): ?string
    {
        if ($this->Creation_date) {
            return $this->Creation_date->format("Y");
        }
        return null;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(?float $price): static
    {
        $this->Price = $price;

        return $this;
    }

    public function isSold(): ?bool
    {
        return $this->Sold;
    }

    public function setSold(bool $sold): static
    {
        $this->Sold = $sold;

        return $this;
    }

    public function getDisplay(): ?string
    {
        return $this->Display;
    }

    public function setDisplay(?string $display): static
    {
        $this->Display = $display;

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): static
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
            $piece->setArtwork($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): static
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getArtwork() === $this) {
                $piece->setArtwork(null);
            }
        }

        return $this;
    }


    // /**
    //  * @return Collection<int, Cart>
    //  */
    // public function getCarts(): Collection
    // {
    //     return $this->carts;
    // }

    // public function addCart(Cart $cart): static
    // {
    //     if (!$this->carts->contains($cart)) {
    //         $this->carts->add($cart);
    //         $cart->addArtwork($this);
    //     }

    //     return $this;
    // }

    // public function removeCart(Cart $cart): static
    // {
    //     if ($this->carts->removeElement($cart)) {
    //         $cart->removeArtwork($this);
    //     }

    //     return $this;
    // }

    public function getOrderId(): ?Order
    {
        return $this->Order;
    }

    public function setOrderId(?Order $Order): static
    {
        $this->Order = $Order;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoritedBy(): Collection
    {
        return $this->FavoritedBy;
    }

    public function addFavoritedBy(User $favoritedBy): static
    {
        if (!$this->FavoritedBy->contains($favoritedBy)) {
            $this->FavoritedBy->add($favoritedBy);
            $favoritedBy->addFavorite($this);
        }

        return $this;
    }

    public function removeFavoritedBy(User $favoritedBy): static
    {
        if ($this->FavoritedBy->removeElement($favoritedBy)) {
            $favoritedBy->removeFavorite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CartArtwork>
     */
    public function getCartArtworks(): Collection
    {
        return $this->cartArtworks;
    }

    public function addCartArtwork(CartArtwork $cartArtwork): static
    {
        if (!$this->cartArtworks->contains($cartArtwork)) {
            $this->cartArtworks->add($cartArtwork);
            $cartArtwork->setArtwork($this);
        }

        return $this;
    }

    public function removeCartArtwork(CartArtwork $cartArtwork): static
    {
        if ($this->cartArtworks->removeElement($cartArtwork)) {
            // set the owning side to null (unless already changed)
            if ($cartArtwork->getArtwork() === $this) {
                $cartArtwork->setArtwork(null);
            }
        }

        return $this;
    }

}