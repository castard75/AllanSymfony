<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customerstiers
 *
 * @ORM\Table(name="Customerstiers")
 * @ORM\Entity
 */
/**
 * Contracts
 *
 * @ORM\Table(name="Customerstiers", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Customerstiers
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
     * @ORM\Column(name="idemployee", type="string", length=250, nullable=true)
     */
    private $idemployee;



    /**
     * @var string|null
     *
     * @ORM\Column(name="idcustomer", type="string", length=250, nullable=true)
     */
    private $idcustomer;


    /**
     * @var string|null
     *
     * @ORM\Column(name="refcustomer", type="string", length=250, nullable=true)
     */
    private $refcustomer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="labelcustomer", type="string", length=250, nullable=true)
     */
    private $labelcustomer;
    /**
     * @var string|null
     *
     * @ORM\Column(name="statuscustomer", type="string", length=250, nullable=true)
     */
    private $statuscustomer;

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


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEmployee(): ?string
    {
        return $this->idemployee;
    }

    public function setIdEmployee(?string $idemployee): static
    {
        $this->idemployee = $idemployee;

        return $this;
    }

    public function getIdCustomer(): ?string
    {
        return $this->idcustomer;
    }

    public function setIdCustomer(?string $idcustomer): static
    {
        $this->idcustomer = $idcustomer;

        return $this;
    }
    public function getRefCustomer(): ?string
    {
        return $this->refcustomer;
    }

    public function setRefCustomer(?string $refcustomer): static
    {
        $this->refcustomer = $refcustomer;

        return $this;
    }
    public function getStatusCustomer(): ?string
    {
        return $this->statuscustomer;
    }

    public function setStatusCustomer(?string $statuscustomer): static
    {
        $this->statuscustomer = $statuscustomer;

        return $this;
    }


    public function getLabelCustomer(): ?string
    {
        return $this->labelcustomer;
    }

    public function setLabelCustomer(?string $labelcustomer): static
    {
        $this->labelcustomer = $labelcustomer;

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
}
