<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Seller;

use Magento\Framework\Api\SortOrder;

/**
 * Block Index (list)
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Index extends AbstractBlock
{
    /**
     * Get the current seller
     *
     * @return \Training\Seller\Api\Data\SellerSearchResultsInterface
     */
    public function getSearchResult()
    {
        return $this->registry->registry('seller_search_result');
    }

    /**
     * Get the number of results
     *
     * @return int
     */
    public function getCount()
    {
        $searchResult = $this->getSearchResult();

        return $searchResult->getTotalCount();
    }

    /**
     * Get the name filter
     *
     * @return string
     */
    public function getSearchName()
    {
        $default = '';

        $searchCriteria = $this->getSearchResult()->getSearchCriteria();
        if (is_null($searchCriteria)) {
            return $default;
        }

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'name') {
                    return str_replace('%', '', $filter->getValue());
                }
            }
        }

        return $default;
    }

    /**
     * Get the filter sort order
     *
     * @return string
     */
    public function getSortOrder()
    {
        $default = SortOrder::SORT_ASC;

        $searchCriteria = $this->getSearchResult()->getSearchCriteria();
        if (is_null($searchCriteria)) {
            return $default;
        }

        foreach ($searchCriteria->getSortOrders() as $sortOrder) {
            if ($sortOrder->getField() === 'name') {
                return $sortOrder->getDirection();
            }
        }

        return $default;
    }
}
