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
     * @var string $sku
     *
     * @ORM\Column(name="sku", type="string")
     */
    private $sku;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var float $uvp
     *
     * @ORM\Column(name="uvp", type="float")
     */
    private $uvp;

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
    public function getUvp(): float
    {
        return $this->uvp;
    }

    /**
     * @param float $uvp
     */
    public function setUvp(float $uvp): void
    {
        $this->uvp = $uvp;
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
}
