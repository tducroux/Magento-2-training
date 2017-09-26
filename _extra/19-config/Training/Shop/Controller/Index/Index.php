<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Controller\Index;

/**
 * Shop Controller, action Index
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
        // get the list of the shops
        $shops = $this->shopConfig->getShops();

        $html = '<ul>';
        foreach ($shops as $shop) {
            $html.= '<li>';
            $html.= '<a href="'.$this->urlHelper->getShopUrl($shop['code']).'">';
            $html.= $shop['name'];
            $html.= '</a> ('.$shop['code'].')';
            $html.= '</li>';
        }
        $html.= '</ul>';

        $this->getResponse()->appendBody($html);
    }
}
