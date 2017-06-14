<?php

namespace App\Model;

use Illuminate\Http\Request;

/**
 * Class to use for filtering an pagination
 *
 * @package App\Model
 */
class ListingParameters
{
    const DEFAULT_PAGE = 0;
    const DEFAULT_PAGE_SIZE = 10;

    /** @var int */
    private $pageSize;

    /** @var int */
    private $page;

    /** @var array */
    private $criteria = [];

    /**
     * Create a listing parameter from a Request object
     *
     * @param Request $request
     * @return ListingParameters
     */
    public static function createFromRequest(Request $request): ListingParameters
    {
        $listingParameters = new self();
        $listingParameters
            ->setPage($request->get('page', static::DEFAULT_PAGE))
            ->setPageSize($request->get('pageSize', static::DEFAULT_PAGE_SIZE))
            ->setCriteria($request->get('criteria', []));

        return $listingParameters;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     * @return ListingParameters
     */
    public function setPageSize($pageSize): ListingParameters
    {
        $pageSize = (int) $pageSize;

        if ($pageSize < 1) {
            $pageSize = static::DEFAULT_PAGE_SIZE;
        }

        $this->pageSize = $pageSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return ListingParameters
     */
    public function setPage($page): ListingParameters
    {
        $page = (int) $page;

        if ($page < 0) {
            $page = static::DEFAULT_PAGE;
        }

        $this->page = $page;

        return $this;
    }

    /**
     * @return array
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    /**
     * @param array $criteria
     * @return ListingParameters
     */
    public function setCriteria($criteria): ListingParameters
    {
        if (!is_array($criteria)) {
            $criteria = [];
        }
        $this->criteria = $criteria;

        return $this;
    }
}