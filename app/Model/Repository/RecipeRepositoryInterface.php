<?php

namespace App\Model\Repository;

use App\Model\Recipe;

/**
 * Defines a repository class to interact with a recipe storage layer
 */
interface RecipeRepositoryInterface
{
    /**
     * Find recipe by id
     *
     * @param int $id
     * @return Recipe|null
     */
    public function find(int $id): ?Recipe;

    /**
     * Find recipes by criteria
     *
     * @param array $criteria
     * @param int $page Zero based
     * @param int $pageSize
     * @return Recipe[]
     */
    public function findBy(array $criteria = [], int $page = 0, int $pageSize = 10): array;

    /**
     * Save a recipe
     *
     * @param Recipe $recipe
     */
    public function save(Recipe $recipe);
}
