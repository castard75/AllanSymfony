<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Customerssites
 *
 * @ORM\Table(name="customerssites", indexes={@ORM\Index(name="ClientId", columns={"ClientId"})})
 * @ORM\Entity
 */
class Customerssites
{
    public function __construct()
    {
        $this->createdat = new \DateTime('now');
        $this->updatedat = new \DateTime('now');
    }
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Reference", type="string", length=255, nullable=true)
     */
    private $reference;
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="Label", type="string", length=250, nullable=true)
     */
    #[Assert\NotBlank(message: 'Le champ ne peut pas être vide !')]
    #[Assert\Regex(pattern: '/^[A-Za-z0-9\séè]+$/', message: 'Seul les chiffres, les lettres et espaces sont autorisés !')]
    private $label;

    /**
     * @var string|null
     * 
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     */
    #[Assert\Regex(pattern: '/^[A-Za-z0-9\séè]+$/', message: 'Seul les chiffres, les lettres et espaces sont autorisés !')]
    private $address;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="CreatedAt", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="UpdatedAt", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedat = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DeletedAt", type="datetime", nullable=true)
     */
    private $deletedat;

    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ClientId", referencedColumnName="Id")
     * })
     */
    private $clientid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

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

    public function getClientid(): ?Customers
    {
        return $this->clientid;
    }

    public function setClientid(?Customers $clientid): static
    {
        $this->clientid = $clientid;

        return $this;
    }


}
