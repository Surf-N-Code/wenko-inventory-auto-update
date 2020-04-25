<?php

namespace App\Controller;

use App\Entity\AmazonListing;
use App\Services\AmazonHandler;
use MCS\MWSClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/amazon/delete-used-products", name="index")
     */
    public function deleteUsedProducts(AmazonHandler $amazonHandler)
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
        $response = $amazonHandler->deleteProductBySku(['23928100']);
        dd($response);
        return new Response("Deleting items");
    }
}
