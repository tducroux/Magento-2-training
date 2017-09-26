<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Rewrite\Model;

/**
 * Rewrite \Magento\Catalog\Model\Product
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Product extends \Magento\Catalog\Model\Product
{
    /**
     * Get the name of the product
     *
     * @return string
     */
    public function getName()
    {
        $value = parent::getName() . ' (Hello World)';
        
        return $value;
    }
}
