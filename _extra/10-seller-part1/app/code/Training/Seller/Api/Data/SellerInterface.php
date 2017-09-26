<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Api\Data;

/**
 * Seller Data Interface
 *
 * @api
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
interface SellerInterface
{
    /**
     * Name of the Mysql TABLE
     */
    const TABLE_NAME    = 'training_seller';

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const FIELD_SELLER_ID  = 'seller_id';
    const FIELD_IDENTIFIER = 'identifier';
    const FIELD_NAME       = 'name';
    const FIELD_CREATED_AT = 'created_at';
    const FIELD_UPDATED_AT = 'updated_at';
    /**#@-*/

    /**
     * Get field: seller_id
     *
     * @return int|null
     */
    public function getSellerId();

    /**
     * Get field: identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get field: name
     *
     * @return string
     */
    public function getName();

    /**
     * Get field: created_at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get field: updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set field: seller_id
     *
     * @param int $value
     *
     * @return SellerInterface
     */
    public function setSellerId($value);

    /**
     * Set field: identifier
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setIdentifier($value);

    /**
     * Set field: name
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setName($value);

    /**
     * Set field: created_at
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setCreatedAt($value);

    /**
     * Set field: updated_at
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setUpdatedAt($value);
}
