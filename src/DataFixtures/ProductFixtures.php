<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'Ordinateur Portable', 'description' => 'Un PC performant pour le travail et le gaming.', 'price' => 1200.99],
            ['name' => 'Smartphone', 'description' => 'Un téléphone haut de gamme avec un excellent appareil photo.', 'price' => 899.50],
            ['name' => 'Casque Audio', 'description' => 'Un casque sans fil avec réduction de bruit active.', 'price' => 199.99],
            ['name' => 'Montre Connectée', 'description' => 'Une smartwatch avec suivi de santé et notifications.', 'price' => 249.99],
            ['name' => 'Clavier Mécanique', 'description' => 'Clavier RGB mécanique pour gamers et programmeurs.', 'price' => 99.90],
            ['name' => 'Écran 27 pouces', 'description' => 'Un écran 4K UHD idéal pour le graphisme et le gaming.', 'price' => 399.00],
            ['name' => 'Souris Gaming', 'description' => 'Souris ergonomique avec capteur haute précision.', 'price' => 59.99],
            ['name' => 'Enceinte Bluetooth', 'description' => 'Une enceinte portable avec un son puissant.', 'price' => 89.90],
            ['name' => 'Chargeur Sans Fil', 'description' => 'Chargeur rapide compatible avec plusieurs marques.', 'price' => 29.99],
            ['name' => 'Disque Dur Externe 1To', 'description' => 'Stockez toutes vos données en toute sécurité.', 'price' => 79.99],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
