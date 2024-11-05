<?php

namespace App\Tests\Smoke;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideMethodAndUri
     */
    public function testPageReturnsHttp200Ok(string $method, string $uri): void
    {
        $client = static::createClient();
        $client->request($method, $uri);

        $this->assertResponseIsSuccessful();
    }

    public function provideMethodAndUri(): iterable
    {
        return [
            'homepage' => ['GET', '/'],
            'contact page' => ['GET', '/contact'],
        ];
    }
}

