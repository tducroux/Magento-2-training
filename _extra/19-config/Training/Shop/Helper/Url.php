<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Shop Helper: Url
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Url extends AbstractHelper
{
    /**
     * get the url of the shops
     *
     * @return string
     */
    public function getShopsUrl()
    {
        return $this->_urlBuilder->getUrl('shop/index/index');
    }

    /**
     * get the url of a shop
     *
     * @param string $code
     *
     * @return string
     */
    public function getShopUrl($code)
    {
        return $this->_urlBuilder->getUrl('shop/index/view', array('code' => $code));
    }
}
