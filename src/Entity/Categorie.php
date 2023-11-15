<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
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
     * @var int
     *
     * @ORM\Column(name="ParentId", type="integer", nullable=false)
     */
    private $parentid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Label", type="string", length=180, nullable=true)
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="Type", type="boolean", nullable=false, options={"default"="1"})
     */
    private $type = true;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="UpdateAt", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updateat = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DeletedAt", type="date", nullable=true)
     */
    private $deletedat;

    /**
     * @var string
     *
     * @ORM\Column(name="Transfert", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $transfert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentid(): ?int
    {
        return $this->parentid;
    }

    public function setParentid(int $parentid): static
    {
        $this->parentid = $parentid;

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

    public function isType(): ?bool
    {
        return $this->type;
    }

    public function setType(bool $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUpdateat(): ?\DateTimeInterface
    {
        return $this->updateat;
    }

    public function setUpdateat(?\DateTimeInterface $updateat): static
    {
        $this->updateat = $updateat;

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
