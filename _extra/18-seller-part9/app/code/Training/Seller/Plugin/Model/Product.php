<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Plugin\Model;

use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\Catalog\Model\Product as ProductModel;
use Training\Seller\Helper\Data as DataHelper;

/**
 * Plugin on \Magento\Catalog\Model\Product
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Product
{
    /**
     * @var ProductExtensionFactory
     */
    protected $extensionFactory;

    /**
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * PHP Constructor
     *
     * @param ProductExtensionFactory $extensionFactory
     * @param DataHelper              $dataHelper
     */
    public function __construct(
        ProductExtensionFactory $extensionFactory,
        DataHelper              $dataHelper
    ) {
        $this->extensionFactory = $extensionFactory;
        $this->dataHelper       = $dataHelper;
    }

    /**
     * Add sellers information to the product's extension attributes
     *
     * @param ProductModel $product
     *
     * @return ProductModel
     */
    public function afterLoad(ProductModel $product)
    {
        // get all the extension attributes
        $extension = $product->getExtensionAttributes();
        if (is_null($extension)) {
            $extension = $this->extensionFactory->create();
        }

        // get the sellers linked to the product
        $sellers = $this->dataHelper->getProductSellers($product);

        // add them to the specific attribute "sellers"
        $extension->setSellers($sellers);

        // save it to the product
        $product->setExtensionAttributes($extension);

        return $product;
    }
}
