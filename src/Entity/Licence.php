<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Licence
 *
 * @ORM\Table(name="licence")
 * @ORM\Entity
 */
class Licence
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
     * @var int|null
     *
     * @ORM\Column(name="poste", type="integer", nullable=true)
     */
    private $poste;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="expired_at", type="datetime_immutable", nullable=false)
     */
    private $expiredAt;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime_immutable|null
     *
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @var datetime_immutable|null
     *
     * @ORM\Column(name="deleted_at", type="datetime_immutable", nullable=true)
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
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     */
    private $reference;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Domain", inversedBy="licence")
     * @ORM\JoinTable(name="licence_domain",
     *   joinColumns={
     *     @ORM\JoinColumn(name="licence_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
     *   }
     * )
     */
    private $domain = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ip", inversedBy="licence")
     * @ORM\JoinTable(name="licence_ip",
     *   joinColumns={
     *     @ORM\JoinColumn(name="licence_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ip_id", referencedColumnName="id")
     *   }
     * )
     */
    private $ip = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ipbx", inversedBy="licence")
     * @ORM\JoinTable(name="licence_ipbx",
     *   joinColumns={
     *     @ORM\JoinColumn(name="licence_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ipbx_id", referencedColumnName="id")
     *   }
     * )
     */
    private $ipbx = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Mail", inversedBy="licence")
     * @ORM\JoinTable(name="licence_mail",
     *   joinColumns={
     *     @ORM\JoinColumn(name="licence_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="mail_id", referencedColumnName="id")
     *   }
     * )
     */
    private $mail = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Maintenance", inversedBy="licence")
     * @ORM\JoinTable(name="licence_maintenance",
     *   joinColumns={
     *     @ORM\JoinColumn(name="licence_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="maintenance_id", referencedColumnName="id")
     *   }
     * )
     */
    private $maintenance = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Sda", inversedBy="licence")
     * @ORM\JoinTable(name="licence_sda",
     *   joinColumns={
     *     @ORM\JoinColumn(name="licence_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="sda_id", referencedColumnName="id")
     *   }
     * )
     */
    private $sda = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Trunk", inversedBy="licence")
     * @ORM\JoinTable(name="licence_trunk",
     *   joinColumns={
     *     @ORM\JoinColumn(name="licence_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="trunk_id", referencedColumnName="id")
     *   }
     * )
     */
    private $trunk = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->domain = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ip = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ipbx = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mail = new \Doctrine\Common\Collections\ArrayCollection();
        $this->maintenance = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sda = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trunk = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getPoste(): ?int
    {
        return $this->poste;
    }

    public function setPoste(?int $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(\DateTimeImmutable $expiredAt): static
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

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

    /**
     * @return Collection<int, Domain>
     */
    public function getDomain(): Collection
    {
        return $this->domain;
    }

    public function addDomain(Domain $domain): static
    {
        if (!$this->domain->contains($domain)) {
            $this->domain->add($domain);
        }

        return $this;
    }

    public function removeDomain(Domain $domain): static
    {
        $this->domain->removeElement($domain);

        return $this;
    }

    /**
     * @return Collection<int, Ip>
     */
    public function getIp(): Collection
    {
        return $this->ip;
    }

    public function addIp(Ip $ip): static
    {
        if (!$this->ip->contains($ip)) {
            $this->ip->add($ip);
        }

        return $this;
    }

    public function removeIp(Ip $ip): static
    {
        $this->ip->removeElement($ip);

        return $this;
    }

    /**
     * @return Collection<int, Ipbx>
     */
    public function getIpbx(): Collection
    {
        return $this->ipbx;
    }

    public function addIpbx(Ipbx $ipbx): static
    {
        if (!$this->ipbx->contains($ipbx)) {
            $this->ipbx->add($ipbx);
        }

        return $this;
    }

    public function removeIpbx(Ipbx $ipbx): static
    {
        $this->ipbx->removeElement($ipbx);

        return $this;
    }

    /**
     * @return Collection<int, Mail>
     */
    public function getMail(): Collection
    {
        return $this->mail;
    }

    public function addMail(Mail $mail): static
    {
        if (!$this->mail->contains($mail)) {
            $this->mail->add($mail);
        }

        return $this;
    }

    public function removeMail(Mail $mail): static
    {
        $this->mail->removeElement($mail);

        return $this;
    }

    /**
     * @return Collection<int, Maintenance>
     */
    public function getMaintenance(): Collection
    {
        return $this->maintenance;
    }

    public function addMaintenance(Maintenance $maintenance): static
    {
        if (!$this->maintenance->contains($maintenance)) {
            $this->maintenance->add($maintenance);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): static
    {
        $this->maintenance->removeElement($maintenance);

        return $this;
    }

    /**
     * @return Collection<int, Sda>
     */
    public function getSda(): Collection
    {
        return $this->sda;
    }

    public function addSda(Sda $sda): static
    {
        if (!$this->sda->contains($sda)) {
            $this->sda->add($sda);
        }

        return $this;
    }

    public function removeSda(Sda $sda): static
    {
        $this->sda->removeElement($sda);

        return $this;
    }

    /**
     * @return Collection<int, Trunk>
     */
    public function getTrunk(): Collection
    {
        return $this->trunk;
    }

    public function addTrunk(Trunk $trunk): static
    {
        if (!$this->trunk->contains($trunk)) {
            $this->trunk->add($trunk);
        }

        return $this;
    }

    public function removeTrunk(Trunk $trunk): static
    {
        $this->trunk->removeElement($trunk);

        return $this;
    }

}
