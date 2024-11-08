<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

  
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Surname = null;

    #[ORM\Column(length: 255)]
    private ?string $Nick = null;

    #[ORM\Column(length: 255)]
    private ?string $Phone = null;

      /**
     * @var  list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 700, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsValidT = null;

    /**
     * @var Collection<int, Artwork>
     */
    #[ORM\ManyToMany(targetEntity: Artwork::class, inversedBy: 'FavoritedBy')]
    private Collection $Favorites;

    #[ORM\OneToOne(mappedBy: 'User_id', cascade: ['persist', 'remove'])]
    private ?Cart $cart = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'User')]
    private Collection $orders;

    public function __construct()
    {
        $this->Favorites = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }


 


    public function getUser(): ?array {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'pwd' => $this->password,
            'name' => $this->Name,
            'surname' => $this->Surname,
            'nick' => $this->Nick,
            'phone' => $this->Phone
        ];
    }

    public function getUserSafe(): ?array {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->Name,
            'surname' => $this->Surname,
            'nick' => $this->Nick,
            'phone' => $this->Phone
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): static
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getNick(): ?string
    {
        return $this->Nick;
    }

    public function setNick(string $Nick): static
    {
        $this->Nick = $Nick;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(string $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    /**
     * @see UserInterface
     * 
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $Token): static
    {
        $this->token = $Token;

        return $this;
    }

    public function isValidT(): ?bool
    {
        return $this->IsValidT;
    }

    public function setValidT(?bool $IsValidT): static
    {
        $this->IsValidT = $IsValidT;

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getFavorites(): Collection
    {
        return $this->Favorites;
    }

    public function addFavorite(Artwork $favorite): static
    {
        if (!$this->Favorites->contains($favorite)) {
            $this->Favorites->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(Artwork $favorite): static
    {
        $this->Favorites->removeElement($favorite);

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): static
    {
        // set the owning side of the relation if necessary
        if ($cart->getUserId() !== $this) {
            $cart->setUserId($this);
        }

        $this->cart = $cart;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }




}

