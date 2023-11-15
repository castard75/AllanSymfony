<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gabarititems
 *
 * @ORM\Table(name="gabarititems", indexes={@ORM\Index(name="GabaritId", columns={"GabaritId"})})
 * @ORM\Entity
 */
class Gabarititems
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
     * @ORM\Column(name="Label", type="string", length=250, nullable=true)
     */
    private $label;

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
     * @var int|null
     *
     * @ORM\Column(name="ClasseId", type="integer", nullable=true)
     */
    private ?int $classeid;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGabaritId(): ?Gabarit
    {
        return $this->gabaritid;
    }

    public function setGabaritId(?Gabarit $gabaritid): static
    {
        $this->gabaritid = $gabaritid;

        return $this;
    }

    public function getClasseid(): ?int
    {
        return $this->classeid;
    }

    public function setClasseid(?int $classeid): static
    {
        $this->classeid = $classeid;

        return $this;
    }
}
