<?php

namespace App\Controller;

use App\Entity\AmazonReportRequests;
use App\Entity\AmazonListing;
use App\Entity\AmazonItemActions;
use App\Entity\ItemsWenko;
use App\Entity\AmazonFeedSubmission;
use App\Repository\AmazonItemActionsepository;
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
    private $amazonHandler;

    public function __construct(AmazonClient $amazonClient, EntityManagerInterface $em, AmazonHandler $amazonHandler)
    {
        $this->amazonClient = $amazonClient;
        $this->em = $em;
        $this->amazonHandler = $amazonHandler;
    }

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/amazon/delete-used-products", name="index")
     */
    public function deleteUsedProducts()
    {
        $amazonListingRepo = $this->em->getRepository(AmazonListing::class);
        $usedItems = $amazonListingRepo->findBy(['itemCondition' => 'UsedLikeNew']);
        foreach($usedItems as $usedItem) {
//            $this->em->remove($usedItem);
            $sku[] = $usedItem->getSku();
        }
//        $this->em->flush();
        //12100102 - deleted
        //23781102
        $response = $this->amazonHandler->deleteProductBySku(['23928100']);
        dd($response);
        return new Response("Deleting items");
    }

    /**
     * @Route("/wenko/read-itemfile", name="items.wenko.read_itemfile")
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

        return $this->render('artikelstamm/index.html.twig', [
            'statusMessage' => sprintf('Added: %s wenko products to the wenko item database', $i)
        ]);
    }

    /**
     * @Route("/amazon/get-item-actions", name="items.amazon.get_item_actions")
     */
    public function getAmazonItemActions(EntityManagerInterface $em) {
        $wenkoItemRepo = $this->getDoctrine()->getRepository(ItemsWenko::class);
        $amazonItemRepo = $this->getDoctrine()->getRepository(AmazonListing::class);
        $itemsToRemove = $amazonItemRepo->getItemsToRemove();
        $itemsToAdd = $wenkoItemRepo->getItemsToAdd();
        $itemsToUpdate = $wenkoItemRepo->getItemsToUpdate();

        $itemActionCollection = [
            'remove' => $itemsToRemove,
            'add' => $itemsToAdd,
            'update' => $itemsToUpdate,
        ];

        $itemActionCollectionStats = [
            'remove' => 0,
            'add' => 0,
            'update' => 0,
        ];
        $i = 0;
        $statCount = 0;
        $batchSize = 50;
        foreach ($itemActionCollection as $itemAction => $items) {
            foreach($items as $item) {
                $itemActionEntity = new AmazonItemActions(
                    $itemAction,
                    $item->getSku(),
                    $item->getStock(),
                    $item->getPrice()
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

        return $this->render('artikelstamm/index.html.twig', [
            'statusMessage' => sprintf(
                'Removed: %s, added: %s, updated: %s',
                $itemActionCollectionStats['remove'],
                $itemActionCollectionStats['add'],
                $itemActionCollectionStats['update']
            )
        ]);
    }

    /**
     * @Route("/amazon/update-stock", name="items.amazon.update")
     */
    public function updateAmazonStock(AmazonItemActionsepository $amazonItemActionsepository)
    {
        //@todo: http://docs.developer.amazonservices.com/en_US/notifications/Notifications_FeedProcessingFinishedNotification.html

        ini_set('max_execution_time', 99999);
        $items = $amazonItemActionsepository->findAll();

        $skuActions = [];
        /** @var AmazonItemActions $item */
        foreach ($items as $item) {
            $debug[$item->getAmazonAction()][] = [
                'sku'   => $item->getSku(),
                'price' => $item->getPrice(),
                'stock' => $item->getStock()
            ];

            switch ($item->getAmazonAction()) {
                case 'update':
                    $skuActions['update'][] = [
                        'sku'   => $item->getSku(),
                        'price' => $item->getPrice()
                    ];
                    break;

                case 'add':
                    $skuActions['add'][] = [
                        'sku'   => $item->getSku(),
                        'price' => $item->getPrice()
                    ];
                    break;

                case 'remove':
                    $skuActions['remove'][] = [
                        'sku'   => $item->getSku()
                    ];
                    break;
            }
        }
        dump($skuActions);
//        dd($debug);
        $updateResponse = $this->amazonClient->updateProductInventory($skuActions);

        $itemUpdateStatus = new AmazonFeedSubmission();
        $itemUpdateStatus->setFeedSubmissionId($updateResponse['FeedSubmissionId']);
        $itemUpdateStatus->setSubmittedAt(new \DateTime('now'));
        $itemUpdateStatus->setFeedProcessingStatus($updateResponse['FeedProcessingStatus']);
        $itemUpdateStatus->setFeedType($updateResponse['FeedType']);
        $itemUpdateStatus->setSuccess(false);
        $this->em->persist($itemUpdateStatus);
        $this->em->flush();
        dd($updateResponse);
    }

    /**
     * @Route("/amazon/get-listings-report", name="items.amazon.get_listings_report")
     */
    public function requestAmazonListingsReport() {
        try {
            $reportId = $this->amazonHandler->requestAmazonListingsReport();
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage());
        }

        return $this->render('artikelstamm/index.html.twig', [
            'statusMessage' => sprintf('Successfully requested report with id: %s', $reportId)
        ]);
    }

    /**
     * @Route("/amazon/get-report-status", name="items.amazon.get_report_status")
     */
    public function getReportRequestStatus(AmazonReportRequestsRepository $repo) {
        try {
            $stats = $this->amazonHandler->getReportRequestStatus();
        } catch (Exceptions\AmazonApiException $e) {
            return $this->render('artikelstamm/index.html.twig', [
                'statusMessage' => 'Feed not ready yet'
            ]);
        }

        $returnMessage = 'No pending feed found';
        if (isset($stats['reportId'])) {
            $returnMessage = sprintf('Feed id: %s, of type: %s, with status: %s', $stats['reportId'], $stats['reportName'], $stats['reportStatus']);
        }

        return $this->render('artikelstamm/index.html.twig', [
            'statusMessage' => $returnMessage
        ]);
    }

    /**
     * @Route("/amazon/get-report-listings/{reportId}", name="items.amazon.get_report_listings")
     */
    public function getReportById($reportId) {
        try {
            $noListings = $this->amazonHandler->getAmazonListings($reportId);
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage());
        }

        return $this->render('artikelstamm/index.html.twig', [
            'statusMessage' => sprintf('Products added to db: %s, products updated: %s', $noListings['added'], $noListings['updated'])
        ]);
    }

    /**
     * @Route("/amazon/get-feed-submission-status/{feedId}", name="items.amazon.get_feed_sumission_status")
     */
    public function getFeedSubmissionStatus($feedId)
    {
        try {
            $result = $this->amazonClient->getFeedSubmissionResult($feedId);
        } catch (Exceptions\AmazonApiException $e) {
            return $this->render('artikelstamm/index.html.twig', [
                'Feed not ready yet, check back later'
            ]);
        }

        $feedSubmissionRepo = $this->em->getRepository(AmazonFeedSubmission::class);

        /** @var AmazonFeedSubmission $feed */
        $feed = $feedSubmissionRepo->findBy(['feedSubmissionId' => $feedId])[0];
        if ($result['StatusCode'] === 'Complete') {
            $feed->setFeedProcessingStatus('_DONE_');
            $feed->setSuccess(true);
        }

        return $this->render('artikelstamm/index.html.twig', [
            'statusMessage' => sprintf(
                '%s messages processed, %s successfull messages, %s messages with errors, %s messages with warning',
                $result['ProcessingSummary']['MessagesProcessed'],
                $result['ProcessingSummary']['MessagesSuccessful'],
                $result['ProcessingSummary']['MessagesWithError'],
                $result['ProcessingSummary']['MessagesWithWarning']
            ),
        ]);
    }
}
