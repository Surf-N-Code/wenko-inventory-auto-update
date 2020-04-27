<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToMany(targetEntity="App\Entity\AmazonItemActions", mappedBy="feedSubmissionId", cascade={"persist"})
     */
    private $amazonItemActions;

    public function __construct()
    {
        $this->amazonItemActions = new ArrayCollection();
    }

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

    /**
     * @return Collection|AmazonItemActions[]
     */
    public function getAmazonItemActions(): Collection
    {
        return $this->amazonItemActions;
    }

    public function addAmazonItemAction(AmazonItemActions $amazonItemAction): self
    {
        if (!$this->amazonItemActions->contains($amazonItemAction)) {
            $this->amazonItemActions[] = $amazonItemAction;
            dump($this->amazonItemActions);
//            $amazonItemAction->addFeedSubmissionId($this);
        }

        return $this;
    }

    public function removeAmazonItemAction(AmazonItemActions $amazonItemAction): self
    {
        if ($this->amazonItemActions->contains($amazonItemAction)) {
            $this->amazonItemActions->removeElement($amazonItemAction);
//            $amazonItemAction->removeFeedSubmissionId($this);
        }

        return $this;
    }
}
