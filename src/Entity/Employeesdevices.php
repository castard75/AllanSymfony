<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Employeesdevices
 *
 * @ORM\Table(name="Employeesdevices")
 * @ORM\Entity
 */
class Employeesdevices
{
    public function __construct()
    {
        $this->createdat = new \DateTime('now');
        $this->updatedat = new \DateTime('now');
    }
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
     * @ORM\Column(name="deviceid", type="string", length=250, nullable=true)
     */
    private $deviceid;
    /**
     * @var string|null
     *
     * @ORM\Column(name="employeeid", type="string", length=250, nullable=true)
     */
    private $employeeid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="refdevice", type="string", length=250, nullable=true)
     */
    private $refdevice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="labeldevice", type="string", length=250, nullable=true)
     */
    private $labeldevice;
    /**
     * @var string|null
     *
     * @ORM\Column(name="statusdevice", type="string", length=250, nullable=true)
     */
    private $statusdevice;



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


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceid;
    }

    public function setDeviceId(?string $deviceid): static
    {
        $this->deviceid = $deviceid;

        return $this;
    }

    public function getEmployeeId(): ?string
    {
        return $this->employeeid;
    }

    public function setEmployeeId(?string $employeeid): static
    {
        $this->employeeid = $employeeid;

        return $this;
    }
    public function getRefDevice(): ?string
    {
        return $this->refdevice;
    }

    public function setRefDevice(?string $refdevice): static
    {
        $this->refdevice = $refdevice;

        return $this;
    }
    public function getStatusDevice(): ?string
    {
        return $this->statusdevice;
    }

    public function setStatusDevice(?string $statusdevice): static
    {
        $this->statusdevice = $statusdevice;

        return $this;
    }


    public function getLabelDevice(): ?string
    {
        return $this->labeldevice;
    }

    public function setLabelDevice(?string $labeldevice): static
    {
        $this->labeldevice = $labeldevice;

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
}
