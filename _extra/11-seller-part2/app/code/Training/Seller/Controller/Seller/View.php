<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Seller;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Action : seller/view
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class View extends AbstractAction
{
    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        // get the asked identifier
        $identifier = trim($this->getRequest()->getParam('identifier'));
        if (!$identifier) {
            $this->_forward('noroute');
            return null;
        }

        // get the asked seller
        try {
            $seller = $this->sellerRepository->getByIdentifier($identifier);
        } catch (NoSuchEntityException $e) {
            $this->_forward('noroute');
            return null;
        }

        echo '<h1>'.$seller->getName().'</h1>';
        echo '<hr />';
        echo '<p>#'.$seller->getIdentifier().'</p>';
        echo '<hr />';
        echo '<a href="/sellers.html">back to the list</a>';
    }
}
