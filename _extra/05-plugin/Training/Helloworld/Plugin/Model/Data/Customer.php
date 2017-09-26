<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Plugin\Model\Data;

/**
 * Plugin Customer
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Customer
{
    /**
     * Modify the first name
     *
     * @param \Magento\Customer\Model\Data\Customer $subject Customer Model
     * @param string                                $value   value parameter
     *
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSetFirstname(\Magento\Customer\Model\Data\Customer $subject, $value)
    {
        $value = mb_convert_case($value, MB_CASE_TITLE);

        return [$value];
    }
}
