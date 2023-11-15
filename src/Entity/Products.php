<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Products
{


    public function __construct()
    {
        $this->createdat = new \DateTime('now');
        $this->updatedat = new \DateTime('now');
        $this->transfert = '0';
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
     * @ORM\Column(name="Reference", type="string", length=50, nullable=true)
     */
    private $reference;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Designation", type="text", length=65535, nullable=true)
     */
    private $designation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Tva", type="float", precision=10, scale=0, nullable=true)
     */
    private $tva;

    /**
     * @var float|null
     *
     * @ORM\Column(name="PriceHT", type="float", precision=10, scale=0, nullable=true)
     */
    private $priceht;

    /**
     * @var float|null
     *
     * @ORM\Column(name="PriceTTC", type="float", precision=10, scale=0, nullable=true)
     */
    private $pricettc;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Pump", type="float", precision=10, scale=0, nullable=true)
     */
    private $pump;

    /**
     * @var float|null
     *
     * @ORM\Column(name="StockReal", type="float", precision=10, scale=0, nullable=true)
     */
    private $stockreal;

    /**
     * @var float|null
     *
     * @ORM\Column(name="StockDesire", type="float", precision=10, scale=0, nullable=true)
     */
    private $stockdesire;

    /**
     * @var float|null
     *
     * @ORM\Column(name="StockAlert", type="float", precision=10, scale=0, nullable=true)
     */
    private $stockalert;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Unite", type="integer", nullable=true)
     */
    private $unite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ToSell", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $tosell;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ToBuy", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $tobuy;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Brand", type="integer", nullable=true)
     */
    private $brand;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Size", type="string", length=100, nullable=true)
     */
    private $size;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Mode", type="integer", nullable=true, options={"default"="1"})
     */
    private $mode = 1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="BarCode", type="string", length=50, nullable=true)
     */
    private $barcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SellCode", type="string", length=10, nullable=true)
     */
    private $sellcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="BuyCode", type="string", length=10, nullable=true)
     */
    private $buycode;

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
     * @ORM\Column(name="Classe", type="integer", nullable=true)
     */
    private $classe;

    /**
     * @var string
     *
     * @ORM\Column(name="transfert", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $transfert;

    /**
     * @var int|null
     *
     * @ORM\Column(name="GroupProductPrice", type="integer", nullable=true)
     */
    private $groupproductprice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RefExt", type="string", length=100, nullable=true)
     */
    private $refext;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getPriceht(): ?float
    {
        return $this->priceht;
    }

    public function setPriceht(?float $priceht): static
    {
        $this->priceht = $priceht;

        return $this;
    }

    public function getPricettc(): ?float
    {
        return $this->pricettc;
    }

    public function setPricettc(?float $pricettc): static
    {
        $this->pricettc = $pricettc;

        return $this;
    }

    public function getPump(): ?float
    {
        return $this->pump;
    }

    public function setPump(?float $pump): static
    {
        $this->pump = $pump;

        return $this;
    }

    public function getStockreal(): ?float
    {
        return $this->stockreal;
    }

    public function setStockreal(?float $stockreal): static
    {
        $this->stockreal = $stockreal;

        return $this;
    }

    public function getStockdesire(): ?float
    {
        return $this->stockdesire;
    }

    public function setStockdesire(?float $stockdesire): static
    {
        $this->stockdesire = $stockdesire;

        return $this;
    }

    public function getStockalert(): ?float
    {
        return $this->stockalert;
    }

    public function setStockalert(?float $stockalert): static
    {
        $this->stockalert = $stockalert;

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

    public function getTosell(): ?string
    {
        return $this->tosell;
    }

    public function setTosell(?string $tosell): static
    {
        $this->tosell = $tosell;

        return $this;
    }

    public function getTobuy(): ?string
    {
        return $this->tobuy;
    }

    public function setTobuy(?string $tobuy): static
    {
        $this->tobuy = $tobuy;

        return $this;
    }

    public function getBrand(): ?int
    {
        return $this->brand;
    }

    public function setBrand(?int $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): static
    {
        $this->type = $type;

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

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getSellcode(): ?string
    {
        return $this->sellcode;
    }

    public function setSellcode(?string $sellcode): static
    {
        $this->sellcode = $sellcode;

        return $this;
    }

    public function getBuycode(): ?string
    {
        return $this->buycode;
    }

    public function setBuycode(?string $buycode): static
    {
        $this->buycode = $buycode;

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

    public function getClasse(): ?int
    {
        return $this->classe;
    }

    public function setClasse(?int $classe): static
    {
        $this->classe = $classe;

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

    public function getGroupproductprice(): ?int
    {
        return $this->groupproductprice;
    }

    public function setGroupproductprice(?int $groupproductprice): static
    {
        $this->groupproductprice = $groupproductprice;

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
}
