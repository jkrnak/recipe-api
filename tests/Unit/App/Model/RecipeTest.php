<?php

namespace tests\Unit\App\Model;

use App\Model\Recipe;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    public function testRating()
    {
        $recipe = new Recipe();
        $recipe->addRating(5);

        $this->assertEquals(5, $recipe->getAverageRating());
        $this->assertEquals(1, $recipe->getRatingCount());

        $recipe->addRating(4);

        $this->assertEquals(4.5, $recipe->getAverageRating());
        $this->assertEquals(2, $recipe->getRatingCount());

        $recipe->addRating(1);

        $this->assertEquals(3.3, $recipe->getAverageRating());
        $this->assertEquals(3, $recipe->getRatingCount());
    }
}
