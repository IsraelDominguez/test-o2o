<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilTest extends WebTestCase
{
    public function testSomething()
    {
        $this->assertTrue(true);

        $client = static::createClient();
        $client->request('POST', '/');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
