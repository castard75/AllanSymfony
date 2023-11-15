<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Countries
 *
 * @ORM\Table(name="countries", indexes={@ORM\Index(name="id", columns={"Id"})})
 * @ORM\Entity
 */
class Countries
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
     * @var string
     *
     * @ORM\Column(name="NameFr", type="string", length=50, nullable=false)
     */
    private $namefr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NameUs", type="string", length=50, nullable=true)
     */
    private $nameus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code1", type="string", length=3, nullable=true, options={"fixed"=true})
     */
    private $code1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code2", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $code2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="UpdatedAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedat = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DeletedAt", type="datetime", nullable=true)
     */
    private $deletedat;

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

    public function getNamefr(): ?string
    {
        return $this->namefr;
    }

    public function setNamefr(string $namefr): static
    {
        $this->namefr = $namefr;

        return $this;
    }

    public function getNameus(): ?string
    {
        return $this->nameus;
    }

    public function setNameus(?string $nameus): static
    {
        $this->nameus = $nameus;

        return $this;
    }

    public function getCode1(): ?string
    {
        return $this->code1;
    }

    public function setCode1(?string $code1): static
    {
        $this->code1 = $code1;

        return $this;
    }

    public function getCode2(): ?string
    {
        return $this->code2;
    }

    public function setCode2(?string $code2): static
    {
        $this->code2 = $code2;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTimeInterface $updatedat): static
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

    public function setTransfert(string $transfert): static
    {
        $this->transfert = $transfert;

        return $this;
    }


}
