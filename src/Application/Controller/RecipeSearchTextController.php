<?php

namespace App\Application\Controller;

use App\Application\Service\SearchRecipesByText;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecipeSearchTextController extends AbstractController
{

    /**
     * @Route("/recipe/search/{text}", name="search_by_text", methods={"GET"})
     */
    public function search(string $text, SearchRecipesByText $searchByText)
    {
        $data = $searchByText->search($text);

        return $this->json(['recipes'=>$data]);
    }

}
