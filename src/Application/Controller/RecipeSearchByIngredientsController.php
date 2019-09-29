<?php

namespace App\Application\Controller;

use App\Application\Service\SearchRecipesByIngredients;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeSearchByIngredientsController extends AbstractController
{

    /**
     * @Route("/recipe/ingredients/{ingredients}", name="search_by_ingredients", methods={"GET"})
     */
    public function search(string $ingredients, SearchRecipesByIngredients $searchRecipes)
    {
        try {
            if (empty(trim($ingredients)))
                throw new \Exception('Invalid Params');

            $data = $searchRecipes->search(str_word_count($ingredients,1));

        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json(['recipes' => $data]);
    }

}
