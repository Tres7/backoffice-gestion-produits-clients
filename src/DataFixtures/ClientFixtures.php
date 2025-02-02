<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $clientsData = [
            ['John', 'Doe', 'johndoe@example.com', '0601020304', '10 rue de Paris, 75001 Paris'],
            ['Jane', 'Smith', 'janesmith@example.com', '0612345678', '5 avenue des Champs, 75008 Paris'],
            ['Alice', 'Dupont', 'alice.dupont@example.com', '0711223344', '20 boulevard Haussmann, 75009 Paris'],
            ['Marc', 'Lambert', 'marc.lambert@example.com', '0699887766', '3 rue de Lyon, 69001 Lyon'],
            ['Sophie', 'Martin', 'sophie.martin@example.com', '0688776655', '15 avenue Foch, 06000 Nice']
        ];

        foreach ($clientsData as $data) {
            $client = new Client();
            $client->setFirstname($data[0]);
            $client->setLastname($data[1]);
            $client->setEmail($data[2]);
            $client->setPhoneNumber($data[3]);
            $client->setAddress($data[4]);
            $client->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($client);
        }

        $manager->flush();
    }
}
