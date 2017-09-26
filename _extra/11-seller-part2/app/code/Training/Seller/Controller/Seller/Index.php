<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Seller;

/**
 * Action : seller/index
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Index extends AbstractAction
{
    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        $searchCriteria = $this->getSearchCriteria();

        // get the list of the sellers
        $result = $this->sellerRepository->getList($searchCriteria);

        // display the result
        echo '<ul>';
        foreach ($result->getItems() as $seller) {
            echo '<li><a href="/seller/'.$seller->getIdentifier().'.html">'.$seller->getName().'</a></li>';
        }
        echo '</ul>';
    }

    /**
     * Get the search criteria
     *
     * @return \Magento\Framework\Api\SearchCriteria
     */
    protected function getSearchCriteria()
    {
        // build the criteria
        return $this->searchCriteriaBuilder->create();
    }
}
