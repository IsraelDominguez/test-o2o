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
        $ingredients = explode(',', $ingredients);

        if (is_array($ingredients)) {
            $data = $searchRecipes->search($ingredients);

            return $this->json(['recipes'=>$data]);
        } else {
            return $this->json(['error'=>'invalid params'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

}
