<?php


namespace App\Services;


use App\Controller\Exceptions\AmazonApiException;
use App\Entity\AmazonFeedSubmission;
use App\Entity\AmazonItemActions;
use App\Entity\AmazonReportRequests;
use App\Entity\AmazonListing;
use App\Entity\ItemsWenko;
use App\Entity\ItemsWenkoHistory;
use App\Repository\AmazonListingRepository;
use App\Repository\AmazonReportRequestsRepository;
use App\Repository\ItemsWenkoRepository;
use Doctrine\ORM\EntityManagerInterface;
use MCS\MWSProduct;

class AmazonHandler
{

    /**
     * @var \App\Services\AmazonClient
     */
    private $amazonClient;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \App\Repository\AmazonReportRequestsRepository
     */
    private $amazonReportRequestsRepository;

    /**
     * @var \App\Repository\AmazonListingRepository
     */
    private $amazonListingRepository;

    public function __construct(
        AmazonClient $amazonClient,
        EntityManagerInterface $em,
        AmazonReportRequestsRepository $amazonReportRequestsRepository,
        AmazonListingRepository $amazonListingRepository
    )
    {
        $this->amazonClient = $amazonClient;
        $this->em = $em;
        $this->amazonReportRequestsRepository = $amazonReportRequestsRepository;
        $this->amazonListingRepository = $amazonListingRepository;
    }

    public function requestAmazonListingsReport(): string
    {
        try {
            $reportId = $this->amazonClient->requestReport(
                '_GET_MERCHANT_LISTINGS_DATA_'
            );

            $reportReq = new AmazonReportRequests();
            $reportReq->setReportName('_GET_MERCHANT_LISTINGS_DATA_');
            $reportReq->setReportStatus('_PENDING_');
            $reportReq->setRequestedAt(new \DateTime('now'));
            $reportReq->setReportId($reportId);
            $this->em->persist($reportReq);
            $this->em->flush();

            return $reportId;
        } catch (AmazonApiException $e) {
            throw new AmazonApiException($e->getMessage());
        }
    }

    public function getReportRequestStatus(): array
    {
        try {
            $reports = $this->amazonReportRequestsRepository->findPendingReports();
            $stats = [];
            if (!$reports) {
                return $stats;
            }
            foreach ($reports as $index => $report) {

                $reportStatus = $this->amazonClient->getReportRequestStatus(
                    (string) $report->getReportId()
                );

                $finishedDate = \DateTime::createFromFormat(
                    'Y-m-d\TH:i:sP',
                    $reportStatus['CompletedDate']
                );

                $report->setReportStatus(
                    $reportStatus['ReportProcessingStatus']
                );

                $report->setFinishedAt($finishedDate);
                $this->em->persist($report);
                $stats = [
                    'reportId' => $report->getReportId(),
                    'reportName' => $report->getReportName(),
                    'reportStatus' => $report->getReportStatus()
                ];
            }
            $this->em->flush();
            return $stats;
        } catch (AmazonApiException $e) {
            throw new AmazonApiException($e->getMessage());
        }
    }

    public function getAmazonListings(string $reportId)
    {
        $this->truncateTable(AmazonListing::class);

        $reportData = $this->amazonClient->getReportById($reportId);


        $stats = [
            'added' => 0,
            'updated' => 0
        ];
        $i = 0;
        $batchSize = 10;
        foreach ($reportData as $index => $listing) {
            $wenkoItemData = $this->em->getRepository(ItemsWenko::class)->find($listing['seller-sku']);
            dump($listing['seller-sku']);
            dump($wenkoItemData);
            $wenkoHistoryItem = $this->em->getRepository(ItemsWenkoHistory::class)->find($listing['seller-sku']);
            $listingEntity = new AmazonListing();
            $listingEntity->setAsin($listing['asin1']);
            $listingEntity->setSku($listing['seller-sku']);
            $listingEntity->setEan($wenkoItemData !== null ? $wenkoItemData->getEan() : '');
            $listingEntity->setIsWenko($wenkoHistoryItem !== null);
            $listingEntity->setPrice($listing['price']);
            $listingEntity->setStock($listing['quantity'] === '' ? 0 : $listing['quantity']);
            $listingEntity->setItemCondition($listing['item-condition']);
            $listingEntity->setListingId($listing['listing-id']);
            $listingEntity->setUpdatedAt(new \DateTime('now'));
            if ($listingEntity->getCreatedAt() === null) {
                $listingEntity->setCreatedAt(new \DateTime('now'));
            }
            $listingEntity->setCreatedAt(new \DateTime('now'));
            $this->em->persist($listingEntity);

            if ($i % $batchSize === 0) {
                $this->em->flush();
                $this->em->clear();
            }
            $stats['added']++;
            $i++;
        }

        $this->em->flush();
        $this->em->clear();

        return $stats;

//        $string = '\x57\x45\x4e\x4b\x4f\x20\x31\x31\x30\x30\x30\x33\x31\x30\x30\x20\x57\x43\x2d\x53\x69\x74\x7a\x20\x46\x61\x6d\x69\x6c\x79\x20\x54\x6f\x69\x6c\x65\x74\x74\x65\x6e\x2d\x44\x6f\x70\x70\x65\x6c\x73\x69\x74\x7a\x2c\x20\x41\x62\x73\x65\x6e\x6b\x61\x75\x74\x6f\x6d\x61\x74\x69\x6b\x2c\x20\x46\x69\x78\x2d\x43\x6c\x69\x70\x20\x48\x79\x67\x69\x65\x6e\x65\x20\x4b\x75\x6e\x73\x74\x73\x74\x6f\x66\x66\x62\x65\x66\x65\x73\x74\x69\x67\x75\x6e\x67\x2c\x20\x33\x35\x2c\x35\x20\x78\x20\x33\x38\x20\x63\x6d\x2c\x20\x77\x65\x69\xdf';
//        $string2 = 'lalala';
//        dd(mb_detect_encoding($string2, 'JIS', true));
    }

    public function deleteProductBySku(array $skus, array $amazonActionEntities): array
    {
        dump("delete");
//        $response = $this->amazonClient->deleteProductBySku($skus);
//        dump($response);
        $testdata = [
            'FeedSubmissionId' => '123',
            'FeedProcessingStatus' => '_PENDING_',
            'FeedType' => '_TESTINGS_',

        ];
        $amazonFeedSubmission = $this->addAmazonFeedSubmission($testdata);
//        $amazonFeedSubmission = $this->addAmazonFeedSubmission('123');
//        dump($amazonFeedSubmission);

        $this->relateItemActionsToAmazonFeedId($amazonActionEntities, $amazonFeedSubmission);
//        return $response;
    }

    public function createOrUpdateProduct(array $products, array $itemActionEntities)
    {
        $productsToChange = [];
        foreach ($products as $productData) {
            $product = new MWSProduct();
            $product->sku = $productData['sku'];
            $product->price = $productData['price'];
            $product->product_id = $productData['ean'];
            $product->product_id_type = 'EAN';
            $product->condition_type = 'New';
            $product->quantity = $productData['stock'];
            $productsToChange[] = $product;
            if (!$product->validate()) {
                continue;
            }
        }
        $response = $this->amazonClient->createOrUpdateProduct($productsToChange);

        $amazonFeedSubmission = $this->addAmazonFeedSubmission($response);
        $this->relateItemActionsToAmazonFeedId($itemActionEntities, $amazonFeedSubmission);
        return $response;
    }

    private function addAmazonFeedSubmission($response)
    {
        $amazonFeedSubmission = new AmazonFeedSubmission();
        $amazonFeedSubmission->setFeedSubmissionId($response['FeedSubmissionId']);
        $amazonFeedSubmission->setSubmittedAt(new \DateTime('now'));
        $amazonFeedSubmission->setFeedProcessingStatus($response['FeedProcessingStatus']);
        $amazonFeedSubmission->setFeedType($response['FeedType']);

        return $amazonFeedSubmission;
    }

    private function relateItemActionsToAmazonFeedId(array $amazonActionEntities, AmazonFeedSubmission $amazonFeedSubmission)
    {
        $i = 0;
        $batchSize = 20;
        foreach($amazonActionEntities as $amazonActionEntitiy) {
            $amazonFeedSubmission->addAmazonItemAction($amazonActionEntitiy);
            $this->em->persist($amazonFeedSubmission);
            if (($i % $batchSize) === 0) {
                $this->em->flush();
                $this->em->clear();
            }
            $i++;
        }
        $this->em->flush();
        $this->em->clear();
        dd();
    }

    public function truncateTable($class)
    {
        $classMetaData = $this->em->getClassMetadata($class);
        $connection = $this->em->getConnection();
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
            throw new AmazonApiException('Could not truncate table');
        }
    }
}
