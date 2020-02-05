<?php

namespace App\Controller;

use App\Entity\AmazonReportRequests;
use App\Entity\ListingsAmazon;
use App\Entity\AmazonItemActions;
use App\Entity\ItemsWenko;
use App\Entity\ItemUpdateStatus;
use App\Repository\AmazonReportRequestsRepository;
use App\Services\AmazonClient;
use App\Services\AmazonHandler;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtikelstammController extends AbstractController
{
    private $amazonClient;
    private $em;

    /**
     * @var \App\Services\AmazonHandler
     */
    private $amazonHandler;

    public function __construct(AmazonClient $amazonClient, EntityManagerInterface $em, AmazonHandler $amazonHandler)
    {
        $this->amazonClient = $amazonClient;
        $this->em = $em;
        $this->amazonHandler = $amazonHandler;
    }

    /**
     * @Route("/readItemFile", name="itemfile.read")
     */
    public function readItemFile(EntityManagerInterface $em)
    {
        ini_set('max_execution_time', 120);
        $csv = Reader::createFromPath(__DIR__.'/../Resources/Artikelstamm/20200201.csv', 'r');
        $csv->setDelimiter('|');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords(); //returns all the CSV records as an Iterator object

        $classMetaData = $em->getClassMetadata(ItemsWenko::class);
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($classMetaData->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        catch (\Exception $e) {
            $connection->rollback();
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
            $art->setUvp($record['price_incl_tax']);
            $art->setWeight($record['weight']);
            $art->setVkDiscount(0);
            $art->calculateCost(0.6, 0);
            $art->setSalePrice();
            $art->setBrand("Wenko");

            $em->persist($art);
            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear(); // Detaches all objects from Doctrine!
            }
            $i++;
        }
        $em->flush(); //Persist objects that did not make up an entire batch
        $em->clear();


        return $this->render('artikelstamm/index.html.twig', [
            'controller_name' => 'ArtikelstammController',
        ]);
    }

    /**
     * @Route("/getamazonactions", name="items.amazon.get_actions")
     */
    public function getProductsToAdd(EntityManagerInterface $em) {
        $wenkoItemRepo = $this->getDoctrine()->getRepository(ItemsWenko::class);
        $amazonItemRepo = $this->getDoctrine()->getRepository(ListingsAmazon::class);
        $itemsToRemove = $amazonItemRepo->getItemsToRemove();
        $itemsToAdd = $wenkoItemRepo->getItemsToAdd();
        $itemsToUpdate = $wenkoItemRepo->getItemsToUpdate();

        $itemActionCollection = [
            'remove' => $itemsToRemove,
            'add' => $itemsToAdd,
            'update' => $itemsToUpdate
        ];

        $itemActionCollectionStats = [
            'remove' => 0,
            'add' => 0,
            'update' => 0
        ];
        $i = 0;
        $statCount = 0;
        $batchSize = 50;
        foreach ($itemActionCollection as $itemAction => $items) {
            foreach($items as $item) {
                $itemActionEntity = new AmazonItemActions(
                    $itemAction,
                    $item->getEan(),
                    $item->getSku(),
                    $item->getName(),
                    $item->getStock(),
                    $item->getUvp()
                );
                $em->persist($itemActionEntity);
                if (($i % $batchSize) === 0) {
                    $em->flush();
                    $em->clear(); // Detaches all objects from Doctrine!
                }
                $i++;
                $statCount++;
            }
            $itemActionCollectionStats[$itemAction] = $statCount;
            $statCount = 0;
        }
        $em->flush();
        $em->clear();

        return new Response(
            sprintf(
                'Removed: %s, added: %s, updated: %s',
                $itemActionCollectionStats['remove'],
                $itemActionCollectionStats['add'],
                $itemActionCollectionStats['update']
            )
        );
    }

    /**
     * @Route("/updateAmazonStock", name="items.amazon.update")
     */
    public function updateAmazonStock()
    {
        //@todo: http://docs.developer.amazonservices.com/en_US/notifications/Notifications_FeedProcessingFinishedNotification.html

        ini_set('max_execution_time', 99999);
        $items = $this->getDoctrine()->getRepository(ItemsWenko::class)->findAll();

        foreach ($items as $item) {
            sleep(10);
            $product = $this->amazonClient->getProductDetails([$item->getEan()]);
            if (count($product['found']) > 0) {
                dump($item->getSku());
                $this->updateProductInventory($product, $item->getSku(), $item->getStock());
            }
        }
        dump($product);
        dd();
    }

    private function updateProductInventory($productsFound, $skuToUpdate, $quantity)
    {
        if (count($productsFound['found']) > 0) {
            $skuQuantity[$skuToUpdate] = $quantity;
            $updateResponse = $this->amazonClient->updateProductInventory($skuQuantity);
            $itemUpdateStatus = new ItemUpdateStatus();
            $itemUpdateStatus->setFeedSubmissionId($updateResponse['FeedSubmissionId']);
            $itemUpdateStatus->setIdentifier($skuToUpdate);
            $itemUpdateStatus->setIdentifierType('SKU');
            $itemUpdateStatus->setUpdatedAt(new \DateTime('now'));
            $itemUpdateStatus->setFeedProcessingStatus($updateResponse['FeedProcessingStatus']);
            $itemUpdateStatus->setFeedType($updateResponse['FeedType']);
            $itemUpdateStatus->setSuccess(false);
            $this->em->persist($itemUpdateStatus);
            $this->em->flush();
        }
    }

    /**
     * @Route("/getfeedstatus", name="items.amazon.feedstatus")
     */
    public function getFeedSubmissionStatus()
    {
        $feeds = $this->getDoctrine()->getRepository(ItemUpdateStatus::class)->findBy(['feedProcessingStatus' => '_SUBMITTED_']);
        /** @var ItemUpdateStatus $feed */
        foreach($feeds as $feed) {
            $result = $this->amazonClient->getFeedSubmissionResult($feed->getFeedSubmissionId());
            dump($result);
//            if ($result['ProcessingSummary']['MessagesSuccessful'])
        }
        dd("done");
    }

    /**
     * @Route("/amazon/readitems", name="items.amazon.get_report")
     */
    public function requestAmazonListingsReport() {
        try {
            $reportId = $this->amazonHandler->requestAmazonListingsReport();
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage());
        }

        return new Response(sprintf('Successfully requested report with id: %s', $reportId));
    }

    /**
     * @Route("/amazon/reportStatus", name="items.amazon.get_report_status")
     */
    public function getReportRequestStatus(AmazonReportRequestsRepository $repo) {
        try {
            $stats = $this->amazonHandler->getReportRequestStatus();
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage());
        }

        return new JsonResponse($stats);
    }

    /**
     * @Route("/amazon/getreport", name="items.amazon.get_report")
     */
    public function getReportById() {
        try {
            $report = $this->amazonHandler->getAmazonListingsReport´d('88138018297');
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage());
        }
        dd($report);
        return new JsonResponse($stats);
    }
}
