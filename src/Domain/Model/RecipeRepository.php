<?php

namespace App\Domain\Model;

use App\Domain\RecipeSearchCriteria;

interface RecipeRepository
{
    /**
     * @param SearchCriteria $searchCriteria
     * @return array
     */
    public function search(RecipeSearchCriteria $searchCriteria);
}