<?php

namespace App\Tests\Service;

use App\Repository\ProductRepository;
use App\Service\ProductCsvExporter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\StreamedResponse;


class ProductCsvExporterTest extends TestCase
{
    public function testExportProductsReturnsStreamedResponse(): void
    {
        // Mock product repository
        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->method('findAll')->willReturn([]);

        $csvExporter = new ProductCsvExporter($productRepository);
        $response = $csvExporter->exportProducts();

        $this->assertInstanceOf(StreamedResponse::class, $response);
    }
}


?>