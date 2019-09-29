<?php

namespace App\Infrastructure\Recipe\RecipePuppyApiProvider;

use App\Domain\RecipeSearchCriteria;

final class RecipePuppyParamsConverter
{
    public function transform(RecipeSearchCriteria $searchCriteria): array
    {
        $q = $searchCriteria->getText() ?? null;
        $i = ($searchCriteria->getIngredients()) ?  implode(',', $searchCriteria->getIngredients()) : null;
        $p = $searchCriteria->getPage() ?? null;  '';

        return compact('q','p', 'i');
    }
}