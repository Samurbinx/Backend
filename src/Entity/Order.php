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

    #[ORM\Column(length: 255)]
    private ?array $address = [];

    public function __construct()
    {
        $this->Artworks = new ArrayCollection();
    }

    public function getOrderDetails(): ?array
    {
        $data = [
            'id' => $this->id,
            'user_id' => $this->getUser()->getId(),
            'total_amount' => $this->Total_amount,
            'created_at' => $this->getDate(),
            'status' => $this->getEstado(),
            'address' => $this->getAddress(),
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
    public function getEstado(): ?string
    {
        switch (strtolower($this->status)) {
            case 'pending':
                return 'Pendiente';
            case 'confirmed':
                return 'Confirmado';
            case 'processing':
                return 'En preparación';
            case 'ready_for_shipment':
                return 'Listo para envío';
            case 'shipped':
                return 'Enviado';
            case 'in_transit':
                return 'En tránsito';
            case 'delivered':
                return 'Entregado';
            case 'on_hold':
                return 'En espera';
            case 'canceled':
                return 'Cancelado';
            case 'returned':
                return 'Devuelto';
            case 'refunded':
                return 'Reembolsado';
            case 'lost':
                return 'Extraviado';
            case 'shipping_incident':
                return 'Incidente en envío';
            default:
                return null;
        }
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAddress(): ?array
    {
        return $this->address;
    }

    public function getAddressString(): ?string
{
    // Verificamos si el array de dirección existe y contiene las claves necesarias
    $address = $this->address;
    
    // Concatenamos de manera segura los valores de la dirección
    $street = isset($address['street']) ? $address['street'] : '';
    $details = isset($address['details']) ? $address['details'] : '';
    $zipcode = isset($address['zipcode']) ? $address['zipcode'] : '';
    $city = isset($address['city']) ? $address['city'] : '';
    $province = isset($address['province']) ? $address['province'] : '';
    
    // Devolvemos la dirección como una cadena
    return $street . ' ' . $details . ', ' . $zipcode . ' - ' . $city . ', ' . $province;
}


    public function setAddress(array $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getRecipient(): ?string
    {
        // Verificamos si el array de dirección existe y contiene las claves necesarias
        $address = $this->address;
        
        // Concatenamos de manera segura los valores de la dirección
        $recipient = isset($address['recipient']) ? $address['recipient'] : '';
        return $recipient;
        
    }
    public function getPhone(): ?string
    {
        // Verificamos si el array de dirección existe y contiene las claves necesarias
        $address = $this->address;
        
        // Concatenamos de manera segura los valores de la dirección
        $phone = isset($address['phone']) ? $address['phone'] : '';
        return $phone;        
    }
}
