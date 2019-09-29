<?php

namespace App\Tests\Infrastructure\Recipe\RecipePuppyApiProvider;

use App\Domain\RecipeSearchCriteria;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyParamsConverter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipePuppyParamsConverterTest extends WebTestCase
{
    public function testCorrectTextParamsConverter() {
        $criteria = RecipeSearchCriteria::instance()->setText('pesto');

        $paramsConverter = new RecipePuppyParamsConverter();
        $params = $paramsConverter->transform($criteria);

        $this->assertArrayHasKey('q', $params);
        $this->assertEquals('pesto', $params['q']);
    }

    public function testCorrectIngredientsParamsConverter() {
        $criteria = RecipeSearchCriteria::instance()->setIngredients(['pesto, garlic']);

        $paramsConverter = new RecipePuppyParamsConverter();
        $params = $paramsConverter->transform($criteria);

        $this->assertArrayHasKey('i', $params);
        $this->assertEquals('pesto, garlic', $params['i']);
    }

    public function testCorrectPageParamsConverter() {
        $criteria = RecipeSearchCriteria::instance()->setPage(3);

        $paramsConverter = new RecipePuppyParamsConverter();
        $params = $paramsConverter->transform($criteria);

        $this->assertArrayHasKey('p', $params);
        $this->assertEquals(3, $params['p']);
    }
}