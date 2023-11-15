<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Equipments
 *
 * @ORM\Table(name="equipments", indexes={@ORM\Index(name="OrigineId", columns={"OrigineId"}), @ORM\Index(name="ContratID", columns={"ContratID"}), @ORM\Index(name="CustomerId", columns={"CustomerId"}), @ORM\Index(name="SiteId", columns={"SiteId"})})
 * @ORM\Entity
 */
class Equipments
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
     * @ORM\Column(name="DolId", type="integer", nullable=true)
     */
    private $dolid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Name", type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="trprincipal", type="string", length=150, nullable=true)
     */
    private $trprincipal;


    /**
     * @var string|null
     *
     * @ORM\Column(name="trsecondaire", type="string", length=150, nullable=true)
     */
    private $trsecondaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codesite", type="string", length=150, nullable=true)
     */
    private $codesite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresseip", type="string", length=150, nullable=true)
     */
    private $adresseip;


    /**
     * @var string|null
     *
     * @ORM\Column(name="Reference", type="string", length=50, nullable=true)
     */
    private $reference;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Status", type="integer", nullable=true, options={"default"="1"})
     */
    private $status = 1;

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

    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CustomerId", referencedColumnName="Id")
     * })
     */
    private $customerid;

    /**
     * @var \Customerssites
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customerssites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SiteId", referencedColumnName="Id")
     * })
     */
    private $siteid;

    /**
     * @var \Equipementcharge
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipementCharge")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ChargeId", referencedColumnName="Id")
     * })
     */
    private $chargeid;

    /**
     * @var \EquipementEntrainement
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipementEntrainement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EntrainementId", referencedColumnName="Id")
     * })
     */
    private $entrainementid;

    /**
     * @var \EquipementType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipementType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TypeId", referencedColumnName="Id")
     * })
     */
    private $typeid;

    /**
     * @var \EquipementMarque
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipementMarque")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MarqueId", referencedColumnName="Id")
     * })
     */
    private $marqueid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Niveau", type="integer", nullable=true)
     */
    private $niveau = 1;

    /**
     * @var \Contracts
     *
     * @ORM\ManyToOne(targetEntity="Contracts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ContratID", referencedColumnName="Id")
     * })
     */
    private $contratid;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="StartServiceAt", type="datetime", nullable=true)
     */
    private $startserviceat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="OutServiceAt", type="datetime", nullable=true)
     */
    private $outserviceat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="EndServiceAt", type="datetime", nullable=true)
     */
    private $endserviceat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDolid(): ?int
    {
        return $this->dolid;
    }

    public function setDolid(?int $dolid): static
    {
        $this->dolid = $dolid;

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

    public function getAdresseIp(): ?string
    {
        return $this->adresseip;
    }

    public function setAdresseIp(?string $adresseip): static
    {
        $this->adresseip = $adresseip;

        return $this;
    }
    public function getTrPrincipal(): ?string
    {
        return $this->trprincipal;
    }

    public function setTrPrincipal(?string $trprincipal): static
    {
        $this->trprincipal = $trprincipal;

        return $this;
    }
    public function getTrSecondaire(): ?string
    {
        return $this->trsecondaire;
    }

    public function setTrSecondaire(?string $trsecondaire): static
    {
        $this->trsecondaire = $trsecondaire;

        return $this;
    }

    public function getCodesite(): ?string
    {
        return $this->codesite;
    }

    public function setCodesite(?string $codesite): static
    {
        $this->codesite = $codesite;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;

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

    public function getCustomerid(): ?Customers
    {
        return $this->customerid;
    }

    public function setCustomerid(?Customers $customerid): static
    {
        $this->customerid = $customerid;

        return $this;
    }

    public function getSiteid(): ?Customerssites
    {
        return $this->siteid;
    }

    public function setSiteid(?Customerssites $siteid): static
    {
        $this->siteid = $siteid;

        return $this;
    }

    public function getChargeid(): ?EquipementCharge
    {
        return $this->chargeid;
    }

    public function setChargeid(?EquipementCharge $chargeid): static
    {
        $this->chargeid = $chargeid;

        return $this;
    }

    public function getEntrainementid(): ?EquipementEntrainement
    {
        return $this->entrainementid;
    }

    public function setEntrainementid(?EquipementEntrainement $entrainementid): static
    {
        $this->entrainementid = $entrainementid;

        return $this;
    }

    public function getMarqueid(): ?EquipementMarque
    {
        return $this->marqueid;
    }

    public function setMarqueid(?EquipementMarque $marqueid): static
    {
        $this->marqueid = $marqueid;

        return $this;
    }

    public function getTypeid(): ?EquipementType
    {
        return $this->typeid;
    }

    public function setTypeid(?EquipementType $typeid): static
    {
        $this->typeid = $typeid;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(?int $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getContratid(): ?Contracts
    {
        return $this->contratid;
    }

    public function setContratid(?Contracts $contratid): static
    {
        $this->contratid = $contratid;

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

    public function getStartserviceat(): ?\DateTimeInterface
    {
        return $this->startserviceat;
    }

    public function setStartserviceat(?\DateTimeInterface $startserviceat): static
    {
        $this->startserviceat = $startserviceat;

        return $this;
    }

    public function getOutserviceat(): ?\DateTimeInterface
    {
        return $this->outserviceat;
    }

    public function setOutserviceat(?\DateTimeInterface $outserviceat): static
    {
        $this->outserviceat = $outserviceat;

        return $this;
    }

    public function getEndserviceat(): ?\DateTimeInterface
    {
        return $this->endserviceat;
    }

    public function setEndserviceat(?\DateTimeInterface $endserviceat): static
    {
        $this->endserviceat = $endserviceat;

        return $this;
    }
}
