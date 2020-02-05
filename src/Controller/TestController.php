<?php

namespace App\Controller;

use MCS\MWSClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        try {
            $client = new MWSClient(
                [
                    'Marketplace_Id'    => 'A1PA6795UKMFR9',
                    'Seller_Id'         => 'A1809TBPDU55I8',
                    'Access_Key_ID'     => 'AKIAID7BXYFW6LMM6BUA',
                    'Secret_Access_Key' => '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',
                    'MWSAuthToken'      => ''
                    // Optional. Only use this key if you are a third party user/developer
                ]
            );
        } catch (\Exception $e) {
            dd($e);
        }

        // Optionally check if the supplied credentials are valid
        if ($client->validateCredentials()) {
            // Credentials are valid
            dump("valid");
        } else {
            dd("invalid;");
            // Credentials are not valid
        }

//        $fromDate = new \DateTime('2020-01-01');
//        $orders = $client->ListOrders($fromDate);
//        foreach ($orders as $order) {
//            $items = $client->ListOrderItems($order['AmazonOrderId']);
//            dump($order);
//            dd($items);
//        }



        $result = $client->updateStock([
            '2329100' => 20,
        ]);
        dump($result);

        $info = $client->GetFeedSubmissionResult(87682018293);
        dd($info);

//        return $this->render('test/index.html.twig', [
//            'controller_name' => 'TestController',
//        ]);
    }

//    public function getProductInfo()
//    {
//        $searchField = 'SellerSKU'; // Can be GCID, SellerSKU, UPC, EAN, ISBN, or JAN
//
//        $result = $client->GetMatchingProductForId([
//            '2329100'
//        ], $searchField);
//    }
}
