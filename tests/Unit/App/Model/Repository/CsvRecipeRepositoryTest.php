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

    public function testFindNotFound()
    {
        $recipeNotFound = $this->csvRepository->find(100);
        $this->assertNull($recipeNotFound);
    }

    /**
     * @param array $criteria
     * @param int $page
     * @param int $pageSize
     * @param array $expectedTitles
     *
     * @dataProvider filterAndPaginationProvider
     */
    public function testFindByFilterAndPaginate(array $criteria, int $page, int $pageSize, array $expectedTitles)
    {
        $recipes = $this->csvRepository->findBy($criteria, $page, $pageSize);

        $this->assertInternalType('array', $recipes);
        $this->assertCount($pageSize, $recipes);
        reset($recipes);
        foreach ($expectedTitles as $expectedTitle) {
            $recipe = current($recipes);
            $this->assertEquals($expectedTitle, $recipe->getTitle());
            next($recipes);
        }
    }

    /**
     * Data provider for filter and pagination tests
     *
     * @return array
     */
    public function filterAndPaginationProvider(): array
    {
        return [
            'first_page' => [
                'criteria' => [
                    'recipe_cuisine' => 'asian',
                ],
                'page' => 0,
                'pageSize' => 1,
                'expectedTitles' => ['My Recipe'],
            ],
            'second_page' => [
                'criteria' => [
                    'recipe_cuisine' => 'asian',
                ],
                'page' => 1,
                'pageSize' => 1,
                'expectedTitles' => ['My Recipe 4'],
            ],
            'no_filter_first_page' => [
                'criteria' => [],
                'page' => 0,
                'pageSize' => 2,
                'expectedTitles' => ['My Recipe', 'My Recipe 2'],
            ],
        ];
    }
}
