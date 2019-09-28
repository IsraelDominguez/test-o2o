<?php


namespace App\Domain\Model;


class Recipe
{

    protected $title = '';

    protected $href = '';

    protected $ingredients = [];

    protected $thumbnail = '';

    /**
     * Recipe constructor.
     * @param string $title
     * @param string $href
     * @param array $ingredients
     * @param string $thumbnail
     */
    public function __construct(string $title, string $href, array $ingredients, string $thumbnail)
    {
        $this->title = $title;
        $this->href = $href;
        $this->ingredients = $ingredients;
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

}