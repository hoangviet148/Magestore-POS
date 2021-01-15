<?php

namespace Learning\Pos\Api;

use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ProductRepositoryInterface
{
    /**
     * Get product list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ProductSearchResultsInterface
     */
    function getList(SearchCriteriaInterface $searchCriteria);
}
