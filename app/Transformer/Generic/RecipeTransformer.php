<?php

namespace App\Transformer\Generic;

use App\Model\Recipe;
use League\Fractal\TransformerAbstract;

class RecipeTransformer extends TransformerAbstract
{
    public function transform(Recipe $recipe)
    {
        return [
            'id' => $recipe->getId(),
            'title' => $recipe->getTitle(),
            'description' => $recipe->getMarketingDescription(),
            'calories' => $recipe->getCaloriesKcal(),
            'protein' => $recipe->getProteinGrams(),
            'fat' => $recipe->getFatGrams(),
            'carbohydrates' => $recipe->getCarbsGrams(),
        ];
    }
}