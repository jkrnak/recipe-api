<?php

namespace App\Model\Repository;

use App\Model\Recipe;

/**
 * Defines a repository class to interact with a recipe storage layer
 */
interface RecipeRepositoryInterface
{
    /**
     * @param int $id
     * @return Recipe|null
     */
    public function find(int $id): ?Recipe;
}