<?php

namespace App\Transformer;

use App\Model\Recipe;

interface RecipeTransformerInterface
{
    public function transform(Recipe $recipe);

    public function reverseTransform(array $source, ?Recipe $recipe): Recipe;
}
