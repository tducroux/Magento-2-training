<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Option;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Model\ResourceModel\Seller\Collection as SellerCollection;
use Training\Seller\Model\ResourceModel\Seller\CollectionFactory as SellerCollectionFactory;

/**
 * Sellers Option
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Seller extends AbstractSource
{
    /**
     * @var SellerCollectionFactory
     */
    protected $sellerCollectionFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * constructor
     *
     * @param SellerCollectionFactory $sellerCollectionFactory
     */
    public function __construct(
        SellerCollectionFactory $sellerCollectionFactory
    ) {
        $this->sellerCollectionFactory = $sellerCollectionFactory;
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        return $this->getOptions();
    }

    /**
     * get the list of the options
     *
     * @return array
     */
    protected function getOptions()
    {
        if (is_null($this->options)) {
            /** @var SellerCollection $collection */
            $collection = $this->sellerCollectionFactory->create();
            $collection->setOrder(SellerInterface::FIELD_NAME, $collection::SORT_ORDER_ASC);
            $this->options = $collection->load()->toOptionArray();
        }

        return $this->options;
    }
}
