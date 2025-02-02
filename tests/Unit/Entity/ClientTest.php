<?php

namespace App\Tests\Entity;

use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testClientCreation(): void
    {
        $client = new Client();
        $client->setFirstname("John");
        $client->setLastname("Doe");
        $client->setEmail("johndoe@example.com");
        $client->setPhoneNumber("0601020304");
        $client->setAddress("10 rue de Paris, 75001 Paris");
        $client->setCreatedAt(new \DateTimeImmutable());

        $this->assertEquals("John", $client->getFirstname());
        $this->assertEquals("Doe", $client->getLastname());
        $this->assertEquals("johndoe@example.com", $client->getEmail());
        $this->assertEquals("0601020304", $client->getPhoneNumber());
        $this->assertEquals("10 rue de Paris, 75001 Paris", $client->getAddress());
        $this->assertInstanceOf(\DateTimeImmutable::class, $client->getCreatedAt());
    }
}
