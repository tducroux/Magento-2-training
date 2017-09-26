<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Seller;

use Magento\Framework\DataObject\IdentityInterface;

/**
 * Block View
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class View extends AbstractBlock implements IdentityInterface
{
    /**
     * Used to set the cache infos
     *
     * @return void
     */
    protected function _construct()
    {
        $seller = $this->getCurrentSeller();
        if ($seller) {
            $this->setData('cache_key', 'seller_view_' . $seller->getId());
            $this->setData('cache_lifetime', 600);
        }
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        $identities = [];

        $seller = $this->getCurrentSeller();
        if ($seller) {
            $identities = $seller->getIdentities();
        }

        return $identities;
    }

    /**
     * Get the current seller
     *
     * @return \Training\Seller\Model\Seller
     */
    public function getCurrentSeller()
    {
        return $this->registry->registry('current_seller');
    }
}
