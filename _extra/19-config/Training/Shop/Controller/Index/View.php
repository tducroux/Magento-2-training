<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Controller\Index;

/**
 * Shop Controller, action View
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
        // get the asked code
        $shopCode = $this->getRequest()->getParam('code');

        if (!$shopCode) {
            $this->_forward('noroute');
            return;
        }

        // get the shop
        $shop = $this->shopConfig->getShop($shopCode);
        if (!$shop) {
            $this->_forward('noroute');
            return;
        }

        $html = '<ul>';
        foreach ($shop as $key => $value) {
            $html.= '<li>'.$key.': '.$value.'</li>';
        }
        $html.= '</ul>';
        $html.= '<a href="'.$this->urlHelper->getShopsUrl().'">Return to the list</a>';

        $this->getResponse()->appendBody($html);
    }
}
