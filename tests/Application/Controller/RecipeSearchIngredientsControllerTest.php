<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testMandatorySearchIngredients() {
        $this->client->request('GET', '/recipe/ingredients');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testSearchText() {
        $this->client->request('GET', '/recipe/ingredients/pesto');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('content-type'));

        $this->arrayHasKey('recipes', $response);
    }
}