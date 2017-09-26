<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Training\Seller\Api\Data\SellerInterface;

/**
 * Seller Model
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Seller extends AbstractModel implements SellerInterface, IdentityInterface
{
    /**
     * Seller cache tag
     */
    const CACHE_TAG = 'training_seller';

    /**
     * @var string
     */
    protected $_cacheTag = 'training_seller';

    /**
     * Magento Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Training\Seller\Model\ResourceModel\Seller');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * @inheritdoc
     */
    public function getSellerId()
    {
        return $this->getId();
    }

    /**
     * @inheritdoc
     */
    public function getIdentifier()
    {
        return (string) $this->getData(self::FIELD_IDENTIFIER);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return (string) $this->getData(self::FIELD_NAME);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return (string) $this->getData(self::FIELD_CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return (string) $this->getData(self::FIELD_UPDATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setSellerId($value)
    {
        return $this->setId((int) $value);
    }

    /**
     * @inheritdoc
     */
    public function setIdentifier($value)
    {
        return $this->setData(self::FIELD_IDENTIFIER, (string) $value);
    }

    /**
     * @inheritdoc
     */
    public function setName($value)
    {
        return $this->setData(self::FIELD_NAME, (string) $value);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($value)
    {
        return $this->setData(self::FIELD_CREATED_AT, (string) $value);
    }

    /**
     * @inheritdoc
     */
    public function setUpdatedAt($value)
    {
        return $this->setData(self::FIELD_UPDATED_AT, (string) $value);
    }

    /**
     * Populate the object from array values
     * It is better to use setters instead of the generic setData method
     *
     * @param array $values
     *
     * @return Seller
     */
    public function populateFromArray(array $values)
    {
        $this->setIdentifier($values['identifier']);
        $this->setName($values['name']);

        return $this;
    }
}
