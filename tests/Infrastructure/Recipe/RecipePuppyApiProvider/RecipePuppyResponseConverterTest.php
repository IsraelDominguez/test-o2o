<?php

namespace App\Tests\Infrastructure\Recipe\RecipePuppyApiProvider;

use App\Domain\Model\Recipe;
use App\Infrastructure\Recipe\RecipePuppyApiProvider\RecipePuppyResponseConverter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipePuppyResponseConverterTest extends WebTestCase
{
    public function testReturnInstanceOfRecipe() {
        $converter = new RecipePuppyResponseConverter();
        $array_recipe = [
            'title' => 'One Title',
            'href' => 'One Url',
            'ingredients' => 'ingredient1, ingredient2',
            'thumbnail' => 'Image Url'
        ];

        $recipe = $converter->transform($array_recipe);

        $this->assertInstanceOf(Recipe::class, $recipe);

        $this->assertEquals('One Title', $recipe->getTitle());
    }

    public function testReturnInstanceWithNotCorrectArrayConverter() {
        $converter = new RecipePuppyResponseConverter();
        $array_recipe = [
            'title' => 'One Title',
            'thumbnail' => 'Image Url'
        ];

        $this->assertInstanceOf(Recipe::class, $converter->transform($array_recipe));
    }
}