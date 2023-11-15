<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Table(name="planning")
 * @ORM\Entity
 */
class Planning
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdPlanning", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idplaning;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DuPlanning", type="date", nullable=true)
     */
    private $duplanning;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="AuPlanning", type="date", nullable=true)
     */
    private $auplanning;

    /**
     * @var \Employees
     *
     * @ORM\ManyToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UserId", referencedColumnName="Id")
     * })
     */
    private $userid;
    
     /**
     * @var int|null
     * 
     * @ORM\Column(name="Origin", type="integer", nullable=true)
     */


     private $origineid;


    public function getIdplaning(): ?int
    {
        return $this->idplaning;
    }

    public function getUserid(): ?Employees
    {
        return $this->userid;
    }

    public function setUserid(?Employees $userid): static
    {
        $this->userid = $userid;

        return $this;
    }

    public function getDuplanning(): ?\DateTimeInterface
    {
        return $this->duplanning;
    }

    public function setDuplanning(?\DateTimeInterface $duplanning): static
    {
        $this->duplanning = $duplanning;

        return $this;
    }

    public function getAuplanning(): ?\DateTimeInterface
    {
        return $this->auplanning;
    }

    public function setAuplanning(?\DateTimeInterface $auplanning): static
    {
        $this->auplanning = $auplanning;

        return $this;
    }


    public function getOrigineid(): ?int
    {
        return $this->origineid;
    }

    public function setOrigineid(?int $origineid): static
    {
        $this->origineid = $origineid;

        return $this;
    }
}
