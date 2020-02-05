<?php


namespace App\Services;


use App\Controller\Exceptions\AmazonApiException;
use MCS\MWSClient;
use MongoDB\Driver\Exception\AuthenticationException;

class AmazonClient
{

    private $client;

    public function __construct()
    {
        try {
            $this->client = new MWSClient(
                [
                    'Marketplace_Id' => 'A1PA6795UKMFR9',
                    'Seller_Id' => 'A1809TBPDU55I8',
                    'Access_Key_ID' => 'AKIAID7BXYFW6LMM6BUA',
                    'Secret_Access_Key' => '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',
                    'MWSAuthToken' => '',
                ]
            );
        } catch (\Exception $e) {
            throw new AuthenticationException("Invalid amazon api credentials");
        }
    }

    public function checkCredentials()
    {
        if (!$this->client->validateCredentials()) {
            throw new AuthenticationException("Invalid amazon api credentials");
        }

        return true;
    }

    public function getProductDetails(array $eans)
    {
        $searchField = 'EAN'; // Can be GCID, SellerSKU, UPC, EAN, ISBN, or JAN

        try {
            $result = $this->client->GetMatchingProductForId(
                $eans,
                $searchField
            );
        } catch (\Exception $e) {
            throw new AmazonApiException(
                sprintf(
                    'Couldn\'t get matching product for eans: %s with message: %s',
                    implode(',', $eans),
                    $e->getMessage()
                )
            );
        }

        return $result;
    }

    public function updateProductInventory(array $skuAndPrice): array
    {
        return $this->client->updateStock($skuAndPrice);
    }

    public function createOrUpdateProduct()
    {
//        $product = new MCS\MWSProduct();
//        $product->sku = 'TESTNOTFORSALE';
//        $product->price = '1000.00';
//        $product->product_id = 'B0031S9***';
//        $product->product_id_type = 'ASIN';
//        $product->condition_type = 'New';
//        $product->quantity = 10;
//
//        if ($product->validate()) {
//            // You can also submit an array of MWSProduct objects
//            $result = $client->postProduct($product);
//        } else {
//            $errors = $product->getValidationErrors();
//        }
    }

    public function getFeedSubmissionResult(string $feedSubmissionId): array
    {
        try {
            return $this->client->GetFeedSubmissionResult($feedSubmissionId);
        } catch (\Exception $e) {
            throw new AmazonApiException(sprintf('Failed getting the feed status for feed id: %s with message: %s', $feedSubmissionId, $e->getMessage()));
        }
    }

    public function requestReport(string $report, \datetime $startDate = null, \datetime $endDate = null): string
    {
        try {
            return $this->client->requestReport($report, $startDate, $endDate);
        } catch (\Exception $e) {
            throw new AmazonApiException(sprintf('Failed requesting the report: %s with message: %s', $report, $e->getMessage()));
        }
    }

    public function getReportById(string $reportId): array
    {
        try {
            return $this->client->getReport($reportId);
        } catch (\Exception $e) {
            throw new AmazonApiException(sprintf('Failed getting the report: %s with message: %s', $reportId, $e->getMessage()));
        }
    }

    public function getReportRequestStatus(string $reportId): array
    {
        try {
            return $this->client->GetReportRequestStatus($reportId);
        } catch (\Exception $e) {
            throw new AmazonApiException(sprintf('Failed getting the report status for report: %s with message: %s', $reportId, $e->getMessage()));
        }
    }
}
