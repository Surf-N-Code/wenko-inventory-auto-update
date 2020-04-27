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
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sales;

    /**
     * @ORM\Column(type="string")
     */
    private $salesValue;

    public function getId(): ?int
    {
        return $this->id;
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
