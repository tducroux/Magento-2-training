<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Seller Search result Data Interface
 *
 * @api
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
interface SellerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get seller list
     *
     * @return \Training\Seller\Api\Data\SellerInterface[]
     */
    public function getItems();

    /**
     * Set seller list
     *
     * @param \Training\Seller\Api\Data\SellerInterface[] $items list of sellers
     *
     * @return $this
     */
    public function setItems(array $items);
}
