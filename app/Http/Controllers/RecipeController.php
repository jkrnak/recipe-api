<?php

namespace App\Http\Controllers;

use App\Model\ListingParameters;
use App\Model\Repository\RecipeRepositoryInterface;
use App\Transformer\RecipeTransformerInterface;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Validation\ValidationException;

class RecipeController extends Controller
{
    /** @var Response */
    private $response;

    /** @var RecipeRepositoryInterface */
    private $recipeRepository;

    /** @var RecipeTransformerInterface */
    private $transformer;

    public function __construct(
        Response $response,
        RecipeRepositoryInterface $recipeRepository,
        RecipeTransformerInterface $transformer
    ) {
        $this->response = $response;
        $this->recipeRepository = $recipeRepository;
        $this->transformer = $transformer;
    }

    public function show($id)
    {
        $recipe = $this->recipeRepository->find($id);

        if (!$recipe) {
            return $this->response->errorNotFound('Recipe Not Found');
        }

        return $this->response->withItem($recipe, $this->transformer);
    }

    public function list(Request $request)
    {
        $listingParameters = ListingParameters::createFromRequest($request);

        $recipes = $this->recipeRepository->findBy(
            $listingParameters->getCriteria(),
            $listingParameters->getPage(),
            $listingParameters->getPageSize()
        );

        return $this->response->withCollection($recipes, $this->transformer);
    }

    public function store(Request $request, $id = null)
    {
        $recipe = null;
        $successResponseCode = IlluminateResponse::HTTP_CREATED;
        if (!is_null($id)) {
            $recipe = $this->recipeRepository->find($id);

            if (!$recipe) {
                return $this->response->errorNotFound('Recipe Not Found');
            }

            $successResponseCode = IlluminateResponse::HTTP_OK;
        }

        $recipe = $this->transformer->reverseTransform($request->json()->all(), $recipe);

        $this->recipeRepository->save($recipe);

        return $this->response
            ->setStatusCode($successResponseCode)
            ->withItem($recipe, $this->transformer);
    }

    public function rate(Request $request, $id)
    {
        $recipe = $this->recipeRepository->find($id);

        if (!$recipe) {
            return $this->response->errorNotFound('Recipe Not Found');
        }

        try {
            $this->validate($request, [
                'rating' => 'required|numeric|min:1|max:5',
            ]);
        } catch (ValidationException $e) {
            return $this->response->errorWrongArgs($e->validator->getMessageBag()->toArray());
        }

        $recipe->addRating($request->json('rating'));

        $this->recipeRepository->save($recipe);

        return $this->response
            ->setStatusCode(IlluminateResponse::HTTP_OK)
            ->withItem($recipe, $this->transformer);
    }
}
