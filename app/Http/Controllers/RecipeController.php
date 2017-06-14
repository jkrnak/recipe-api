<?php

namespace App\Http\Controllers;

use App\Model\ListingParameters;
use App\Model\Repository\RecipeRepositoryInterface;
use App\Transformer\Generic\RecipeTransformer;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;

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

    public function list(Request $request)
    {
        $listingParameters = ListingParameters::createFromRequest($request);

        $recipes = $this->recipeRepository->findBy(
            $listingParameters->getCriteria(),
            $listingParameters->getPage(),
            $listingParameters->getPageSize()
        );

        return $this->response->withCollection($recipes, new RecipeTransformer());
    }
}
