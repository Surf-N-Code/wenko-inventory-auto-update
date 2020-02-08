<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\BaseItemPropertiesTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemsOtherRepository")
 * @ORM\Table(name="items_other")
 */
class ItemsOther
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $articleId;

    use BaseItemPropertiesTrait;

    /**
     * @ORM\Column(type="boolean")
     */
    private $batteryEnthalten;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $articleCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shopCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $deliveryTime;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionHtml;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marke;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_8;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_9;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_10;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $length;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $metaKeyword;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shippingCost;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shopUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $weight;

    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private $salePrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Brand;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    /**
     * @return mixed
     */
    public function getArticleCategory()
    {
        return $this->articleCategory;
    }

    /**
     * @param mixed $articleCategory
     */
    public function setArticleCategory($articleCategory): void
    {
        $this->articleCategory = $articleCategory;
    }

    /**
     * @return mixed
     */
    public function getShopCategory()
    {
        return $this->shopCategory;
    }

    /**
     * @param mixed $shopCategory
     */
    public function setShopCategory($shopCategory): void
    {
        $this->shopCategory = $shopCategory;
    }

    public function getDeliveryTime(): ?string
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime(string $deliveryTime): self
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescriptionHtml(): ?string
    {
        return $this->descriptionHtml;
    }

    public function setDescriptionHtml(string $descriptionHtml): self
    {
        $this->descriptionHtml = $descriptionHtml;

        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(string $ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    public function getMarke(): ?string
    {
        return $this->marke;
    }

    public function setMarke(string $marke): self
    {
        $this->marke = $marke;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(?string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function setArticleId(int $articleId): self
    {
        $this->articleId = $articleId;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image_1;
    }

    public function setImage1(string $image_1): self
    {
        $this->image_1 = $image_1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image_2;
    }

    public function setImage2(?string $image_2): self
    {
        $this->image_2 = $image_2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image_3;
    }

    public function setImage3(?string $image_3): self
    {
        $this->image_3 = $image_3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image_4;
    }

    public function setImage4(?string $image_4): self
    {
        $this->image_4 = $image_4;

        return $this;
    }

    public function getImage5(): ?string
    {
        return $this->image_5;
    }

    public function setImage5(?string $image_5): self
    {
        $this->image_5 = $image_5;

        return $this;
    }

    public function getImage6(): ?string
    {
        return $this->image_6;
    }

    public function setImage6(?string $image_6): self
    {
        $this->image_6 = $image_6;

        return $this;
    }

    public function getImage7(): ?string
    {
        return $this->image_7;
    }

    public function setImage7(?string $image_7): self
    {
        $this->image_7 = $image_7;

        return $this;
    }

    public function getImage8(): ?string
    {
        return $this->image_8;
    }

    public function setImage8(?string $image_8): self
    {
        $this->image_8 = $image_8;

        return $this;
    }

    public function getImage9(): ?string
    {
        return $this->image_9;
    }

    public function setImage9(?string $image_9): self
    {
        $this->image_9 = $image_9;

        return $this;
    }

    public function getImage10(): ?string
    {
        return $this->image_10;
    }

    public function setImage10(?string $image_10): self
    {
        $this->image_10 = $image_10;

        return $this;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(?string $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function setMetaKeyword(?string $metaKeyword): self
    {
        $this->metaKeyword = $metaKeyword;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->uvp;
    }

    public function setPrice(float $uvp): self
    {
        $this->uvp = $uvp;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $onStock): self
    {
        $this->stock = $onStock;

        return $this;
    }

    public function setShippingCost(?string $shippingCost): self
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function setShopUrl(string $shopUrl): self
    {
        $this->shopUrl = $shopUrl;

        return $this;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @param mixed $cost
     */
    public function calculateCost($ekDiscount, $vkDiscount): self
    {
        $uvp = $this->uvp;
        $ek =  $uvp * (1 - $ekDiscount);
        $vk = $uvp * (1 - $vkDiscount);
        $adCosts = 0;
        $this->cost = round($ek + ($vk * 0.085) + (($vk - $ek) / 119 * 19) + $adCosts,2);
        return $this;
    }

    /**
     * @param mixed $salePrice
     */
    public function setSalePrice(): void
    {
        $this->salePrice = $this->uvp;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    public function setBrand(string $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBatteryEnthalten()
    {
        return $this->batteryEnthalten;
    }

    /**
     * @param mixed $batteryEnthalten
     */
    public function setBatteryEnthalten($batteryEnthalten): void
    {
        $this->batteryEnthalten = $batteryEnthalten;
    }
}
