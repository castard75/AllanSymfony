<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Interventionsitems
 *
 * @ORM\Table(name="interventionsitems", indexes={@ORM\Index(name="InterventionIdInterventionItem", columns={"InterventionId"}), @ORM\Index(name="ProductIdInterventionItem", columns={"ProductId"})})
 * @ORM\Entity
 */
class Interventionsitems
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
     * @var int|null
     *
     * @ORM\Column(name="InterventionId", type="integer", nullable=true)
     */
    private $interventionid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ProductId", type="integer", nullable=true)
     */
    private $productid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="itemprice_id", type="integer", nullable=true)
     */
    private $itempriceId;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Quantity", type="float", precision=10, scale=0, nullable=true)
     */
    private $quantity;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Unite", type="integer", nullable=true)
     */
    private $unite;

    /**
     * @var int|null
     *
     * @ORM\Column(name="supplierprice_id", type="integer", nullable=true)
     */
    private $supplierpriceId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Name", type="text", length=65535, nullable=true)
     */
    private $name;

    /**
     * @var float|null
     *
     * @ORM\Column(name="HT", type="float", precision=10, scale=0, nullable=true)
     */
    private $ht;

    /**
     * @var float|null
     *
     * @ORM\Column(name="TTC", type="float", precision=10, scale=0, nullable=true)
     */
    private $ttc;

    /**
     * @var float|null
     *
     * @ORM\Column(name="TVA", type="float", precision=10, scale=0, nullable=true)
     */
    private $tva;

    /**
     * @var float|null
     *
     * @ORM\Column(name="TauxRemise", type="float", precision=10, scale=0, nullable=true)
     */
    private $tauxremise;

    /**
     * @var float|null
     *
     * @ORM\Column(name="TauxTVA", type="float", precision=10, scale=0, nullable=true)
     */
    private $tauxtva;

    /**
     * @var int|null
     *
     * @ORM\Column(name="mode_price", type="integer", nullable=true)
     */
    private $modePrice;

    /**
     * @var int|null
     *
     * @ORM\Column(name="type_remise", type="integer", nullable=true)
     */
    private $typeRemise;

    /**
     * @var \Employees
     *
     * @ORM\ManyToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OrigineId", referencedColumnName="Id")
     * })
     */
    private $origineid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="LieeId", type="integer", nullable=true)
     */
    private ?int $lieeid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ParentId", type="integer", nullable=true)
     */
    private ?int $parentid;

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

    public function getInterventionid(): ?int
    {
        return $this->interventionid;
    }

    public function setInterventionid(?int $interventionid): static
    {
        $this->interventionid = $interventionid;

        return $this;
    }

    public function getProductid(): ?int
    {
        return $this->productid;
    }

    public function setProductid(?int $productid): static
    {
        $this->productid = $productid;

        return $this;
    }

    public function getItempriceId(): ?int
    {
        return $this->itempriceId;
    }

    public function setItempriceId(?int $itempriceId): static
    {
        $this->itempriceId = $itempriceId;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnite(): ?int
    {
        return $this->unite;
    }

    public function setUnite(?int $unite): static
    {
        $this->unite = $unite;

        return $this;
    }

    public function getSupplierpriceId(): ?int
    {
        return $this->supplierpriceId;
    }

    public function setSupplierpriceId(?int $supplierpriceId): static
    {
        $this->supplierpriceId = $supplierpriceId;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHt(): ?float
    {
        return $this->ht;
    }

    public function setHt(?float $ht): static
    {
        $this->ht = $ht;

        return $this;
    }

    public function getTtc(): ?float
    {
        return $this->ttc;
    }

    public function setTtc(?float $ttc): static
    {
        $this->ttc = $ttc;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTauxremise(): ?float
    {
        return $this->tauxremise;
    }

    public function setTauxremise(?float $tauxremise): static
    {
        $this->tauxremise = $tauxremise;

        return $this;
    }

    public function getTauxtva(): ?float
    {
        return $this->tauxtva;
    }

    public function setTauxtva(?float $tauxtva): static
    {
        $this->tauxtva = $tauxtva;

        return $this;
    }

    public function getModePrice(): ?int
    {
        return $this->modePrice;
    }

    public function setModePrice(?int $modePrice): static
    {
        $this->modePrice = $modePrice;

        return $this;
    }

    public function getTypeRemise(): ?int
    {
        return $this->typeRemise;
    }

    public function setTypeRemise(?int $typeRemise): static
    {
        $this->typeRemise = $typeRemise;

        return $this;
    }

    public function getOrigineid(): ?Employees
    {
        return $this->origineid;
    }

    public function setOrigineid(?Employees $origineid): static
    {
        $this->origineid = $origineid;

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

    public function getLieeid(): ?int
    {
        return $this->lieeid;
    }

    public function setLieeid(?int $lieeid): static
    {
        $this->lieeid = $lieeid;

        return $this;
    }

    public function getParentid(): ?int
    {
        return $this->parentid;
    }

    public function setParentid(?int $parentid): static
    {
        $this->parentid = $parentid;

        return $this;
    }
}
