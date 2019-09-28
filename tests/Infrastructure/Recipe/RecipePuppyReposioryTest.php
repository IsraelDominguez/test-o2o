<?php

namespace App\Tests\Infrastructure\Recipe;

use App\Domain\Model\Recipe;
use App\Domain\RecipeSearchCriteria;
use App\Infrastructure\Recipe\RecipePuppyParamsConverter;
use App\Infrastructure\Recipe\RecipePuppyRepository;
use App\Infrastructure\Recipe\RecipePuppyResponseConverter;
use GuzzleHttp\ClientInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipePuppyRepositoryTest extends WebTestCase
{

    protected $repository;

    public function setUp(): void
    {
        self::bootKernel();

        $this->repository = new RecipePuppyRepository(self::$container->get('logger'), new RecipePuppyParamsConverter(), new RecipePuppyResponseConverter());
        //$container = self::$kernel->getContainer();
    }

    public function testCorrectInstance() {
        $this->assertInstanceOf(RecipePuppyRepository::class, $this->repository);
    }

    public function testEmptyResponse() {
        $recipes = $this->repository->findByText(RecipeSearchCriteria::instance()->setText('XXXXX'));

        $this->assertEmpty($recipes);
    }

    public function testArrayOfRecipesResponse() {
        $recipes = $this->repository->findByText(RecipeSearchCriteria::instance()->setText('pesto'));

        $this->assertTrue(is_array($recipes));
        $this->assertEquals(10, count($recipes));

        $this->assertInstanceOf(Recipe::class, $recipes[0]);

        // Check all Recipes constains the searched Text
        array_map(function (Recipe $recipe) {
            $this->assertContains('PESTO', strtoupper($recipe->getTitle()));
        }, $recipes);
    }
}