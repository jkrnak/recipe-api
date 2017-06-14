<?php

namespace App\Http\Controllers;

use App\Model\Repository\RecipeRepositoryInterface;
use App\Transformer\Generic\RecipeTransformer;
use EllipseSynergie\ApiResponse\Contracts\Response;

class RecipeController extends Controller
{
    /** @var Response */
    private $response;

    /** @var RecipeRepositoryInterface */
    private $recipeRepository;


    public function __construct(Response $response, RecipeRepositoryInterface $recipeRepository)
    {
        $this->response = $response;
        $this->recipeRepository = $recipeRepository;
    }

    public function show($id)
    {
        $recipe = $this->recipeRepository->find($id);

        if (!$recipe) {
            return $this->response->errorNotFound('Recipe Not Found');
        }

        return $this->response->withItem($recipe, new RecipeTransformer());
    }

}
