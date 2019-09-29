<?php

namespace App\Tests\Application\Service;

use App\Application\Service\SearchRecipes;
use App\Domain\Model\Recipe;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyParamsConverter;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyRepository;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyResponseConverter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchRecipesFullSearchTest extends WebTestCase
{
    protected $searchService;

    public function setUp() {
        self::bootKernel();

        $repository = new RecipePuppyRepository(self::$container->get('logger'), new RecipePuppyParamsConverter(), new RecipePuppyResponseConverter());

        $this->searchService = new SearchRecipes($repository);
    }

    public function testFullSearch() {
        $recipes = $this->searchService->search('pesto', ['garlic'], 1);

        $this->assertTrue(is_array($recipes));
        $this->assertEquals(10, count($recipes));

        $this->assertInstanceOf(Recipe::class, $recipes[0]);

        // Check all Recipes constains the searched Text and ingredients
        array_map(function (Recipe $recipe) {
            $this->assertContains('PESTO', strtoupper($recipe->getTitle()));
            $this->assertContains('garlic', implode(',',$recipe->getIngredients()));
        }, $recipes);
    }
}