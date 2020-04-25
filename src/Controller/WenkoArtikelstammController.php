<?php


namespace App\Controller;


use App\Entity\ItemsWenko;
use App\Services\AmazonHandler;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WenkoArtikelstammController
{
    /**
     * @Route("/wenko/read-itemfile", name="items.wenko.read_itemfile")
     */
    public function readItemFile(EntityManagerInterface $em, AmazonHandler $amazonHandler)
    {
        ini_set('max_execution_time', 120);
        $csv = Reader::createFromPath(__DIR__.'/../Resources/Artikelstamm/20200201.csv', 'r');
        $csv->setDelimiter('|');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        try {
            $amazonHandler->truncateTable(ItemsWenko::class);
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage(), 400);
        }

        $i = 0;
        $batchSize = 50;
        foreach($records as $record) {
            $art = $em->find(ItemsWenko::class, $record['id']);
            if(!$art) {
                $art = new ItemsWenko();
            }

            $art->setArticleId($record['id']);
            $art->setBatteryEnthalten($record['battery_enthalten']);
            $art->setDeliveryTime($record['delivery_time']);
            $art->setDescription($record['description']);
            $art->setDescriptionHtml($record['description_html']);
            $art->setEan($record['ean']);
            $art->setHeight($record['height']);
            $art->setImage1($record['image_url_1']);
            $art->setImage2($record['image_url_2']);
            $art->setImage3($record['image_url_3']);
            $art->setImage4($record['image_url_4']);
            $art->setImage5($record['image_url_5']);
            $art->setImage6($record['image_url_6']);
            $art->setImage7($record['image_url_7']);
            $art->setImage8($record['image_url_8']);
            $art->setImage9($record['image_url_9']);
            $art->setImage10($record['image_url_10']);
            $art->setLength($record['lenght']);
            $art->setMarke($record['ecom_marke']);
            $art->setMetaDescription($record['meta_description']);
            $art->setMetaKeyword("");
            $art->setName($record['name']);
            $art->setStock(isset($record['quantity']) ? $record['quantity'] : 0);
            $art->setShippingCost($record['shipping_cost']);
            $art->setShopCategory($record['category']);
            $art->setShopUrl($record['url']);
            $art->setSku($record['sku']);
            $art->setPrice($record['price_incl_tax']);
            $art->setWeight($record['weight']);
            $art->calculateCost(0.6, 0);
            $art->setBrand("Wenko");

            $em->persist($art);
            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear(); // Detaches all objects from Doctrine!
            }
            $i++;
        }
        $em->flush();
        $em->clear();

        return new Response(sprintf('Added: %s wenko products to the wenko item database', $i), 201);
    }
}
