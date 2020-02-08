<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\BaseItemPropertiesTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmazonItemActionsepository")
 * @ORM\Table(name="amazon_item_actions")
 */
class AmazonItemActions
{

    public function __construct($amazonAction, $sku, $stock, $price)
    {
        $this->amazonAction = $amazonAction;
        $this->sku = $sku;
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

    use TimestampableTrait;

    use BaseItemPropertiesTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $amazonAction;

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
}
