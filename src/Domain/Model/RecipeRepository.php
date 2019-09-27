<?php

namespace App\Domain\Model;

use App\Domain\SearchCriteria;

interface RecipeRepository
{
    public function findByText(SearchCriteria $searchCriteria);
}