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

    /**
     * @param array $criteria
     * @param int $page Zero based
     * @param int $pageSize
     * @return Recipe[]
     */
    public function findBy(array $criteria = [], int $page = 0, int $pageSize = 10): array;
}