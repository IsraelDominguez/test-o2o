<?php

namespace App\Application\Service;

use App\Domain\Model\RecipeRepository;
use App\Domain\RecipeSearchCriteria;

class SearchRecipes
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
     * Search by all params
     *
     * @param string $text
     * @param array $ingredients
     * @param int $page
     * @return array
     */
    public function search(string $text, array $ingredients, int $page)
    {
        return $this->repository->search(RecipeSearchCriteria::instance()->setText($text)->setIngredients($ingredients)->setPage($page));
    }

}