<?php

namespace Tests\Unit\App\Model\Repository;

use App\Model\Recipe;
use App\Model\Repository\CsvRecipeRepository;
use Tests\TestCase;

class CsvRecipeRepositoryTest extends TestCase
{
    /** @var CsvRecipeRepository */
    private $csvRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->csvRepository = new CsvRecipeRepository(base_path('/tests/Fixtures/recipe-data.csv'));
    }

    public function testFind()
    {
        $recipe = $this->csvRepository->find(1);

        $this->assertInstanceOf(Recipe::class, $recipe);
        $this->assertEquals(1, $recipe->getId());
    }
}