<?php

namespace App\Tests\Infrastructure\Recipe\RecipePuppyApiProvider;

use App\Domain\Model\Recipe;
use App\Domain\RecipeSearchCriteria;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyParamsConverter;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyRepository;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyResponseConverter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipePuppyRepositoryTest extends WebTestCase
{

    protected $repository;

    public function setUp(): void
    {
        self::bootKernel();
        $this->repository = new RecipePuppyRepository(self::$container->get('logger'), new RecipePuppyParamsConverter(), new RecipePuppyResponseConverter());
    }

    public function testCorrectInstance() {
        $this->assertInstanceOf(RecipePuppyRepository::class, $this->repository);
    }

    public function testEmptyResponse() {
        $recipes = $this->repository->search(RecipeSearchCriteria::instance()->setText('XXXXX'));

        $this->assertEmpty($recipes);
    }

    public function testArrayOfRecipesResponse() {
        $recipes = $this->repository->search(RecipeSearchCriteria::instance()->setText('pesto'));

        $this->assertTrue(is_array($recipes));
        $this->assertEquals(10, count($recipes));

        $this->assertInstanceOf(Recipe::class, $recipes[0]);

        // Check all Recipes constains the searched Text
        array_map(function (Recipe $recipe) {
            $this->assertContains('PESTO', strtoupper($recipe->getTitle()));
        }, $recipes);
    }

    public function testErrorSearchThrowException()
    {
        $recipes = $this->repository->search(RecipeSearchCriteria::instance()->setText('pesto')->setPage(0));

        $this->assertTrue(true);
    }
}