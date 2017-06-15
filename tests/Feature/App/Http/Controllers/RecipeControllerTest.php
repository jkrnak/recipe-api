<?php

namespace tests\Feature\App\Http\Controllers;

use App\Model\Repository\CsvRecipeRepository;
use App\Model\Repository\RecipeRepositoryInterface;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $fixturePath = $this->app['config']->get('app')['csv_path'];
        $fixtureDir = dirname($fixturePath);
        $tempFixturePath = tempnam($fixtureDir, 'controller_test_');
        copy($fixturePath, $tempFixturePath);

        $this->app->singleton(RecipeRepositoryInterface::class, function ($app) use ($tempFixturePath) {
            return new CsvRecipeRepository($tempFixturePath);
        });
    }

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

    public function testCreateRecipe()
    {
        $response = $this->json('POST', '/api/recipe', [
            'title' => 'New Recipe',
            'description' => 'Some Some',
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => 5,
                    'title' => 'New Recipe',
                    'description' => 'Some Some',
                    'calories' => '',
                    'protein' => '',
                    'fat' => '',
                    'carbohydrates' => '',
                ]
            ]);
    }

    public function testUpdateRecipe()
    {
        $response = $this->json('PUT', '/api/recipe/1', [
            'title' => 'Updating Title',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'title' => 'Updating Title',
                    'description' => 'fancy description',
                    'calories' => 400,
                    'protein' => 10,
                    'fat' => 30,
                    'carbohydrates' => 10,
                ]
            ]);
    }

    public function testUpdateNonExistingRecipe()
    {
        $response = $this->json('PUT', '/api/recipe/100', [
            'title' => 'Updating Title',
        ]);

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

    public function testRateRecipe()
    {
        $response = $this->json('PUT', '/api/recipe/1/rate', [
            'rating' => 5,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'title' => 'My Recipe',
                    'average_rating' => 5,
                    'rating_count' => 1,
                ]
            ]);

        $response = $this->json('PUT', '/api/recipe/1/rate', [
            'rating' => 4,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'average_rating' => 4.5,
                    'rating_count' => 2,
                ]
            ]);
    }

    public function testRateNonExistingRecipe()
    {
        $response = $this->json('PUT', '/api/recipe/100/rate', [
            'rate' => 5,
        ]);

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

    public function testInvalidRate()
    {
        $response = $this->json('PUT', '/api/recipe/1/rate', [
            'rating' => 0,
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => [
                    'code' => 'GEN-WRONG-ARGS',
                    'http_code' => 400,
                    'message' => [
                        'rating' => ['The rating must be at least 1.'],
                    ]
                ]
            ]);

        $response = $this->json('PUT', '/api/recipe/1/rate', [
            'rating' => 6,
        ]);

        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => [
                    'code' => 'GEN-WRONG-ARGS',
                    'http_code' => 400,
                    'message' => [
                        'rating' => ['The rating may not be greater than 5.'],
                    ]
                ]
            ]);

        $response = $this->json('PUT', '/api/recipe/1/rate');
        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => [
                    'message' => [
                        'rating' => ['The rating field is required.'],
                    ]
                ]
            ]);
    }


    protected function tearDown()
    {
        $fixturePath = $this->app['config']->get('app')['csv_path'];
        $fixtureDir = dirname($fixturePath);
        foreach (glob($fixtureDir . '/controller_test_*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        parent::tearDown();
    }
}
