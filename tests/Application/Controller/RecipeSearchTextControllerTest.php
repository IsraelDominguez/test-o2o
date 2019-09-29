<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeSearchTextControllerTest extends WebTestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testRecipeSearchTextNotPostMethod()
    {
        $this->client->request('POST', '/recipe/searchByTitle');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testMandatorySearchText() {
        $this->client->request('GET', '/recipe/searchByTitle');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testSearchText() {
        $this->client->request('GET', '/recipe/searchByTitle/pesto');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('content-type'));

        $this->arrayHasKey('recipes', $response);
    }
}