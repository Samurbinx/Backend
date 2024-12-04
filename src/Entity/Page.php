<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $Subtitle = null;


    public function __construct(
        ?string $Name = null,
        ?string $Image = null,
        ?string $Title = null,
        ?string $Subtitle = null,
    ) {
        $this->Name = $Name;
        $this->Image = $Image;
        $this->Title = $Title;
        $this->Subtitle = $Subtitle;
    }
    public function getPage(): ?array {
        $id = $this->id;
        return [
            'id'=> $this->id,
            'image'=> $this->Image,
            'title'=> $this->Title,
            'subtitle'=> $this->Subtitle, 
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

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

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->Subtitle;
    }

    public function setSubtitle(?string $Subtitle): static
    {
        $this->Subtitle = $Subtitle;

        return $this;
    }
}
