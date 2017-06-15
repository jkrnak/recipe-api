<?php

namespace App\Transformer\Generic;

use App\Model\Recipe;
use App\Transformer\RecipeTransformerInterface;
use League\Fractal\TransformerAbstract;

class RecipeTransformer extends TransformerAbstract implements RecipeTransformerInterface
{
    private static $fieldToPropertyMap = [
        'title' => 'Title',
        'description' => 'MarketingDescription',
        'carbohydrates' => 'CarbsGrams',
        'fat' => 'FatGrams',
        'protein' => 'ProteinGrams',
        'calories' => 'CaloriesKcal',
        'gousto_reference' => 'GoustoReference',
        'in_your_box' => 'InYourBox',
        'recipe_cuisine' => 'RecipeCuisine',
        'origin_country' => 'OriginCountry',
        'equipment_needed' => 'EquipmentNeeded',
        'shelf_life_days' => 'ShelfLifeDays',
        'preparation_time_minutes' => 'PreparationTimeMinutes',
        'protein_source' => 'ProteinSource',
        'base' => 'Base',
        'season' => 'Season',
        'recipe_diet_type_id' => 'RecipeDietTypeId',
        'bulletpoint1' => 'Bulletpoint1',
        'bulletpoint2' => 'Bulletpoint2',
        'bulletpoint3' => 'Bulletpoint3',
        'short_title' => 'ShortTitle',
        'slug' => 'Slug',
        'box_type' => 'BoxType',
        'updated_at' => 'UpdatedAt',
        'created_at' => 'CreatedAt',
    ];

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
            'average_rating' => $recipe->getAverageRating(),
            'rating_count' => $recipe->getRatingCount(),
        ];
    }

    public function reverseTransform(array $source, Recipe $recipe = null): Recipe
    {
        if (is_null($recipe)) {
            $recipe = new Recipe();
        }

        foreach ($source as $field => $value) {
            if (!isset(static::$fieldToPropertyMap[$field])) {
                continue;
            }

            $method = 'set' . static::$fieldToPropertyMap[$field];
            $recipe->$method($value);
        }

        return $recipe;
    }
}
