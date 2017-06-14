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
}