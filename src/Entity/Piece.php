<?php
namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Creation_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Materials = null;

    #[ORM\Column(nullable: true)]
    private ?float $Height = null;
    
    #[ORM\Column(nullable: true)]
    private ?float $Width = null;
    
    

    #[ORM\Column(nullable: true)]
    private ?float $Depht = null;

    #[ORM\ManyToOne(inversedBy: 'Pieces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Work $Work = null;

    
    #[ORM\Column(nullable: true)]
    private ?array $Images = null;



   
    public function __construct()
    {
    }

    public function getPiece(): ?array {
        return [
            'id'=> $this->id,
            'workID'=> $this->Work,
            'title'=> $this->Title,
            'date'=> $this->Creation_date,
            'materials'=> $this->Materials,
            'width'=> $this->Width,
            'height'=> $this->Height,
            'depht'=> $this->Depht,
        ];
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreationYear(): ?string
    {
        $year = $this->Creation_date;

        if ($year) {
            $year = $year->format('Y');
        } else {
            $year = null;
        }
        return $year;
    }

    public function setCreationDate(?\DateTimeInterface $Creation_date): static
    {
        $this->Creation_date = $Creation_date;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->Materials;
    }

    public function setMaterials(?string $Materials): static
    {
        $this->Materials = $Materials;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->Height;
    }

    public function setHeight(?float $Height): static
    {
        $this->Height = $Height;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->Width;
    }

    public function setWidth(?string $Width): static
    {
        $this->Width = $Width;

        return $this;
    }

    public function getDepht(): ?float
    {
        return $this->Depht;
    }

    public function setDepht(?float $Depht): static
    {
        $this->Depht = $Depht;

        return $this;
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

    public function getImages(): ?array
    {
        return $this->Images;
    }

    public function setImages(?array $Images): static
    {
        $this->Images = $Images;

        return $this;
    }

    public function addImage(?string $image): static
    {
        if ($image !== null) {
            array_push($this->Images, $image);
        }
        return $this;
    }
    public function deleteImage(?string $image): static
    {
        if ($image !== null && in_array($image, $this->Images)) {
            $this->Images = array_filter($this->Images, fn($img) => $img !== $image);
        }
        return $this;
    }
    
}
