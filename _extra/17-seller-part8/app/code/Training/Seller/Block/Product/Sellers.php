<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Product;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Catalog\Model\Product;
use Training\Seller\Block\Seller\AbstractBlock;
use Training\Seller\Helper\Url as UrlHelper;
use Training\Seller\Helper\Data as DataHelper;
use Training\Seller\Model\Seller;

/**
 * Block Product Sellers
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Sellers extends AbstractBlock implements IdentityInterface
{
    /**
     * @var Seller[]
     */
    protected $sellers;

    /**
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * PHP constructor
     *
     * @param Context     $context
     * @param Registry    $registry
     * @param UrlHelper   $urlHelper
     * @param DataHelper  $dataHelper
     * @param array       $data
     */
    public function __construct(
        Context     $context,
        Registry    $registry,
        UrlHelper   $urlHelper,
        DataHelper  $dataHelper,
        array       $data = []
    ) {
        $this->dataHelper = $dataHelper;

        parent::__construct($context, $registry, $urlHelper, $data);
    }

    /**
     * Used to set the cache infos
     *
     * @return void
     */
    protected function _construct()
    {
        $product = $this->getCurrentProduct();
        if ($product) {
            $this->setData('cache_key', 'product_view_tab_sellers_' . $product->getId());
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

        $product = $this->getCurrentProduct();
        if ($product) {
            $identities = array_merge($identities, $product->getIdentities());
        }

        $sellers = $this->getProductSellers();
        foreach ($sellers as $seller) {
            $identities = array_merge($identities, $seller->getIdentities());
        }

        return $identities;
    }

    /**
     * Get the current product
     *
     * @return Product
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get the sellers attached to the current product
     *
     * @return Seller[]
     */
    public function getProductSellers()
    {
        if (is_null($this->sellers)) {
            $this->sellers = [];
            $product = $this->getCurrentProduct();
            if ($product) {
                $this->sellers = $this->dataHelper->getProductSellers($product);
            }
        }

        return $this->sellers;
    }
}
