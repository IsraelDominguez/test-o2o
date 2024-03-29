<?php

namespace App\Infrastructure\Recipe\RecipePuppyApiProvider;

use App\Domain\Model\Recipe;

final class RecipePuppyResponseConverter
{

    /**
     * @param array $puppyResponse
     * @return Recipe
     */
    public function transform(array $puppyResponse) : Recipe
    {
        return new Recipe(
            $puppyResponse["title"] ?? '',
            $puppyResponse["href"] ?? '',
            isset($puppyResponse["ingredients"]) ? explode(", ", trim($puppyResponse["ingredients"])) : [],
            $puppyResponse["thumbnail"] ?? '');
    }
}