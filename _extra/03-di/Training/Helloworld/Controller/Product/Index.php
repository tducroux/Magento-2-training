<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Controller\Product;

/**
 * Action: Product/Index
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * PHP Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        parent::__construct($context);

        $this->productFactory = $productFactory;
    }

    /**
     * Execute the action
     *
     * @return void
     */
    public function execute()
    {
        $product = $this->getAskedProduct();
        if (is_null($product)) {
            $this->_forward('noroute');
            return;
        }

        $this->getResponse()->appendBody('Product: '.$product->getName());
    }

    /**
     * Get the asked product
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    protected function getAskedProduct()
    {
        // get the asked id
        $productId = (int) $this->getRequest()->getParam('id');
        if (!$productId) {
            return null;
        }

        // get the product
        $product = $this->productFactory->create();
        $product->getResource()->load($product, $productId);
        if (!$product->getId()) {
            return null;
        }

        return $product;
    }
}
