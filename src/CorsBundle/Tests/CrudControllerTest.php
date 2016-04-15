<?php

namespace CorsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CrudControllerTest extends WebTestCase
{
    public function testGetAll()
    {
        $client = static::createClient();

        $client->request('GET', '/api/users');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testGetOne()
    {
        $client = static::createClient();

        $client->request('GET', '/api/user/1');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/api/user/999');
        $this->assertTrue($client->getResponse()->isNotFound());
    }
}
