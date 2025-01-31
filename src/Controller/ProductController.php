<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\ProductCsvExporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController{
    #[Route('/product', name: 'products_index')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' =>$productRepository->findAllSortedByPriceDesc(),
        ]);
    }

    #[Route('/products/export', name: 'products_export')]
    public function export(ProductCsvExporter $csvExporter): Response
    {
        return $csvExporter->exportProducts();
    }

}
