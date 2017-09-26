<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Model\ResourceModel;

use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\AbstractModel;

/**
 * Model: Trait for Resource model that use new entity manager
 *
 * @author    Laurent Minguet <lamin@smile.fr>
 * @copyright 2016 Smile
 */
trait TraitResource
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var string
     */
    protected $dataInterfaceClassName;

    /**
     * @var string
     */
    protected $mainTableName;

    /**
     * @var string
     */
    protected $idFieldName;

    /**
     * specific constructor for the trait
     *
     * @param EntityManager $entityManager
     * @param MetadataPool  $metadataPool
     * @param string        $dataInterfaceClassName
     * @param string        $mainTable
     * @param string        $idFieldName
     *
     * @return void
     */
    protected function constructTrait(
        EntityManager $entityManager,
        MetadataPool  $metadataPool,
        $dataInterfaceClassName,
        $mainTable,
        $idFieldName
    ) {
        $this->entityManager          = $entityManager;
        $this->metadataPool           = $metadataPool;
        $this->dataInterfaceClassName = $dataInterfaceClassName;
        $this->mainTableName          = $mainTable;
        $this->idFieldName            = $idFieldName;
    }

    /**
     * Get connection
     *
     * @return \Magento\Framework\DB\Adapter\AdapterInterface|false
     */
    public function getConnection()
    {
        return $this->metadataPool->getMetadata($this->dataInterfaceClassName)->getEntityConnection();
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return \Magento\Framework\DB\Select
     */
    protected function getLoadSelect($field, $value)
    {
        $field = $this->getConnection()->quoteIdentifier(sprintf('%s.%s', $this->mainTableName, $field));

        $select = $this->getConnection()->select()->from($this->mainTableName)->where($field . '=?', $value);

        return $select;
    }

    /**
     * get the id of an object
     *
     * @param mixed         $value
     * @param null          $field
     *
     * @return bool|int|string
     */
    protected function getObjectId($value, $field = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata($this->dataInterfaceClassName);
        if (is_null($field)) {
            $field = $entityMetadata->getIdentifierField();
        }
        $entityId = $value;

        if ($field != $entityMetadata->getIdentifierField()) {
            $select = $this->getLoadSelect($field, $value);
            $select->reset(Select::COLUMNS)
                ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
                ->limit(1);
            $result = $this->getConnection()->fetchCol($select);
            $entityId = count($result) ? $result[0] : false;
        }
        return $entityId;
    }

    /**
     * Load an object
     *
     * @param AbstractModel $object
     * @param mixed         $value
     * @param string        $field field to load by (defaults to model id)
     *
     * @return $this
     * @throws \Exception
     */
    protected function loadWithEntityManager(AbstractModel $object, $value, $field = null)
    {
        $objectId = $this->getObjectId($value, $field);
        if ($objectId) {
            $this->entityManager->load($object, $objectId);
        }
        return $this;
    }

    /**
     * Save an object
     *
     * @param AbstractModel $object
     *
     * @return $this
     * @throws \Exception
     */
    protected function saveWithEntityManager(AbstractModel $object)
    {
        $this->entityManager->save($object);

        return $this;
    }

    /**
     * Delete an object
     * We can not directly create the public method "delete"
     * because of a bad declaration in the nativ class of magento
     *
     * @param AbstractModel $object
     *
     * @return $this
     * @throws \Exception
     */
    protected function deleteWithEntityManager(AbstractModel $object)
    {
        $this->entityManager->delete($object);

        return $this;
    }
}
