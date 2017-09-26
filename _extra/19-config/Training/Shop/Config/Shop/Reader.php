<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Config\Shop;

use Magento\Framework\Config\Reader\Filesystem;
use Magento\Framework\Config\FileResolverInterface;
use Magento\Framework\Config\ValidationStateInterface;
use Training\Shop\Config\Shop\Converter as ShopConverter;
use Training\Shop\Config\Shop\SchemaLocator as ShopSchemaLocator;

/**
 * Class Reader
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Reader extends Filesystem
{
    /**
     * PHP Constructor
     *
     * @param FileResolverInterface    $fileResolver
     * @param ShopConverter            $converter
     * @param ShopSchemaLocator        $schemaLocator
     * @param ValidationStateInterface $validationState
     * @param string                   $fileName
     * @param array                    $idAttributes
     * @param string                   $domDocumentClass
     * @param string                   $defaultScope
     */
    public function __construct(
        FileResolverInterface    $fileResolver,
        ShopConverter            $converter,
        ShopSchemaLocator        $schemaLocator,
        ValidationStateInterface $validationState,
        $fileName = 'shops.xml',
        $idAttributes = ['/config/shop' => 'code'],
        $domDocumentClass = 'Magento\Framework\Config\Dom',
        $defaultScope = 'global'
    ) {
        parent::__construct(
            $fileResolver,
            $converter,
            $schemaLocator,
            $validationState,
            $fileName,
            $idAttributes,
            $domDocumentClass,
            $defaultScope
        );
    }
}
