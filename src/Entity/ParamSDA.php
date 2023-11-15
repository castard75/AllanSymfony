<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParamSda
 *
 * @ORM\Table(name="param_sda")
 * @ORM\Entity
 */
class ParamSda
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code_iso", type="string", length=20, nullable=false)
     */
    private $codeIso;

    /**
     * @var string
     *
     * @ORM\Column(name="callsign", type="string", length=20, nullable=false)
     */
    private $callsign;

    /**
     * @var string
     *
     * @ORM\Column(name="prefix", type="string", length=20, nullable=false)
     */
    private $prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="geolocalisation", type="string", length=20, nullable=false)
     */
    private $geolocalisation;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getCallsign(): ?string
    {
        return $this->callsign;
    }

    public function setCallsign(string $callsign): static
    {
        $this->callsign = $callsign;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getGeolocalisation(): ?string
    {
        return $this->geolocalisation;
    }

    public function setGeolocalisation(string $geolocalisation): static
    {
        $this->geolocalisation = $geolocalisation;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


}
