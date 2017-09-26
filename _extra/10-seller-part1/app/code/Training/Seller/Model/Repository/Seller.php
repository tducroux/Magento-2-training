<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Model\Repository;

use Magento\Framework\Api\SearchCriteriaInterface;
use Training\Seller\Api\SellerRepositoryInterface;
use Training\Seller\Api\Data\SellerSearchResultsInterfaceFactory;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Model\SellerFactory;
use Training\Seller\Model\ResourceModel\Seller as SellerResourceModel;

/**
 * Seller Repository
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Seller extends AbstractRepository implements SellerRepositoryInterface
{
    /**
     * PHP Constructor
     *
     * @param SellerFactory                       $objectFactory
     * @param SellerResourceModel                 $objectResource
     * @param SellerSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        SellerFactory                       $objectFactory,
        SellerResourceModel                 $objectResource,
        SellerSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        parent::__construct($objectFactory, $objectResource, $searchResultsFactory);

        $this->setIdentifierFieldName(SellerInterface::FIELD_IDENTIFIER);
    }

    /**
     * @inheritdoc
     */
    public function getById($objectId)
    {
        return $this->getEntityById($objectId);
    }

    /**
     * @inheritdoc
     */
    public function getByIdentifier($objectIdentifier)
    {
        return $this->getEntityByIdentifier($objectIdentifier);
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this->getEntities($searchCriteria);
    }

    /**
     * @inheritdoc
     */
    public function save(SellerInterface $object)
    {
        return $this->saveEntity($object);
    }

    /**
     * @inheritdoc
     */
    public function deleteById($objectId)
    {
        return $this->deleteEntity($this->getEntityById($objectId));
    }

    /**
     * @inheritdoc
     */
    public function deleteByIdentifier($objectIdentifier)
    {
        return $this->deleteEntity($this->getEntityByIdentifier($objectIdentifier));
    }
}
