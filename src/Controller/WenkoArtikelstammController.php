<?php


namespace App\Controller;


use App\Entity\ItemsWenko;
use App\Entity\ItemsWenkoHistory;
use App\Entity\WenkoTopSellers;
use App\Repository\ItemsWenkoHistoryRepository;
use App\Repository\ItemsWenkoRepository;
use App\Repository\WenkoTopSellersRepository;
use App\Services\AmazonHandler;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WenkoArtikelstammController extends AbstractController
{
    /**
     * @Route("/wenko/read-itemfile", name="items.wenko.read_itemfile")
     */
    public function readItemFile(EntityManagerInterface $em, AmazonHandler $amazonHandler, ItemsWenkoRepository $itemsWenkoRepository, ItemsWenkoHistoryRepository $itemsWenkoHistoryRepository)
    {
        ini_set('max_execution_time', 120);
        $csv = Reader::createFromPath(__DIR__.'/../Resources/Artikelstamm/20200425.csv', 'r');
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
//            dd($record);
            $art = $itemsWenkoRepository->find($record['sku']);
            $artHistory = $itemsWenkoHistoryRepository->find($record['sku']);
            if(!$art) {
                $art = new ItemsWenko();
            }

            if(!$artHistory) {
                $artHistory = new ItemsWenkoHistory();
            }

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

            $artHistory->setSku($record['sku']);
            $artHistory->setEan($record['ean']);
            $artHistory->setUpdatedAt(new \DateTime('now'));

            $em->persist($art);
            $em->persist($artHistory);
            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear(); // Detaches all objects from Doctrine!
            }
            $i++;
        }
        $em->flush();
        $em->clear();

        return $this->render('result.html.twig', [
            'statusMessage' => sprintf('Added: %s wenko products to the wenko item database', $i),
        ]);
    }

    /**
     * @Route("/wenko/read-top-seller", name="items.wenko.read_topsellers")
     */
    public function readTopSeller(
        EntityManagerInterface $em,
        AmazonHandler $amazonHandler,
        WenkoTopSellersRepository $tsRepo,
        ItemsWenkoRepository $iwRepo
    )
    {
        ini_set('max_execution_time', 120);
        $csv = Reader::createFromPath(__DIR__.'/../Resources/TopSellers/20200425.csv', 'r');
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        try {
            $amazonHandler->truncateTable(WenkoTopSellers::class);
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage(), 400);
        }


        $i = 0;
        $batchSize = 50;
        foreach($records as $record) {
            $art = $tsRepo->findOneBy(['sku' => $record['SKU']]);
            if(!$art) {
                $art = new WenkoTopSellers();
            }

            $art->setSku($iwRepo->findOneBy(['sku' => $record['SKU']]));
            dump($record['Qty Sold']);
            dump($record['SKU']);
            dump($record['GMV']);
            $art->setSales($record['Qty Sold']);
            $art->setSalesValue($record['GMV']);

            $em->persist($art);
            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear(); // Detaches all objects from Doctrine!
            }
            $i++;
        }
        $em->flush();
        $em->clear();

        return $this->render('result.html.twig', [
            'statusMessage' => sprintf('Added: %s wenko products to the wenko top sellers database', $i)
        ]);
    }
}
