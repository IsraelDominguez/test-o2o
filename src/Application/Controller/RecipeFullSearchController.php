<?php

namespace App\Application\Controller;

use App\Application\Service\SearchRecipes;
use App\Application\Service\ValidateFullSearchTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeFullSearchController extends AbstractController
{
    use ValidateFullSearchTrait;
    /**
     * @Route("/recipe/search", name="full_search", methods={"GET"})
     */
    public function search(Request $request, SearchRecipes $searchRecipes)
    {
        try {
            $text = $request->query->get('text', '');
            $ingredients = $request->query->get('ingredients','');
            $page = (int) $request->query->get('page', 1);

            $this->validate($text, $ingredients, $page);

            $data = $searchRecipes->search(
                $text,
                str_word_count($ingredients,1),
                $page
            );
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json(['recipes' => $data]);
    }

}
