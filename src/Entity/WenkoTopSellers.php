<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WenkoTopSellersRepository")
 */
class WenkoTopSellers
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $sku;

    /**
     * @ORM\Column(type="integer")
     */
    private $sales;

    /**
     * @ORM\Column(type="string")
     */
    private $salesValue;

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku): void
    {
        $this->sku = $sku;
    }

    public function getSales(): ?int
    {
        return $this->sales;
    }

    public function setSales(int $sales): self
    {
        $this->sales = $sales;

        return $this;
    }

    public function getSalesValue(): ?string
    {
        return $this->salesValue;
    }

    public function setSalesValue(string $salesValue): self
    {
        $this->salesValue = $salesValue;

        return $this;
    }
}
