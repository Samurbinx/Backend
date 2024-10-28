<?php
namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\JsonResponse;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\ManyToOne(inversedBy: 'Pieces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artwork $Artwork = null;



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;



    #[ORM\Column(nullable: true)]
    private ?float $Height = null;
    
    #[ORM\Column(nullable: true)]
    private ?float $Width = null;

    #[ORM\Column(nullable: true)]
    private ?float $Depth = null;
    
    #[ORM\Column(nullable: true)]
    private ?array $Images = null;

    /**
     * @var Collection<int, Materials>
     */
    #[ORM\ManyToMany(targetEntity: Materials::class, inversedBy: 'pieces')]
    private Collection $Materials;




   
    public function __construct()
    {
        $this->Materials = new ArrayCollection();
    }

    public function getPiece(): ?array {
        return [
            'id'=> $this->id,
            'artworkID'=> $this->Artwork->getId(),
            'title'=> $this->Title,
            'materials'=> $this->getMaterialsName(),
            'width'=> $this->Width,
            'height'=> $this->Height,
            'depth'=> $this->Depth,
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

    public function getDepth(): ?float
    {
        return $this->Depth;
    }

    public function setDepth(?float $Depth): static
    {
        $this->Depth = $Depth;

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




    public function getArtwork(): ?Artwork
    {
        return $this->Artwork;
    }

    public function setArtwork(?Artwork $Artwork): static
    {
        $this->Artwork = $Artwork;

        return $this;
    }

    /**
     * @return Collection<int, Materials>
     */
    public function getMaterials(): Collection
    {
        return $this->Materials;
    }
    public function getMaterialsName(): ?array
    {
        $materials = [];
        foreach ($this->Materials as $name => $material) {
            array_push($materials, $material->getName());
        }
        return $materials;
    }

    public function addMaterial(Materials $material): static
    {
        if (!$this->Materials->contains($material)) {
            $this->Materials->add($material);
        }

        return $this;
    }

    public function removeMaterial(Materials $material): static
    {
        $this->Materials->removeElement($material);

        return $this;
    }
    
}
