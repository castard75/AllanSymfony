<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sda
 *
 * @ORM\Table(name="sda", indexes={@ORM\Index(name="IDX_92D2F076119D6490", columns={"fk_paramsda_id"})})
 * @ORM\Entity
 */
class Sda
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="text", length=0, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=255, nullable=false)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=false)
     */
    private $origin;

    /**
     * @var float
     *
     * @ORM\Column(name="price_supplier", type="float", precision=10, scale=0, nullable=false)
     */
    private $priceSupplier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="guid", length=36, nullable=false, options={"fixed"=true})
     */
    private $uuid;

    /**
     * @var int
     *
     * @ORM\Column(name="origin_id", type="integer", nullable=false)
     */
    private $originId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="activate", type="string", length=1, nullable=false)
     */
    private $activate;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="param_api", type="integer", nullable=true)
     */
    private $paramApi;

    /**
     * @var \ParamSda
     *
     * @ORM\ManyToOne(targetEntity="ParamSda")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_paramsda_id", referencedColumnName="id")
     * })
     */
    private $fkParamsda;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Licence", mappedBy="sda")
     */
    private $licence = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->licence = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getPriceSupplier(): ?float
    {
        return $this->priceSupplier;
    }

    public function setPriceSupplier(float $priceSupplier): static
    {
        $this->priceSupplier = $priceSupplier;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getOriginId(): ?int
    {
        return $this->originId;
    }

    public function setOriginId(int $originId): static
    {
        $this->originId = $originId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getActivate(): ?string
    {
        return $this->activate;
    }

    public function setActivate(string $activate): static
    {
        $this->activate = $activate;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getParamApi(): ?int
    {
        return $this->paramApi;
    }

    public function setParamApi(?int $paramApi): static
    {
        $this->paramApi = $paramApi;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkParamsda(): ?ParamSda
    {
        return $this->fkParamsda;
    }

    public function setFkParamsda(?ParamSda $fkParamsda): static
    {
        $this->fkParamsda = $fkParamsda;

        return $this;
    }

    /**
     * @return Collection<int, Licence>
     */
    public function getLicence(): Collection
    {
        return $this->licence;
    }

    public function addLicence(Licence $licence): static
    {
        if (!$this->licence->contains($licence)) {
            $this->licence->add($licence);
            $licence->addSda($this);
        }

        return $this;
    }

    public function removeLicence(Licence $licence): static
    {
        if ($this->licence->removeElement($licence)) {
            $licence->removeSda($this);
        }

        return $this;
    }

}
