<?php


namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait BaseItemPropertiesTrait
{
    /**
     * @var string $ean
     *
     * @ORM\Column(name="ean", type="string")
     */
    private $ean;

    /**
     * @var float $price
     *
     * @ORM\Column(name="uvp", type="float")
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
