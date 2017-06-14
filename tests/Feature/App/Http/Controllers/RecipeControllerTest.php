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
        $response = $this->json('GET', '/api/recipe/2');

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

}