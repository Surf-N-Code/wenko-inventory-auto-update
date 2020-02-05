<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemUpdateStatusRepository")
 */
class ItemUpdateStatus
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
    private $identifier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifierType;

    /**
     * @ORM\Column(type="string")
     */
    private $feedSubmissionId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

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

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getIdentifierType(): ?string
    {
        return $this->identifierType;
    }

    public function setIdentifierType(string $identifierType): self
    {
        $this->identifierType = $identifierType;

        return $this;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
