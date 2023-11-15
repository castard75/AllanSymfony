<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Extrafieldsvalues
 *
 * @ORM\Table(name="extrafieldsvalues", indexes={@ORM\Index(name="ExtraIdExtrafieldValue", columns={"ExtraId"})})
 * @ORM\Entity
 */
class Extrafieldsvalues
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
     * @ORM\Column(name="Valeur", type="string", length=50, nullable=true)
     */
    private $valeur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Texte", type="string", length=150, nullable=true)
     */
    private $texte;

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
     * @var \Extrafields
     *
     * @ORM\ManyToOne(targetEntity="Extrafields")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ExtraId", referencedColumnName="Id")
     * })
     */
    private $extraid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(?string $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(?string $texte): static
    {
        $this->texte = $texte;

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

    public function getExtraid(): ?Extrafields
    {
        return $this->extraid;
    }

    public function setExtraid(?Extrafields $extraid): static
    {
        $this->extraid = $extraid;

        return $this;
    }


}
