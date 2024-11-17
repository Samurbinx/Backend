<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 400)]
    private ?string $Street = null;

    #[ORM\Column(length: 500)]
    private ?string $Details = null;

    #[ORM\Column(length: 5)]
    private ?string $ZIP_Code = null;

    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\Column(length: 255)]
    private ?string $Province = null;


    
    public function getAddress(): ?array {
        return [
            'id'=> $this->id,
            'street'=> $this->Street,
            'details'=> $this->Details,
            'zipcode'=> $this->ZIP_Code,
            'city'=> $this->City,
            'province'=> $this->Province,
        ];
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->Street;
    }

    public function setStreet(string $Street): static
    {
        $this->Street = $Street;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->Details;
    }

    public function setDetails(string $Details): static
    {
        $this->Details = $Details;

        return $this;
    }

    public function getZIPCode(): ?string
    {
        return $this->ZIP_Code;
    }

    public function setZIPCode(string $ZIP_Code): static
    {
        $this->ZIP_Code = $ZIP_Code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): static
    {
        $this->City = $City;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->Province;
    }

    public function setProvince(string $Province): static
    {
        $this->Province = $Province;

        return $this;
    }
}
