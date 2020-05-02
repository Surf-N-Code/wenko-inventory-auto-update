<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\BaseItemPropertiesTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmazonItemActionsRepository")
 * @ORM\Table(name="amazon_item_actions")
 */
class AmazonItemActions
{

    public function __construct($amazonAction, $sku, $ean, $stock, $price)
    {
        $this->amazonAction = $amazonAction;
        $this->sku = $sku;
        $this->ean = $ean;
        $this->stock = $stock;
        $this->price = $price;
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $sku
     *
     * @ORM\Column(name="sku", type="string")
     */
    private $sku;

    use TimestampableTrait;

    use BaseItemPropertiesTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $amazonAction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AmazonFeedSubmission", inversedBy="amazonItemActions")
     */
    private $amazonFeedSubmission;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAmazonAction()
    {
        return $this->amazonAction;
    }

    /**
     * @param mixed $amazonAction
     */
    public function setAmazonAction($amazonAction): void
    {
        $this->amazonAction = $amazonAction;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function getAmazonFeedSubmission(): ?AmazonFeedSubmission
    {
        return $this->amazonFeedSubmission;
    }

    public function setAmazonFeedSubmission(?AmazonFeedSubmission $amazonFeedSubmission): self
    {
        $this->amazonFeedSubmission = $amazonFeedSubmission;

        return $this;
    }
}
