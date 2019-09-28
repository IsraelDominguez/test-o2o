<?php

namespace App\Domain;

/**
 * Value Object for search criterias
 *
 * Class RecipeSearchCriteria
 * @package App\Domain
 */
class RecipeSearchCriteria
{

    /**
     * @var string
     */
    protected $text;

    /**
     * @var array
     */
    protected $ingredients = [];

    /**
     * @var int
     */
    protected $page;

    /**
     * SearchCriteria constructor.
     */
    public function __construct()
    {

    }

    /**
     * Static search criteria factory
     * @return RecipeSearchCriteria
     */
    public static function instance() {
        return new RecipeSearchCriteria();
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return SearchCriteria
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return array
     */
    public function getIngredients(): ?array
    {
        return $this->ingredients;
    }

    /**
     * @param array $ingredients
     * @return SearchCriteria
     */
    public function setIngredients(array $ingredients): RecipeSearchCriteria
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return SearchCriteria
     */
    public function setPage(int $page): RecipeSearchCriteria
    {
        $this->page = $page;
        return $this;
    }
}