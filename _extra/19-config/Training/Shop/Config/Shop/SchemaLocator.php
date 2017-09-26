<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Config\Shop;

use \Magento\Framework\Module\Dir\Reader as ModuleDirReader;
use Magento\Framework\Config\SchemaLocatorInterface;

/**
 * Class SchemaLocator
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class SchemaLocator implements SchemaLocatorInterface
{
    /**
     * Path to corresponding XSD file with validation rules for merged config
     *
     * @var string
     */
    protected $schema = null;

    /**
     * Path to corresponding XSD file with validation rules for separate config files
     *
     * @var string
     */
    protected $perFileSchema = null;

    /**
     * PHP Constructor
     *
     * @param ModuleDirReader $moduleReader
     */
    public function __construct(ModuleDirReader $moduleReader)
    {
        $etcDir = $moduleReader->getModuleDir('etc', 'Training_Shop');

        $this->schema        = $etcDir . '/shops.xsd';
        $this->perFileSchema = $etcDir . '/shops.xsd';
    }

    /**
     * Get path to merged config schema
     *
     * @return string|null
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Get path to pre file validation schema
     *
     * @return string|null
     */
    public function getPerFileSchema()
    {
        return $this->perFileSchema;
    }
}
