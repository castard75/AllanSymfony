<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cdr
 *
 * @ORM\Table(name="cdr")
 * @ORM\Entity
 */
class Cdr
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
     * @var int
     *
     * @ORM\Column(name="sip_trunk", type="integer", nullable=false)
     */
    private $sipTrunk;

    /**
     * @var string
     *
     * @ORM\Column(name="caller", type="string", length=255, nullable=false)
     */
    private $caller;

    /**
     * @var string
     *
     * @ORM\Column(name="called", type="string", length=255, nullable=false)
     */
    private $called;

    /**
     * @var datetime_immutable
     *
     * @ORM\Column(name="date_at", type="datetime_immutable", nullable=false)
     */
    private $dateAt;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="devise", type="string", length=255, nullable=false)
     */
    private $devise;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=false)
     */
    private $origin;

    /**
     * @var int
     *
     * @ORM\Column(name="origin_id", type="integer", nullable=false)
     */
    private $originId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="anomaly", type="string", length=255, nullable=true)
     */
    private $anomaly;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

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

    public function getSipTrunk(): ?int
    {
        return $this->sipTrunk;
    }

    public function setSipTrunk(int $sipTrunk): static
    {
        $this->sipTrunk = $sipTrunk;

        return $this;
    }

    public function getCaller(): ?string
    {
        return $this->caller;
    }

    public function setCaller(string $caller): static
    {
        $this->caller = $caller;

        return $this;
    }

    public function getCalled(): ?string
    {
        return $this->called;
    }

    public function setCalled(string $called): static
    {
        $this->called = $called;

        return $this;
    }

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeImmutable $dateAt): static
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): static
    {
        $this->devise = $devise;

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

    public function getOriginId(): ?int
    {
        return $this->originId;
    }

    public function setOriginId(int $originId): static
    {
        $this->originId = $originId;

        return $this;
    }

    public function getAnomaly(): ?string
    {
        return $this->anomaly;
    }

    public function setAnomaly(?string $anomaly): static
    {
        $this->anomaly = $anomaly;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

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


}
