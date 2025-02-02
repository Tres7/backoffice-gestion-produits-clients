<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductCreation(): void
    {
        $product = new Product();
        $product->setName("Ordinateur Portable");
        $product->setDescription("Un ordinateur puissant pour le travail.");
        $product->setPrice(1200.99);

        $this->assertEquals("Ordinateur Portable", $product->getName());
        $this->assertEquals("Un ordinateur puissant pour le travail.", $product->getDescription());
        $this->assertEquals(1200.99, $product->getPrice());
    }
}
