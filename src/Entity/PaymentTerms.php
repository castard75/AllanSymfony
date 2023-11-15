<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentTerms
 *
 * @ORM\Table(name="payment_terms")
 * @ORM\Entity
 */
class PaymentTerms
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
     * @ORM\Column(name="Code", type="string", length=20, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sort", type="string", length=4, nullable=true)
     */
    private $sort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Label", type="string", length=150, nullable=true)
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Descr", type="string", length=150, nullable=true)
     */
    private $descr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="TypeCdr", type="integer", nullable=true)
     */
    private $typecdr;

    /**
     * @var int|null
     *
     * @ORM\Column(name="NbJour", type="integer", nullable=true)
     */
    private $nbjour;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Decalage", type="integer", nullable=true)
     */
    private $decalage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Module", type="string", length=150, nullable=true)
     */
    private $module;

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
     * @var string|null
     *
     * @ORM\Column(name="transfert", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $transfert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(?string $sort): static
    {
        $this->sort = $sort;

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

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(?string $descr): static
    {
        $this->descr = $descr;

        return $this;
    }

    public function getTypecdr(): ?int
    {
        return $this->typecdr;
    }

    public function setTypecdr(?int $typecdr): static
    {
        $this->typecdr = $typecdr;

        return $this;
    }

    public function getNbjour(): ?int
    {
        return $this->nbjour;
    }

    public function setNbjour(?int $nbjour): static
    {
        $this->nbjour = $nbjour;

        return $this;
    }

    public function getDecalage(): ?int
    {
        return $this->decalage;
    }

    public function setDecalage(?int $decalage): static
    {
        $this->decalage = $decalage;

        return $this;
    }

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function setModule(?string $module): static
    {
        $this->module = $module;

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


}
