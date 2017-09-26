<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Seller;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Training\Seller\Helper\Url as UrlHelper;

/**
 * Abstract Block
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
abstract class AbstractBlock extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * PHP Constructor
     *
     * @param Context   $context
     * @param Registry  $registry
     * @param UrlHelper $urlHelper
     * @param array     $data
     */
    public function __construct(
        Context   $context,
        Registry  $registry,
        UrlHelper $urlHelper,
        array     $data = []
    ) {
        $this->registry  = $registry;
        $this->urlHelper = $urlHelper;

        parent::__construct($context, $data);
    }

    /**
     * Get the Sellers url
     *
     * @return string
     */
    public function getSellersUrl()
    {
        return $this->urlHelper->getSellersUrl();
    }

    /**
     * Get the Seller url
     *
     * @param string $identifier
     *
     * @return string
     */
    public function getSellerUrl($identifier)
    {
        return $this->urlHelper->getSellerUrl($identifier);
    }
}
