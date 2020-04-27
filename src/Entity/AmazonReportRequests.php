<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmazonReportRequestsRepository")
 */
class AmazonReportRequests
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reportName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reportStatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $requestedAt;

    /**
     * @ORM\Column(type="string")
     */
    private $reportId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportName(): ?string
    {
        return $this->reportName;
    }

    public function setReportName(string $reportName): self
    {
        $this->reportName = $reportName;

        return $this;
    }

    public function getReportStatus(): ?string
    {
        return $this->reportStatus;
    }

    public function setReportStatus(string $reportStatus): self
    {
        $this->reportStatus = $reportStatus;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeInterface
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeInterface $requestedAt): self
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getReportId(): ?int
    {
        return $this->reportId;
    }

    public function setReportId(string $reportId): self
    {
        $this->reportId = $reportId;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }
}
