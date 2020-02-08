<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmazonFeedSubmissionRepository")
 */
class AmazonFeedSubmission
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $feedSubmissionId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $submittedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $feedType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $feedProcessingStatus;

    /**
     * @ORM\Column(type="boolean")
     */
    private $success;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFeedSubmissionId(): ?int
    {
        return $this->feedSubmissionId;
    }

    public function setFeedSubmissionId(int $feedSubmissionId): self
    {
        $this->feedSubmissionId = $feedSubmissionId;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTimeInterface
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(\DateTimeInterface $submittedAt): self
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }

    public function getFeedType(): ?string
    {
        return $this->feedType;
    }

    public function setFeedType(string $feedType): self
    {
        $this->feedType = $feedType;

        return $this;
    }

    public function getFeedProcessingStatus(): ?string
    {
        return $this->feedProcessingStatus;
    }

    public function setFeedProcessingStatus(string $feedProcessingStatus): self
    {
        $this->feedProcessingStatus = $feedProcessingStatus;

        return $this;
    }

    public function getSuccess(): ?bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }
}
