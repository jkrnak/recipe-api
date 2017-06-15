<?php

namespace tests\Unit\App\Transformer\Generic;

use App\Model\Recipe;
use App\Transformer\Generic\RecipeTransformer;
use Tests\TestCase;

class RecipeTransformerTest extends TestCase
{
    public function testTransform()
    {
        $recipe = new Recipe();
        $recipe->setId(1)
            ->setTitle('My Recipe')
            ->setMarketingDescription('some description')
            ->setCaloriesKcal(100)
            ->setFatGrams(200)
            ->setProteinGrams(250)
            ->setCarbsGrams(120);

        $expectedTransformation = [
            'id' => 1,
            'title' => 'My Recipe',
            'description' => 'some description',
            'calories' => 100,
            'fat' => 200,
            'protein' => 250,
            'carbohydrates' => 120,
        ];

        $transformer = new RecipeTransformer();

        $this->assertEquals($expectedTransformation, $transformer->transform($recipe));
    }

    public function testCreateRecipe()
    {
        $recipeAsArray = [
            'title' => 'My Recipe',
            'description' => 'some description',
            'calories' => 100,
            'fat' => 200,
            'protein' => 250,
            'carbohydrates' => 120,
            'box_type' => 'vegeterian',
            'slug' => 'my-recipe',
            'short_title' => '',
            'bulletpoint1' => 'point 1',
            'bulletpoint2' => 'point 2',
            'bulletpoint3' => 'point 3',
            'recipe_diet_type_id' => 'meat',
            'season' => 'summer',
            'base' => 'rice',
            'protein_source' => 'chicken',
            'preparation_time_minutes' => 30,
            'shelf_life_days' => 3,
            'equipment_needed' => 'kitchen',
            'origin_country' => 'UK',
            'recipe_cuisine' => 'French',
            'in_your_box' => [
                'chicken',
                'rice'
            ],
            'gousto_reference' => 42,
        ];

        $transformer = new RecipeTransformer();
        $recipe = $transformer->reverseTransform($recipeAsArray);

        $this->assertEquals('My Recipe', $recipe->getTitle());
        $this->assertEquals('some description', $recipe->getMarketingDescription());
        $this->assertEquals(100, $recipe->getCaloriesKcal());
        $this->assertEquals(200, $recipe->getFatGrams());
        $this->assertEquals(250, $recipe->getProteinGrams());
        $this->assertEquals(120, $recipe->getCarbsGrams());
        $this->assertEquals('vegeterian', $recipe->getBoxType());
        $this->assertEquals('my-recipe', $recipe->getSlug());
        $this->assertEquals('point 1', $recipe->getBulletpoint1());
        $this->assertEquals('point 2', $recipe->getBulletpoint2());
        $this->assertEquals('point 3', $recipe->getBulletpoint3());
        $this->assertEquals('meat', $recipe->getRecipeDietTypeId());
        $this->assertEquals('summer', $recipe->getSeason());
        $this->assertEquals('rice', $recipe->getBase());
        $this->assertEquals('chicken', $recipe->getProteinSource());
        $this->assertEquals(30, $recipe->getPreparationTimeMinutes());
        $this->assertEquals(3, $recipe->getShelfLifeDays());
        $this->assertEquals('kitchen', $recipe->getEquipmentNeeded());
        $this->assertEquals('UK', $recipe->getOriginCountry());
        $this->assertEquals(['chicken', 'rice'], $recipe->getInYourBox());
        $this->assertEquals(42, $recipe->getGoustoReference());
    }
}
