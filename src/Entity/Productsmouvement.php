<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Productsmouvement
 *
 * @ORM\Table(name="productsmouvement", indexes={@ORM\Index(name="idx_stock_mouvement_fk_entrepot", columns={"EntrepotId"}), @ORM\Index(name="idx_stock_mouvement_fk_product", columns={"ProduitId"})})
 * @ORM\Entity
 */
class Productsmouvement
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="CreatedAt", type="datetime", nullable=true)
     */
    private $createdat;

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
     * @var int
     *
     * @ORM\Column(name="ProduitId", type="integer", nullable=false)
     */
    private $produitid;

    /**
     * @var int
     *
     * @ORM\Column(name="EntrepotId", type="integer", nullable=false)
     */
    private $entrepotid;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Quantite", type="float", precision=10, scale=0, nullable=true)
     */
    private $quantite;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Type", type="smallint", nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Label", type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="InventoryCode", type="string", length=128, nullable=true)
     */
    private $inventorycode;

    /**
     * @var int|null
     *
     * @ORM\Column(name="OriginId", type="integer", nullable=true)
     */
    private $originid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="OriginType", type="integer", nullable=true)
     */
    private $origintype;

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

    public function getProduitid(): ?int
    {
        return $this->produitid;
    }

    public function setProduitid(int $produitid): static
    {
        $this->produitid = $produitid;

        return $this;
    }

    public function getEntrepotid(): ?int
    {
        return $this->entrepotid;
    }

    public function setEntrepotid(int $entrepotid): static
    {
        $this->entrepotid = $entrepotid;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(?float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getInventorycode(): ?string
    {
        return $this->inventorycode;
    }

    public function setInventorycode(?string $inventorycode): static
    {
        $this->inventorycode = $inventorycode;

        return $this;
    }

    public function getOriginid(): ?int
    {
        return $this->originid;
    }

    public function setOriginid(?int $originid): static
    {
        $this->originid = $originid;

        return $this;
    }

    public function getOrigintype(): ?int
    {
        return $this->origintype;
    }

    public function setOrigintype(?int $origintype): static
    {
        $this->origintype = $origintype;

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
