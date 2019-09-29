<?php

namespace App\Tests\Application\Service;

use App\Application\Service\SearchRecipesByIngredients;
use App\Domain\Model\Recipe;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyParamsConverter;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyRepository;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyResponseConverter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchRecipesByIngredientsTest extends WebTestCase
{
    protected $searchService;

    public function setUp() {
        self::bootKernel();

        $repository = new RecipePuppyRepository(self::$container->get('logger'), new RecipePuppyParamsConverter(), new RecipePuppyResponseConverter());

        $this->searchService = new SearchRecipesByIngredients($repository);
    }

    public function testSearchIngredients() {
        $recipes = $this->searchService->search(['pesto']);

        $this->assertTrue(is_array($recipes));
        $this->assertEquals(10, count($recipes));

        $this->assertInstanceOf(Recipe::class, $recipes[0]);

        // Check all Recipes constains the searched ingredients
        array_map(function (Recipe $recipe) {
            $this->assertContains('pesto', implode(',',$recipe->getIngredients()));
        }, $recipes);
    }

    public function testSearchMultipleIngredients() {
        $recipes = $this->searchService->search(['pesto','garlic']);

        $this->assertTrue(is_array($recipes));
        $this->assertEquals(10, count($recipes));

        $this->assertInstanceOf(Recipe::class, $recipes[0]);

        // Check all Recipes constains the searched ingredients
        array_map(function (Recipe $recipe) {
            $ingredients = implode(',',$recipe->getIngredients());
            $this->assertContains('pesto', $ingredients);
            $this->assertContains('garlic', $ingredients);
        }, $recipes);
    }
}