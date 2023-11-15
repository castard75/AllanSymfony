<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndicatifSda
 *
 * @ORM\Table(name="indicatif_sda")
 * @ORM\Entity
 */
class IndicatifSda
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
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="code_iso", type="string", length=10, nullable=false)
     */
    private $codeIso;

    /**
     * @var string
     *
     * @ORM\Column(name="zone", type="string", length=50, nullable=false)
     */
    private $zone;

    /**
     * @var string
     *
     * @ORM\Column(name="indicatif", type="string", length=50, nullable=false)
     */
    private $indicatif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="format_num", type="string", length=50, nullable=true)
     */
    private $formatNum;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prefixe", type="string", length=255, nullable=true)
     */
    private $prefixe;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCodeIso(): ?string
    {
        return $this->codeIso;
    }

    public function setCodeIso(string $codeIso): static
    {
        $this->codeIso = $codeIso;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): static
    {
        $this->zone = $zone;

        return $this;
    }

    public function getIndicatif(): ?string
    {
        return $this->indicatif;
    }

    public function setIndicatif(string $indicatif): static
    {
        $this->indicatif = $indicatif;

        return $this;
    }

    public function getFormatNum(): ?string
    {
        return $this->formatNum;
    }

    public function setFormatNum(?string $formatNum): static
    {
        $this->formatNum = $formatNum;

        return $this;
    }

    public function getPrefixe(): ?string
    {
        return $this->prefixe;
    }

    public function setPrefixe(?string $prefixe): static
    {
        $this->prefixe = $prefixe;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


}
