<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\BaseItemPropertiesTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListingsAmazonRepository")
 * @ORM\Table(name="listings_amazon")
 */
class ListingsAmazon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    use BaseItemPropertiesTrait;

}
