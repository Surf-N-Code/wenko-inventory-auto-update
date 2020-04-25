<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmazonListingRepository")
 * @ORM\Table(name="listings_amazon")
 */
class AmazonListing
{
    use TimestampableTrait;

    /**
     * @var string $sku
     *
     * @ORM\Id()
     * @ORM\Column(name="sku", type="string")
     */
    private $sku;

    /**
     * @var string $ean
     *
     * @ORM\Id()
     * @ORM\Column(name="ean", type="string")
     */
    private $ean;

    /**
     * @var string $asin
     *
     * @ORM\Column(name="asin", type="string")
     */
    private $asin;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int $stock
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

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

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $listingId;

    /**
     * @ORM\Column(type="string")
     */
    private $itemCondition;

    /**
     * @return string
     */
    public function getAsin(): string
    {
        return $this->asin;
    }

    /**
     * @param string $asin
     */
    public function setAsin(string $asin): void
    {
        $this->asin = $asin;
    }

    public function getListingId(): ?string
    {
        return $this->listingId;
    }

    public function setListingId(string $listingId): self
    {
        $this->listingId = $listingId;

        return $this;
    }

    public function getItemCondition(): ?int
    {
        return $this->itemCondition;
    }

    public function setItemCondition(string $itemCondition): self
    {
        $itemConditionMapping = [
            1 => 'UsedLikeNew',
            2 => 'UsedVeryGood',
            3 => 'UsedGood',
            4 => 'UsedAcceptable',
            5 => 'CollectibleLikeNew',
            6 => 'CollectibleVeryGood',
            7 => 'CollectibleGood',
            8 => 'CollectibleAcceptable',
            9 => 'Used - Refurbished - camera',
            10 => 'Used - Refurbished - computer',
            11 => 'New'
        ];

        if (array_key_exists($itemCondition, $itemConditionMapping)) {
            $this->itemCondition = $itemConditionMapping[$itemCondition];
        } else {
            $this->itemCondition = $itemCondition;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEan(): string
    {
        return $this->ean;
    }

    /**
     * @param string $ean
     */
    public function setEan(string $ean): void
    {
        $this->ean = $ean;
    }
}
