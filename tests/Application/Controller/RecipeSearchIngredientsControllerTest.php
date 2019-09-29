<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RecipeSearchByIngredientsControllerTest extends WebTestCase
{
    protected $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testRecipeSearchIngredientsNotPostMethod()
    {
        $this->client->request('POST', '/recipe/ingredients');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testMandatorySearchIngredients() {
        $this->client->request('GET', '/recipe/ingredients');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testSearchText() {
        $this->client->request('GET', '/recipe/ingredients/pesto');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('content-type'));

        $this->arrayHasKey('recipes', $response);
    }

    public function testInvalidIngredientsParams() {
        $this->client->request('GET', '/recipe/ingredients/ ');
        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

    }
}