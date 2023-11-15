<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Supplierinvoices
 *
 * @ORM\Table(name="supplierinvoices", indexes={@ORM\Index(name="CustomerIdInvoice", columns={"CustomerId"})})
 * @ORM\Entity
 */
class Supplierinvoices
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
     * @ORM\Column(name="ReferenceBr", type="string", length=20, nullable=true)
     */
    private $referencebr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Reference", type="string", length=20, nullable=true)
     */
    private $reference;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RefExt", type="string", length=100, nullable=true)
     */
    private $refext;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CustomerId", type="integer", nullable=true)
     */
    private $customerid;

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
     * @ORM\Column(name="DateLimit", type="date", nullable=true)
     */
    private $datelimit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Condition", type="integer", nullable=true)
     */
    private $condition;

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
     * @var float|null
     *
     * @ORM\Column(name="ToPay", type="float", precision=10, scale=0, nullable=true)
     */
    private $topay;

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
     * @var int|null
     *
     * @ORM\Column(name="Mode", type="integer", nullable=true, options={"default"="1"})
     */
    private $mode = 1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Message", type="string", length=250, nullable=true)
     */
    private $message;

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
     * @ORM\Column(name="Type", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="transfert", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $transfert;

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

    public function getRefext(): ?string
    {
        return $this->refext;
    }

    public function setRefext(?string $refext): static
    {
        $this->refext = $refext;

        return $this;
    }

    public function getCustomerid(): ?int
    {
        return $this->customerid;
    }

    public function setCustomerid(?int $customerid): static
    {
        $this->customerid = $customerid;

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

    public function getDatelimit(): ?\DateTimeInterface
    {
        return $this->datelimit;
    }

    public function setDatelimit(?\DateTimeInterface $datelimit): static
    {
        $this->datelimit = $datelimit;

        return $this;
    }

    public function getCondition(): ?int
    {
        return $this->condition;
    }

    public function setCondition(?int $condition): static
    {
        $this->condition = $condition;

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

    public function getTopay(): ?float
    {
        return $this->topay;
    }

    public function setTopay(?float $topay): static
    {
        $this->topay = $topay;

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

    public function getMode(): ?int
    {
        return $this->mode;
    }

    public function setMode(?int $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTransfert(): ?string
    {
        return $this->transfert;
    }

    public function setTransfert(string $transfert): static
    {
        $this->transfert = $transfert;

        return $this;
    }


}
