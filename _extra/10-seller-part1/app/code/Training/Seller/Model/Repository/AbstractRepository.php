<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Model\Repository;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Data\Collection\AbstractDb as AbstractCollection;
use Magento\Framework\Model\AbstractModel;

/**
 * Model: AbstractRepository
 *
 * @author    Laurent Minguet <lamin@smile.fr>
 * @copyright 2016 Smile
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractRepository
{
    /**
     * @var \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    protected $objectResource;

    /**
     * Object Factory
     * @var \Magento\Framework\Model\AbstractModelFactory
     */
    protected $objectFactory;

    /**
     * Search Result Factory
     * @var \Magento\Framework\Api\SearchResultsFactory
     */
    protected $searchResultsFactory;

    /**
     * Repository cache by id
     *
     * @var array
     */
    protected $objectRepoById = [];

    /**
     * Repository cache by identifier

     * @var array
     */
    protected $objectRepoByCode = [];

    /**
     * The identifier field name for the getByIdentifier method
     *
     * @var string|null
     */
    protected $identifierFieldName = null;

    /**
     * AbstractRepository constructor.
     *
     * @param \Magento\Framework\Model\AbstractModelFactory        $objectFactory
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $objectResource
     * @param \Magento\Framework\Api\SearchResultsFactory          $searchResultsFactory
     */
    public function __construct(
        $objectFactory,
        $objectResource,
        $searchResultsFactory
    ) {
        $this->objectFactory        = $objectFactory;
        $this->objectResource       = $objectResource;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Set the identifier field name for the getByIdentifier method
     *
     * @param string|null $fieldName
     *
     * @return void
     */
    protected function setIdentifierFieldName($fieldName = null)
    {
        $this->identifierFieldName = $fieldName;
    }

    /**
     * Retrieve a entity by its ID
     *
     * @param int $objectId id of the entity
     *
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings("PMD.StaticAccess")
     */
    protected function getEntityById($objectId)
    {
        if (!isset($this->objectRepoById[$objectId])) {

            /** @var \Magento\Framework\Model\AbstractModel $object */
            $object = $this->objectFactory->create();
            $this->objectResource->load($object, $objectId);

            if (!$object->getId()) {
                // object does not exist
                throw NoSuchEntityException::singleField('objectId', $objectId);
            }

            $this->objectRepoById[$object->getId()] = $object;

            if (!is_null($this->identifierFieldName)) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                $this->objectRepoByCode[$objectIdentifier] = $object;
            }
        }

        return $this->objectRepoById[$objectId];
    }

    /**
     * Retrieve a entity by its identifier
     *
     * @param string $objectIdentifier identifier of the entity
     *
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings("PMD.StaticAccess")
     */
    protected function getEntityByIdentifier($objectIdentifier)
    {
        if (is_null($this->identifierFieldName)) {
            throw new NoSuchEntityException('The identifier field name is not set');
        }

        if (!isset($this->objectRepoByCode[$objectIdentifier])) {

            /** @var \Magento\Framework\Model\AbstractModel $object */
            $object = $this->objectFactory->create();
            $this->objectResource->load($object, $objectIdentifier, $this->identifierFieldName);

            if (!$object->getId()) {
                // object does not exist
                throw NoSuchEntityException::singleField('objectIdentifier', $objectIdentifier);
            }

            $this->objectRepoById[$object->getId()] = $object;
            $this->objectRepoByCode[$objectIdentifier] = $object;
        }

        return $this->objectRepoByCode[$objectIdentifier];
    }

    /**
     * Retrieve not eav entities which match a specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria search criteria
     *
     * @return \Magento\Framework\Api\SearchResults
     */
    protected function getEntities(SearchCriteriaInterface $searchCriteria = null)
    {
        $collection = $this->getEntityCollection();

        /** @var \Magento\Framework\Api\SearchResults $searchResults */
        $searchResults = $this->searchResultsFactory->create();

        if ($searchCriteria) {
            $searchResults->setSearchCriteria($searchCriteria);
            $this->prepareCollectionFromSearchCriteria($collection, $searchCriteria);
        }

        // load the collection
        $collection->load();

        // build the result
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * Save entity
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     *
     * @return \Magento\Framework\Model\AbstractModel
     * @throws CouldNotSaveException
     */
    protected function saveEntity(AbstractModel $object)
    {
        try {
            $this->objectResource->save($object);

            unset($this->objectRepoById[$object->getId()]);
            if (!is_null($this->identifierFieldName)) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                unset($this->objectRepoByCode[$objectIdentifier]);
            }
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $object;
    }

    /**
     * Delete entity
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     *
     * @return boolean
     * @throws CouldNotDeleteException
     */
    protected function deleteEntity(AbstractModel $object)
    {
        try {
            $this->objectResource->delete($object);

            unset($this->objectRepoById[$object->getId()]);
            if (!is_null($this->identifierFieldName)) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                unset($this->objectRepoByCode[$objectIdentifier]);
            }
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * get the entity collection
     *
     * @return AbstractCollection
     */
    protected function getEntityCollection()
    {
        return $this->objectFactory->create()->getCollection();
    }

    /**
     * Prepare a collection from a search criteria
     *
     * @param AbstractCollection      $collection     The collection of object to prepare
     * @param SearchCriteriaInterface $searchCriteria The search criteria to use
     *
     * @return void
     */
    protected function prepareCollectionFromSearchCriteria(
        AbstractCollection $collection,
        SearchCriteriaInterface $searchCriteria
    ) {
        $this->prepareCollectionFromSearchCriteriaFilter($collection, $searchCriteria);
        $this->prepareCollectionFromSearchCriteriaOrder($collection, $searchCriteria);
        $this->prepareCollectionFromSearchCriteriaPage($collection, $searchCriteria);
    }

    /**
     * Prepare a collection from a search criteria - Filter Part
     *
     * @param AbstractCollection      $collection     The collection of object to prepare
     * @param SearchCriteriaInterface $searchCriteria The search criteria to use
     *
     * @return void
     */
    protected function prepareCollectionFromSearchCriteriaFilter(
        AbstractCollection $collection,
        SearchCriteriaInterface $searchCriteria
    ) {
        // apply filters
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
    }

    /**
     * Prepare a collection from a search criteria - Order Part
     *
     * @param AbstractCollection      $collection     The collection of object to prepare
     * @param SearchCriteriaInterface $searchCriteria The search criteria to use
     *
     * @return void
     */
    protected function prepareCollectionFromSearchCriteriaOrder(
        AbstractCollection $collection,
        SearchCriteriaInterface $searchCriteria
    ) {
        // apply orders
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $isAscending = ($sortOrder->getDirection() == SortOrder::SORT_ASC);
                $collection->addOrder(
                    $sortOrder->getField(),
                    $isAscending ? 'ASC' : 'DESC'
                );
            }
        }
    }

    /**
     * Prepare a collection from a search criteria - Page Part
     *
     * @param AbstractCollection      $collection     The collection of object to prepare
     * @param SearchCriteriaInterface $searchCriteria The search criteria to use
     *
     * @return void
     */
    protected function prepareCollectionFromSearchCriteriaPage(
        AbstractCollection $collection,
        SearchCriteriaInterface $searchCriteria
    ) {
        // apply paging
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }
}
