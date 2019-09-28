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

     * @return array
     */
    public function search(string $text)
    {
        return $this->repository->findByText(RecipeSearchCriteria::instance()->setText($text));
    }

}