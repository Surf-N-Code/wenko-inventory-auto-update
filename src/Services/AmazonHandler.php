<?php


namespace App\Services;


use App\Controller\Exceptions\AmazonApiException;
use App\Entity\AmazonReportRequests;
use App\Repository\AmazonReportRequestsRepository;
use Doctrine\ORM\EntityManagerInterface;

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

    public function __construct(
        AmazonClient $amazonClient,
        EntityManagerInterface $em,
        AmazonReportRequestsRepository $amazonReportRequestsRepository
    )
    {
        $this->amazonClient = $amazonClient;
        $this->em = $em;
        $this->amazonReportRequestsRepository = $amazonReportRequestsRepository;
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
            $reports = $this->amazonReportRequestsRepository->findby(['reportStatus' => '_PENDING_']);
            $stats = [];
            foreach ($reports as $index => $report) {
                $reportStatus = $this->amazonClient->getReportRequestStatus(
                    $report->getReportId()
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
                $stats[] = [
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

    public function getAmazonListingsReport(string $reportId)
    {
        return $this->amazonClient->getReportById($reportId);
    }

    public function updateAmazonItems($listingsReportData)
    {
        foreach ($listingsReportData as $index => $listing) {

        }
    }
}
