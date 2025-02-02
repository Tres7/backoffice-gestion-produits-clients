<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreation(): void
    {
        $user = new User();
        $user->setEmail("user@example.com");
        $user->setPassword("securepassword");
        $user->setRoles(["ROLE_ADMIN"]);

        $this->assertEquals("user@example.com", $user->getEmail());
        $this->assertEquals("securepassword", $user->getPassword());
        $this->assertContains("ROLE_ADMIN", $user->getRoles());
    }
}
