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

    public function getPiece(): ?array
    {
        return [
            'id' => $this->id,
            'artworkID' => $this->Artwork->getId(),
            'title' => $this->Title,
            'materials' => $this->getMaterialsName(),
            'width' => $this->Width,
            'height' => $this->Height,
            'depth' => $this->Depth,
            'dimensions' => $this->getDimensions(),
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

    public function getDimensions(): ?string{
        $dimensions = [];
        if ($this->Width > 0) { $dimensions[] = $this->Width; }
        if ($this->Height > 0) { $dimensions[] = $this->Height; }
        if ($this->Depth > 0) { $dimensions[] = $this->Depth; }
    
        return !empty($dimensions) ? implode(" x ", $dimensions) : null;
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
        return array_map(fn($material) => $material->getName(), $this->Materials->toArray());
    }
    public function getMaterialsString(): ?string
    {
        $arr = $this->getMaterialsName();
        $count = count($arr);

        if ($count === 0) return "";

        // Formateamos los nombres a minúsculas
        $formattedArray = array_map('strtolower', $arr);

        // Capitalizamos la primera letra del primer elemento
        $formattedArray[0] = ucfirst($formattedArray[0]);

        // Si solo hay un elemento, lo devolvemos tal cual
        if ($count === 1) return $formattedArray[0];

        // Si hay dos elementos, los unimos con " y "
        if ($count === 2) return implode(" y ", $formattedArray);

        // Para más de dos elementos, unimos todos excepto el último con ", " y el último con " y "
        $allButLast = implode(", ", array_slice($formattedArray, 0, -1));
        $last = end($formattedArray);

        return "$allButLast y $last";
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
    public function removeAllMaterials(): static {
        $materials = $this->Materials;
        foreach ($materials as $material) {
            $this->removeMaterial($material);
        }
        return $this;
    }
}
