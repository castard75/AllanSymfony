<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * CronReport
 *
 * @ORM\Table(name="cron_report", indexes={@ORM\Index(name="IDX_B6C6A7F5BE04EA9", columns={"job_id"})})
 * @ORM\Entity
 */
class CronReport
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
     * @var \DateTime
     *
     * @ORM\Column(name="run_at", type="datetime", nullable=false)
     */
    private $runAt;

    /**
     * @var float
     *
     * @ORM\Column(name="run_time", type="float", precision=10, scale=0, nullable=false)
     */
    private $runTime;

    /**
     * @var int
     *
     * @ORM\Column(name="exit_code", type="integer", nullable=false)
     */
    private $exitCode;

    /**
     * @var string
     *
     * @ORM\Column(name="output", type="text", length=0, nullable=false)
     */
    private $output;

    /**
     * @var string
     *
     * @ORM\Column(name="error", type="text", length=0, nullable=false)
     */
    private $error;

    /**
     * @var \CronJob
     *
     * @ORM\ManyToOne(targetEntity="CronJob")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     */
    private $job;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRunAt(): ?\DateTimeInterface
    {
        return $this->runAt;
    }

    public function setRunAt(\DateTimeInterface $runAt): static
    {
        $this->runAt = $runAt;

        return $this;
    }

    public function getRunTime(): ?float
    {
        return $this->runTime;
    }

    public function setRunTime(float $runTime): static
    {
        $this->runTime = $runTime;

        return $this;
    }

    public function getExitCode(): ?int
    {
        return $this->exitCode;
    }

    public function setExitCode(int $exitCode): static
    {
        $this->exitCode = $exitCode;

        return $this;
    }

    public function getOutput(): ?string
    {
        return $this->output;
    }

    public function setOutput(string $output): static
    {
        $this->output = $output;

        return $this;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(string $error): static
    {
        $this->error = $error;

        return $this;
    }

    public function getJob(): ?CronJob
    {
        return $this->job;
    }

    public function setJob(?CronJob $job): static
    {
        $this->job = $job;

        return $this;
    }


}
