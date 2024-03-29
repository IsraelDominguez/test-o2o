<?php

namespace App\Application\Service;

use App\Domain\Model\RecipeRepository;
use App\Domain\RecipeSearchCriteria;

class SearchRecipesByText
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
     * Search recipes by text in title
     *
     * @param string $text
     * @return array list of Recipes
     */
    public function search(string $text)
    {
        return $this->repository->search(RecipeSearchCriteria::instance()->setText($text));
    }

}