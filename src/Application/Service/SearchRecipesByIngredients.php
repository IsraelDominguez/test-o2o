<?php

namespace App\Application\Service;

use App\Domain\Model\RecipeRepository;
use App\Domain\RecipeSearchCriteria;

class SearchRecipesByIngredients
{

    /**
     * @var  $repository
     */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Search by list of ingredients
     *
     * @param array $text
     * @return mixed
     */
    public function search(array $ingredients)
    {
        return $this->repository->search(RecipeSearchCriteria::instance()->setIngredients($ingredients));
    }

}