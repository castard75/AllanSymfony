<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Estimations
 *
 * @ORM\Table(name="estimations", indexes={@ORM\Index(name="OrigineId", columns={"OrigineId"}), @ORM\Index(name="CustomerIdEstimations", columns={"CustomerId"})})
 * @ORM\Entity
 */
class Estimations
{
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
     * @ORM\Column(name="ReferenceBr", type="string", length=200, nullable=true)
     */
    private $referencebr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Reference", type="string", length=20, nullable=true)
     */
    private $reference;

    

    /**
     * @var int|null
     *
     * @ORM\Column(name="extendId", type="integer", nullable=true)
     */
    private $extendid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="State", type="integer", nullable=true)
     */
    private $state;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date", type="date", nullable=true)
     */
    private $date;



    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateValidation", type="date", nullable=true)
     */
    private $datevalidation;

    /**
     * @var float|null
     *
     * @ORM\Column(name="TotalHT", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalht;

    /**
     * @var float|null
     *
     * @ORM\Column(name="TotalTTC", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalttc;

    /**
     * @var float|null
     *
     * @ORM\Column(name="TotalTVA", type="float", precision=10, scale=0, nullable=true)
     */
    private $totaltva;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DeletedAt", type="datetime", nullable=true)
     */
    private $deletedat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NotePublic", type="text", length=65535, nullable=true)
     */
    private $notepublic;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NotePrive", type="text", length=65535, nullable=true)
     */
    private $noteprive;

    /**
     * @var string|null
     *
     * @ORM\Column(name="transfert", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $transfert;

    /**
     * @var \Myconnectors
     *
     * @ORM\ManyToOne(targetEntity="Myconnectors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OrigineId", referencedColumnName="Id")
     * })
     */
    private $origineid;
    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CustomerId", referencedColumnName="Id")
     * })
     */
    private $customerid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferencebr(): ?string
    {
        return $this->referencebr;
    }

    public function setReferencebr(?string $referencebr): static
    {
        $this->referencebr = $referencebr;

        return $this;
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

    // public function getRefext(): ?string
    // {
    //     return $this->refext;
    // }

    // public function setRefext(?string $refext): static
    // {
    //     $this->refext = $refext;

    //     return $this;
    // }

    public function getExtendid(): ?int
    {
        return $this->extendid;
    }

    public function setExtendid(?int $extendid): static
    {
        $this->extendid = $extendid;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->datevalidation;
    }

    public function setDateValidation(?\DateTimeInterface $datevalidation): static
    {
        $this->datevalidation = $datevalidation;

        return $this;
    }

    public function getTotalht(): ?float
    {
        return $this->totalht;
    }

    public function setTotalht(?float $totalht): static
    {
        $this->totalht = $totalht;

        return $this;
    }

    public function getTotalttc(): ?float
    {
        return $this->totalttc;
    }

    public function setTotalttc(?float $totalttc): static
    {
        $this->totalttc = $totalttc;

        return $this;
    }

    public function getTotaltva(): ?float
    {
        return $this->totaltva;
    }

    public function setTotaltva(?float $totaltva): static
    {
        $this->totaltva = $totaltva;

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

    public function getNotepublic(): ?string
    {
        return $this->notepublic;
    }

    public function setNotepublic(?string $notepublic): static
    {
        $this->notepublic = $notepublic;

        return $this;
    }

    public function getNoteprive(): ?string
    {
        return $this->noteprive;
    }

    public function setNoteprive(?string $noteprive): static
    {
        $this->noteprive = $noteprive;

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

    public function getOrigineid(): ?Myconnectors
    {
        return $this->origineid;
    }

    public function setOrigineid(?Myconnectors $origineid): static
    {
        $this->origineid = $origineid;

        return $this;
    }

    public function getCustomerid(): ?Customers
    {
        return $this->customerid;
    }

    public function setCustomerid(?Customers $customerid): static
    {
        $this->customerid = $customerid;

        return $this;
    }


}
