<?php

namespace App\Entity;

use App\Repository\WorkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkRepository::class)]
class Work
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $Statement = null;

    /**
     * @var Collection<int, Piece>
     */
    #[ORM\OneToMany(targetEntity: Piece::class, mappedBy: 'Work')]
    private Collection $Pieces;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;
    
    public function __construct()
    {
        $this->Pieces = new ArrayCollection();
    }

    public function getWork(): ?array {
        $id = $this->id;
        return [
            'id'=> $this->id,
            'title'=> $this->Title,
            'statement'=> $this->Statement,
            'description'=> $this->Description,
            'image'=> $this->Image,
            'url'=>"http://127.0.0.1:8080/work/$id/img"
        ];
    }

    public function getWorkDetail(): ?array {
        $data = $this->getWork();
        $pieces = [];
    
        foreach ($this->getPieces() as $piece) {
            $pieces[] = [
                'id' => $piece->getId(),
                'title' => $piece->getTitle(),
                'creation_date' => $piece->getCreationYear(),
                'materials' => $piece->getMaterials(),
                'width' => $piece->getWidth(),
                'height' => $piece->getHeight(),
                'depth' => $piece->getDepht(),
                'images' => $piece->getImages()
            ];
        }
    
        // Añadir la información de las piezas al array $data
        $data['pieces'] = $pieces;
    
        return $data;
    }
    

    public function getAssetsRoute(): string {
        $route = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $this->Title);
        $route = preg_replace('/[^A-Za-z\s]/', '', $route);
        $route = str_replace(' ', '-', $route);
        $route = strtolower($route);
    
        return $route;
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

    public function getStatement(): ?string
    {
        return $this->Statement;
    }

    public function setStatement(?string $Statement): static
    {
        $this->Statement = $Statement;

        return $this;
    }

  

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->Pieces;
    }

    public function addPiece(Piece $piece): static
    {
        if (!$this->Pieces->contains($piece)) {
            $this->Pieces->add($piece);
            $piece->setWork($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): static
    {
        if ($this->Pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getWork() === $this) {
                $piece->setWork(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }
}
