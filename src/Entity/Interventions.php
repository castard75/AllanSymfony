<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Interventions
 *
 * @ORM\Table(name="interventions", indexes={@ORM\Index(name="AppareilId", columns={"AppareilId"}), @ORM\Index(name="CustomerIdIntervention", columns={"CustomerId"}), @ORM\Index(name="UserId", columns={"UserId"}), @ORM\Index(name="EmployeeId", columns={"EmployeeId"}), @ORM\Index(name="GabaritId", columns={"GabaritId"}), @ORM\Index(name="OrigineId", columns={"OrigineId"})})
 * @ORM\Entity
 */
class Interventions
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
     * @ORM\Column(name="LatitudeDebut", type="string", length=50, nullable=true)
     */
    private $latitudedebut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LongitudeDebut", type="string", length=50, nullable=true)
     */
    private $longitudedebut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LongitudeValider", type="string", length=50, nullable=true)
     */
    private $longitudevalider;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LatitudeValider", type="string", length=50, nullable=true)
     */
    private $latitudevalider;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SignatureValider", type="text", nullable=true)
     */
    private $signaturevalider;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SignataireValider", type="string", nullable=true)
     */
    private $signatairevalider;

    /**
     * @var int|null
     *
     * @ORM\Column(name="RefExtId", type="integer", nullable=true)
     */
    private $refextid;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateDebut", type="datetime", nullable=true)
     */
    private $datedebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=true)
     */
    private $datefin;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="HeureAppelRecu", type="time", nullable=true)
     */
    private $heureappelrecu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="HeureAppelTechnicien", type="time", nullable=true)
     */
    private $heureappeltechnicien;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Duree", type="string", nullable=true)
     */
    private $duree;

    /**
     * @var int|null
     * 
     * @ORM\Column(name="Origin", type="integer", nullable=true)
     */
    private $origin;
    
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
     * @var \Gabarit
     *
     * @ORM\ManyToOne(targetEntity="Gabarit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="GabaritId", referencedColumnName="Id")
     * })
     */
    private $gabaritid;

    /**
     * @var \Equipments
     *
     * @ORM\ManyToOne(targetEntity="Equipments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="AppareilId", referencedColumnName="Id")
     * })
     */
    private $appareilid;

    /**
     * @var \Employees
     *
     * @ORM\ManyToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UserId", referencedColumnName="Id")
     * })
     */
    private $userid;

    /**
     * @var \Employees
     *
     * @ORM\ManyToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EmployeeId", referencedColumnName="Id")
     * })
     */
    private $employeeid;

    /**
     * @var \Myconnectors
     * 
     * @ORM\ManyToOne(targetEntity="Myconnectors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OrigineId", referencedColumnName="Id")
     * })
     */
    private $origineid;

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

    public function getLongitudedebut(): ?string
    {
        return $this->longitudedebut;
    }

    public function setLongitudedebut(?string $longitudedebut): static
    {
        $this->longitudedebut = $longitudedebut;

        return $this;
    }

    public function getLatitudedebut(): ?string
    {
        return $this->latitudedebut;
    }

    public function setLatitudedebut(?string $latitudedebut): static
    {
        $this->latitudedebut = $latitudedebut;

        return $this;
    }
    //

    public function getLongitudevalider(): ?string
    {
        return $this->longitudevalider;
    }

    public function setLongitudevalider(?string $longitudevalider): static
    {
        $this->longitudevalider = $longitudevalider;

        return $this;
    }

    public function getLatitudevalider(): ?string
    {
        return $this->latitudevalider;
    }

    public function setLatitudevalider(?string $latitudevalider): static
    {
        $this->latitudevalider = $latitudevalider;

        return $this;
    }

    public function getSignaturevalider(): ?string
    {
        return $this->signaturevalider;
    }

    public function setSignaturevalider(?string $signaturevalider): static
    {
        $this->signaturevalider = $signaturevalider;

        return $this;
    }

    public function getSignatairevalider(): ?string
    {
        return $this->signatairevalider;
    }

    public function setSignatairevalider(?string $signatairevalider): static
    {
        $this->signatairevalider = $signatairevalider;

        return $this;
    }

    public function getRefextid(): ?int
    {
        return $this->refextid;
    }

    public function setRefextid(?int $refextid): static
    {
        $this->refextid = $refextid;

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

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(?\DateTimeInterface $datedebut): static
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): static
    {
        $this->datefin = $datefin;

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

    public function getHeureappelrecu(): ?\DateTimeInterface
    {
        return $this->heureappelrecu;
    }

    public function setHeureappelrecu(?\DateTimeInterface $heureappelrecu): static
    {
        $this->heureappelrecu = $heureappelrecu;

        return $this;
    }

    public function getHeureappeltechnicien(): ?\DateTimeInterface
    {
        return $this->heureappeltechnicien;
    }

    public function setHeureappeltechnicien(?\DateTimeInterface $heureappeltechnicien): static
    {
        $this->heureappeltechnicien = $heureappeltechnicien;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getOrigin(): ?int
    {
        return $this->origin;
    }

    public function setOrigin(?int $origin): static
    {
        $this->origin = $origin;

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

    public function getGabaritid(): ?Gabarit
    {
        return $this->gabaritid;
    }

    public function setGabaritid(?Gabarit $gabaritid): static
    {
        $this->gabaritid = $gabaritid;

        return $this;
    }

    public function getAppareilid(): ?Equipments
    {
        return $this->appareilid;
    }

    public function setAppareilid(?Equipments $appareilid): static
    {
        $this->appareilid = $appareilid;

        return $this;
    }

    public function getUserid(): ?Employees
    {
        return $this->userid;
    }

    public function setUserid(?Employees $userid): static
    {
        $this->userid = $userid;

        return $this;
    }

    public function getEmployeeid(): ?Employees
    {
        return $this->employeeid;
    }

    public function setEmployeeid(?Employees $employeeid): static
    {
        $this->employeeid = $employeeid;

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
}
