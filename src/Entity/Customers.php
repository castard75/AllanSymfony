<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customers
 *
 * @ORM\Table(name="customers", indexes={@ORM\Index(name="OrigineId", columns={"OrigineId"})})
 * @ORM\Entity
 */
class Customers
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * 
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
     * @var int|null
     *
     * @ORM\Column(name="Civility", type="integer", nullable=true)
     */
    private $civility;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Name", type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Firstname", type="string", length=150, nullable=true)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Reference", type="string", length=50, nullable=true)
     */
    private $reference;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ReferenceSupplier", type="string", length=50, nullable=true)
     */
    private $referencesupplier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Siren", type="string", length=20, nullable=true)
     */
    private $siren;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Siret", type="string", length=20, nullable=true)
     */
    private $siret;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="AdditionalAddress", type="string", length=255, nullable=true)
     */
    private $additionaladdress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FixPhone", type="string", length=45, nullable=true)
     */
    private $fixphone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="MobilePhone", type="string", length=45, nullable=true)
     */
    private $mobilephone;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CityId", type="integer", nullable=true)
     */
    private $cityid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PostCode", type="string", length=50, nullable=true)
     */
    private $postcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NameCity", type="string", length=250, nullable=true)
     */
    private $namecity;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CountryId", type="integer", nullable=true, options={"default"="181"})
     */
    private $countryid = 181;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CustomerTypeId", type="integer", nullable=true)
     */
    private $customertypeid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CompanyId", type="integer", nullable=true)
     */
    private $companyid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ConditionReglement", type="integer", nullable=true)
     */
    private $conditionreglement;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ModeReglement", type="integer", nullable=true)
     */
    private $modereglement;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Status", type="integer", nullable=true, options={"default"="1"})
     */
    private $status = 1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="State", type="integer", nullable=true, options={"default"="1"})
     */
    private $state = 1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CodeCompta", type="string", length=100, nullable=true)
     */
    private $codecompta;

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
     * @ORM\Column(name="CustomerState", type="integer", nullable=true)
     */
    private $customerstate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="SupplierState", type="integer", nullable=true)
     */
    private $supplierstate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Classe", type="integer", nullable=true)
     */
    private $classe;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateCustomer", type="datetime", nullable=true)
     */
    private $datecustomer;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateUpdateCustomer", type="datetime", nullable=true)
     */
    private $dateupdatecustomer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="transfert", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $transfert;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PriceLevel", type="integer", nullable=true)
     */
    private $pricelevel;

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

    public function getDolid(): ?int
    {
        return $this->dolid;
    }

    public function setDolid(?int $dolid): static
    {
        $this->dolid = $dolid;

        return $this;
    }

    public function getCivility(): ?int
    {
        return $this->civility;
    }

    public function setCivility(?int $civility): static
    {
        $this->civility = $civility;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

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

    public function getReferencesupplier(): ?string
    {
        return $this->referencesupplier;
    }

    public function setReferencesupplier(?string $referencesupplier): static
    {
        $this->referencesupplier = $referencesupplier;

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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

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

    public function getAdditionaladdress(): ?string
    {
        return $this->additionaladdress;
    }

    public function setAdditionaladdress(?string $additionaladdress): static
    {
        $this->additionaladdress = $additionaladdress;

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

    public function getCityid(): ?int
    {
        return $this->cityid;
    }

    public function setCityid(?int $cityid): static
    {
        $this->cityid = $cityid;

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

    public function getCountryid(): ?int
    {
        return $this->countryid;
    }

    public function setCountryid(?int $countryid): static
    {
        $this->countryid = $countryid;

        return $this;
    }

    public function getCustomertypeid(): ?int
    {
        return $this->customertypeid;
    }

    public function setCustomertypeid(?int $customertypeid): static
    {
        $this->customertypeid = $customertypeid;

        return $this;
    }

    public function getCompanyid(): ?int
    {
        return $this->companyid;
    }

    public function setCompanyid(?int $companyid): static
    {
        $this->companyid = $companyid;

        return $this;
    }

    public function getConditionreglement(): ?int
    {
        return $this->conditionreglement;
    }

    public function setConditionreglement(?int $conditionreglement): static
    {
        $this->conditionreglement = $conditionreglement;

        return $this;
    }

    public function getModereglement(): ?int
    {
        return $this->modereglement;
    }

    public function setModereglement(?int $modereglement): static
    {
        $this->modereglement = $modereglement;

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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCodecompta(): ?string
    {
        return $this->codecompta;
    }

    public function setCodecompta(?string $codecompta): static
    {
        $this->codecompta = $codecompta;

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

    public function getCustomerstate(): ?int
    {
        return $this->customerstate;
    }

    public function setCustomerstate(?int $customerstate): static
    {
        $this->customerstate = $customerstate;

        return $this;
    }

    public function getSupplierstate(): ?int
    {
        return $this->supplierstate;
    }

    public function setSupplierstate(?int $supplierstate): static
    {
        $this->supplierstate = $supplierstate;

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

    public function getDatecustomer(): ?\DateTimeInterface
    {
        return $this->datecustomer;
    }

    public function setDatecustomer(?\DateTimeInterface $datecustomer): static
    {
        $this->datecustomer = $datecustomer;

        return $this;
    }

    public function getDateupdatecustomer(): ?\DateTimeInterface
    {
        return $this->dateupdatecustomer;
    }

    public function setDateupdatecustomer(?\DateTimeInterface $dateupdatecustomer): static
    {
        $this->dateupdatecustomer = $dateupdatecustomer;

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

    public function getPricelevel(): ?int
    {
        return $this->pricelevel;
    }

    public function setPricelevel(?int $pricelevel): static
    {
        $this->pricelevel = $pricelevel;

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
