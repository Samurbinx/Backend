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


    public function __construct()
    {
        $this->pieces = new ArrayCollection();
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
        $data = $this->getArtwork();
        $pieces = [];
     
        foreach ($this->getPieces() as $piece) {
            $pieces[] = [
                'id' => $piece->getId(),
                'title' => $piece->getTitle(),
                'materials' => $piece->getMaterials(),
                'width' => $piece->getWidth(),
                'height' => $piece->getHeight(),
                'depth' => $piece->getDepht(),
                'images' => $piece->getImages(),
            ];
        }
        $data['pieces'] = $pieces;
    
        return $data;
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
        return $this->Creation_date->format("Y");
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

}