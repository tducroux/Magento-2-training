<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Controller\Index;

use \Magento\Framework\App\Action\Context;
use \Magento\Framework\App\Action\Action;
use Training\Shop\Api\Config\ShopInterface as ShopConfigInterface;
use Training\Shop\Helper\Url as UrlHelper;

/**
 * Controller abstract
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
abstract class AbstractAction extends Action
{
    /**
     * @var ShopConfigInterface
     */
    protected $shopConfig;

    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * PHP Constructor
     *
     * @param Context             $context
     * @param ShopConfigInterface $shopConfig
     * @param UrlHelper           $urlHelper
     */
    public function __construct(
        Context             $context,
        ShopConfigInterface $shopConfig,
        UrlHelper           $urlHelper
    ) {
        $this->shopConfig = $shopConfig;
        $this->urlHelper  = $urlHelper;

        parent::__construct($context);
    }
}
