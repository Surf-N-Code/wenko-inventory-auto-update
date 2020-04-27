<?php


namespace App\Controller;


use App\Entity\AmazonListing;
use App\Entity\ItemsWenko;
use App\Repository\AmazonListingRepository;
use App\Repository\ItemsOtherRepository;
use App\Services\AmazonHandler;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/api/get-other-items", name="items.other.get")
     */
    public function getOtherItmes(AmazonListingRepository $amazonListingRepository, ItemsOtherRepository $itemsOtherRepository)
    {
        foreach ($amazonListingRepository->findAll() as $index => $item) {
            if (!$itemsOtherRepository->find($item->getSku())) {

            }
        }

    }
}
