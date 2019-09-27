<?php

namespace App\Application\Service;

use App\Domain\Model\RecipeRepository;
use App\Domain\SearchCriteria;

class SearchRecipesByText
{

    /**
     * @var  $repository
     */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        dd($repository);
        $this->repository = $repository;
    }

    /**

     * @return array
     */
    public function search(string $text)
    {
        return $this->repository->findByText(SearchCriteria::instance()->setText($text));
    }

}