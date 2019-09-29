<?php

namespace App\Tests\Application\Service;

use App\Application\Service\SearchRecipesByText;
use App\Domain\Model\Recipe;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyParamsConverter;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyRepository;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyResponseConverter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchRecipesByTextTest extends WebTestCase
{
    protected $searchService;

    public function setUp() {
        self::bootKernel();

        $repository = new RecipePuppyRepository(self::$container->get('logger'), new RecipePuppyParamsConverter(), new RecipePuppyResponseConverter());

        $this->searchService = new SearchRecipesByText($repository);
    }

    public function testSearch() {
        $recipes = $this->searchService->search('pesto');

        $this->assertTrue(is_array($recipes));
        $this->assertEquals(10, count($recipes));

        $this->assertInstanceOf(Recipe::class, $recipes[0]);

        // Check all Recipes constains the searched Text
        array_map(function (Recipe $recipe) {
            $this->assertContains('PESTO', strtoupper($recipe->getTitle()));
        }, $recipes);
    }
}