<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Companies
 *
 * @ORM\Table(name="companies", indexes={@ORM\Index(name="MyConnectorId", columns={"MyConnectorId"})})
 * @ORM\Entity
 */
class Companies
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
     * @ORM\Column(name="Name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FixPhone", type="string", length=255, nullable=true)
     */
    private $fixphone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="MobilePhone", type="string", length=255, nullable=true)
     */
    private $mobilephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TvaNumber", type="string", length=255, nullable=true)
     */
    private $tvanumber;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Tva", type="boolean", nullable=true)
     */
    private $tva;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Siret", type="string", length=255, nullable=true)
     */
    private $siret;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Siren", type="string", length=255, nullable=true)
     */
    private $siren;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nafape", type="string", length=255, nullable=true)
     */
    private $nafape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Rcsrm", type="string", length=255, nullable=true)
     */
    private $rcsrm;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Capital", type="float", precision=10, scale=0, nullable=true)
     */
    private $capital;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Licence", type="string", length=511, nullable=true)
     */
    private $licence;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CompaniyType", type="integer", nullable=true)
     */
    private $companiytype;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Logo", type="text", length=0, nullable=true)
     */
    private $logo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Postcode", type="string", length=15, nullable=true)
     */
    private $postcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NameCity", type="string", length=150, nullable=true)
     */
    private $namecity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="LogoMini", type="text", length=0, nullable=true)
     */
    private $logomini;

    /**
     * @var \Myconnectors
     * 
     * @ORM\ManyToOne(targetEntity="Myconnectors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MyConnectorId", referencedColumnName="Id")
     * })
     */
    private $myconnectorid;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFixphone(): ?string
    {
        return $this->fixphone;
    }

    public function setFixphone(?string $fixphone): static
    {
        $this->fixphone = $fixphone;

        return $this;
    }

    public function getMobilephone(): ?string
    {
        return $this->mobilephone;
    }

    public function setMobilephone(?string $mobilephone): static
    {
        $this->mobilephone = $mobilephone;

        return $this;
    }

    public function getTvanumber(): ?string
    {
        return $this->tvanumber;
    }

    public function setTvanumber(?string $tvanumber): static
    {
        $this->tvanumber = $tvanumber;

        return $this;
    }

    public function isTva(): ?bool
    {
        return $this->tva;
    }

    public function setTva(?bool $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): static
    {
        $this->siren = $siren;

        return $this;
    }

    public function getNafape(): ?string
    {
        return $this->nafape;
    }

    public function setNafape(?string $nafape): static
    {
        $this->nafape = $nafape;

        return $this;
    }

    public function getRcsrm(): ?string
    {
        return $this->rcsrm;
    }

    public function setRcsrm(?string $rcsrm): static
    {
        $this->rcsrm = $rcsrm;

        return $this;
    }

    public function getCapital(): ?float
    {
        return $this->capital;
    }

    public function setCapital(?float $capital): static
    {
        $this->capital = $capital;

        return $this;
    }

    public function getLicence(): ?string
    {
        return $this->licence;
    }

    public function setLicence(?string $licence): static
    {
        $this->licence = $licence;

        return $this;
    }

    public function getCompaniytype(): ?int
    {
        return $this->companiytype;
    }

    public function setCompaniytype(?int $companiytype): static
    {
        $this->companiytype = $companiytype;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): static
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getNamecity(): ?string
    {
        return $this->namecity;
    }

    public function setNamecity(?string $namecity): static
    {
        $this->namecity = $namecity;

        return $this;
    }

    public function getLogomini(): ?string
    {
        return $this->logomini;
    }

    public function setLogomini(?string $logomini): static
    {
        $this->logomini = $logomini;

        return $this;
    }

    public function getMyconnectorid(): ?Myconnectors
    {
        return $this->myconnectorid;
    }

    public function setMyconnectorid(?Myconnectors $myconnectorid): static
    {
        $this->myconnectorid = $myconnectorid;

        return $this;
    }


}
