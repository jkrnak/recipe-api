<?php

namespace tests\Feature\App\Http\Controllers;

use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    public function testFetchingRecipeByIdFound()
    {
        $response = $this->json('GET', '/api/recipe/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'title' => 'My Recipe',
                    'description' => 'fancy description',
                    'calories' => 400,
                    'protein' => 10,
                    'fat' => 30,
                    'carbohydrates' => 10,
                ]
            ]);
    }

    public function testFetchingRecipeByIdNotFound()
    {
        $response = $this->json('GET', '/api/recipe/100');

        $response
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'code' => 'GEN-NOT-FOUND',
                    'http_code' => 404,
                    'message' => 'Recipe Not Found',
                ]
            ]);
    }

    public function testFetching()
    {
        $response = $this->json('GET', '/api/recipe?page=0&pageSize=2&criteria[recipe_cuisine]=asian');

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => 1,
                        'title' => 'My Recipe',
                        'description' => 'fancy description',
                        'calories' => 400,
                        'protein' => 10,
                        'fat' => 30,
                        'carbohydrates' => 10,
                    ],
                    [
                        'id' => 4,
                        'title' => 'My Recipe 4',
                        'description' => 'fancy description',
                        'calories' => 403,
                        'protein' => 13,
                        'fat' => 33,
                        'carbohydrates' => 13,
                    ]
                ]
            ]);
    }

}