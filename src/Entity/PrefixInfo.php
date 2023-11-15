<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrefixInfo
 *
 * @ORM\Table(name="prefix_info", indexes={@ORM\Index(name="nom_prefix_2", columns={"nom_prefix"})})
 * @ORM\Entity
 */
class PrefixInfo
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
     * @ORM\Column(name="nom_prefix", type="string", length=20, nullable=false)
     */
    private $nomPrefix;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", nullable=false, options={"default"="1"})
     */
    private $numero = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrefix(): ?string
    {
        return $this->nomPrefix;
    }

    public function setNomPrefix(string $nomPrefix): static
    {
        $this->nomPrefix = $nomPrefix;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }


}
