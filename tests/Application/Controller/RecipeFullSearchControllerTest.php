<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RecipeFullSearchControllerTest extends WebTestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testSearchText() {
        $this->client->request('GET', '/recipe/search?text=pesto&ingredients=pesto,garlic&page=1');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('content-type'));

        $this->arrayHasKey('recipes', $response);
    }

    public function testShowInvalidParams() {
        $this->client->request('GET', '/recipe/search?page=0');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }
}