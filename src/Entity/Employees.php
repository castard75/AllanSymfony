<?php

namespace App\Entity;

use App\Repository\EmployeesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EmployeesRepository::class)]
#[UniqueEntity(fields: ['login'], message: 'There is already an account with this login')]


/**
 * Employees
 *
 * @ORM\Table(name="employees")
 * @ORM\Entity
 */

class Employees implements UserInterface, PasswordAuthenticatedUserInterface
{
     /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="login", type="string", length=180, unique=true, nullable=false)
     */
    private ?string $login = null;

    /**
     * @ORM\Column(name="roles", type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(name="password", type="string")
     */
    private ?string $password = null;

    /**
     * @ORM\Column(name="civilityid", type="integer", nullable=true)
     */
    private ?int $civilityid = null;

    /**
     * @ORM\Column(name="name", type="string", length=150, nullable=true)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(name="firstname", type="string", length=150, nullable=true)
     */
    private ?string $firstname = null;

    /**
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private ?string $address = null;

    /**
     * @ORM\Column(name="additionaladdress", type="string", length=255, nullable=true)
     */
    private ?string $additionaladdress = null;

    /**
     * @ORM\Column(name="cityid", type="integer", nullable=true)
     */
    private ?int $cityid = null;

    /**
     * @ORM\Column(name="postcode", type="string", length=10, nullable=true)
     */
    private ?string $postcode = null;

    /**
     * @ORM\Column(name="namecity", type="string", length=255, nullable=true)
     */
    private ?string $namecity = null;

    /**
     * @ORM\Column(name="countryid", type="integer", nullable=true)
     */
    private ?int $countryid = null;

    /**
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private ?string $phone = null;

    /**
     * @ORM\Column(name="phonemobile", type="string", length=20, nullable=true)
     */
    private ?string $phonemobile = null;

    /**
     * @ORM\Column(name="mail", type="string", length=150, nullable=true)
     */
    private ?string $mail = null;

    /**
     * @ORM\Column(name="role", type="string", length=1, nullable=true)
     */
    private ?string $role = null;

    /**
     * @ORM\Column(name="function", type="integer", nullable=true)
     */
    private ?int $function = null;

    /**
     * @ORM\Column(name="state", type="string", length=1, nullable=true)
     */
    private ?string $state = null;

    /**
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $createdat = null;

    /**
     * @ORM\Column(name="updatedat", type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedat = null;

    /**
     * @ORM\Column(name="deletedat", type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $deletedat = null;

    /**
     * @ORM\Column(name="transfert", type="string", length=1, nullable=true)
     */
    private ?string $transfert = null;

    /**
     * @ORM\Column(name="origineid", type="integer", nullable=true)
     */
    private ?int $origineid = null;

    private ?string $plainPassword = null;

public function getPlainPassword(): ?string
{
    return $this->plainPassword;
}

public function setPlainPassword(string $plainPassword): static
{
    $this->plainPassword = $plainPassword;

    return $this;
}


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER 
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
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

    public function getCivilityid(): ?int
    {
        return $this->civilityid;
    }

    public function setCivilityid(?int $civilityid): static
    {
        $this->civilityid = $civilityid;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAdditionaladdress(): ?string
    {
        return $this->additionaladdress;
    }

    public function setAdditionaladdress(?string $additionaladdress): static
    {
        $this->additionaladdress = $additionaladdress;

        return $this;
    }

    public function getCityid(): ?int
    {
        return $this->cityid;
    }

    public function setCityid(?int $cityid): static
    {
        $this->cityid = $cityid;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): static
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getNamecity(): ?string
    {
        return $this->namecity;
    }

    public function setNamecity(?string $namecity): static
    {
        $this->namecity = $namecity;

        return $this;
    }

    public function getCountryid(): ?int
    {
        return $this->countryid;
    }

    public function setCountryid(?int $countryid): static
    {
        $this->countryid = $countryid;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhonemobile(): ?string
    {
        return $this->phonemobile;
    }

    public function setPhonemobile(?string $phonemobile): static
    {
        $this->phonemobile = $phonemobile;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getFunction(): ?int
    {
        return $this->function;
    }

    public function setFunction(?int $function): static
    {
        $this->function = $function;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): static
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getDeletedat(): ?\DateTimeInterface
    {
        return $this->deletedat;
    }

    public function setDeletedat(?\DateTimeInterface $deletedat): static
    {
        $this->deletedat = $deletedat;

        return $this;
    }

    public function getTransfert(): ?string
    {
        return $this->transfert;
    }

    public function setTransfert(?string $transfert): static
    {
        $this->transfert = $transfert;

        return $this;
    }

    public function getOrigineid(): ?int
    {
        return $this->origineid;
    }

    public function setOrigineid(?int $origineid): static
    {
        $this->origineid = $origineid;

        return $this;
    }


}
