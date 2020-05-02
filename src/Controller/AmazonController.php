<?php

namespace App\Controller;

use App\Entity\AmazonReportRequests;
use App\Entity\AmazonListing;
use App\Entity\AmazonItemActions;
use App\Entity\ItemsWenko;
use App\Entity\AmazonFeedSubmission;
use App\Repository\AmazonItemActionsRepository;
use App\Repository\AmazonReportRequestsRepository;
use App\Services\AmazonClient;
use App\Services\AmazonHandler;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AmazonController extends AbstractController
{
    private $amazonClient;
    private $em;
    private $amazonHandler;

    public function __construct(
        AmazonClient $amazonClient,
        EntityManagerInterface $em,
        AmazonHandler $amazonHandler)
    {
        $this->amazonClient = $amazonClient;
        $this->em = $em;
        $this->amazonHandler = $amazonHandler;
    }

    /**
     * @Route("/amazon/get-item-actions", name="items.amazon.get_item_actions")
     */
    public function getItemActions() {
        try {
            $this->amazonHandler->truncateTable(AmazonItemActions::class);
        } catch (Exceptions\AmazonApiException $e) {
            return new Response('Failed truncating amazon item actions', 400);
        }

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
                    $item->getEan(),
                    $item->getStock(),
                    $item->getPrice()
                );
                $this->em->persist($itemActionEntity);
                if (($i % $batchSize) === 0) {
                    $this->em->flush();
                    $this->em->clear(); // Detaches all objects from Doctrine!
                }
                $i++;
                $statCount++;
            }
            $itemActionCollectionStats[$itemAction] = $statCount;
            $statCount = 0;
        }
        $this->em->flush();
        $this->em->clear();

        return $this->render('result.html.twig', [
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
    public function updateAmazonStock(AmazonItemActionsRepository $amazonItemActionsepository)
    {
        //@todo: http://docs.developer.amazonservices.com/en_US/notifications/Notifications_FeedProcessingFinishedNotification.html
        $items = $amazonItemActionsepository->findItemsToProcess();
        $skuActions = [];
        $itemActionEntity = [];
        /** @var AmazonItemActions $item */
        foreach ($items as $key => $item) {
            $debug[$item->getAmazonAction()][] = [
                'sku'   => $item->getSku(),
                'price' => $item->getPrice(),
                'stock' => $item->getStock(),
                'entity' => $item
            ];

            switch ($item->getAmazonAction()) {
                case 'update':
                case 'add':
                    $skuActions['createOrUpdate'][] = [
                        'sku'   => $item->getSku(),
                        'price' => $item->getPrice(),
                        'ean' => $item->getEan(),
                        'stock' => $item->getStock()
                    ];
                    $itemActionEntity['createOrUpdate'][] = $item;
                    break;

                case 'remove':
                    $skuActions['remove'][] = [
                        $item->getSku()
                    ];
                    $itemActionEntity['remove'][] = $item;
                    break;
            }
        }

        $failMsg = [];
        if (!empty($skuActions['remove'])) {
            try {
                $this->amazonHandler->deleteProductBySku($skuActions['remove'], $itemActionEntity['remove']);
            } catch (\Exception $e) {
                $failMsg[] = sprintf('Failed deleting Amazon items with message: %s', $e->getMessage());
            }
        }

        if (!empty($skuActions['createOrUpdate'])) {
            try {
                $this->amazonHandler->createOrUpdateProduct($skuActions['createOrUpdate'], $itemActionEntity['createOrUpdate']);
            } catch (\Exception $e) {
                $failMsg[] = sprintf('Failed updating or adding Amazon items with message: %s', $e->getMessage());
            }
        }

        if (!empty($failMsg)) {
            return new Response(sprintf('Failed updating Amazon inventory with mesage(s): %s', implode('', $failMsg)));
        }

        return $this->render('base.html.twig', [
            'statusMessage' =>  sprintf(
                'Successfully sent %s products for deletion and %s products for an update or addition to amazon',
                count($skuActions['remove'] ?? []),
                count($skuActions['createOrUpdate'] ?? [])
            )
        ]);
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

        return $this->render('result.html.twig', [
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
            return $this->render('result.html.twig', [
                'statusMessage' => 'Feed not ready yet'
            ]);
        }

        $returnMessage = 'No pending feed found';
        if (isset($stats['reportId'])) {
            $returnMessage = sprintf('Feed id: %s, of type: %s, with status: %s', $stats['reportId'], $stats['reportName'], $stats['reportStatus']);
        }

        return $this->render('result.html.twig', [
            'statusMessage' => $returnMessage
        ]);
    }

    /**
     * @Route("/amazon/get-listings/{reportId}", name="items.amazon.get_listings")
     */
    public function getReportById($reportId) {
        try {
            $noListings = $this->amazonHandler->getAmazonListings($reportId);
        } catch (Exceptions\AmazonApiException $e) {
            return new Response($e->getMessage());
        }

        return $this->render('result.html.twig', [
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
            return $this->render('result.html.twig', [
                'statusMessage' => 'Feed not ready yet, check back later'
            ]);
        }

        $feedSubmissionRepo = $this->em->getRepository(AmazonFeedSubmission::class);

        /** @var AmazonFeedSubmission $feed */
        $feed = $feedSubmissionRepo->findBy(['feedSubmissionId' => $feedId]);
        if (!$feed) {
            return $this->render('result.html.twig', [
                'statusMessage' => 'No pending feed found'
            ]);
        }
        $feed = $feed[0];
        if ($result && $result['StatusCode'] === 'Complete') {
            $feed->setFeedProcessingStatus('_DONE_');
            $feed->setSuccess(true);
        }

        return $this->render('result.html.twig', [
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
