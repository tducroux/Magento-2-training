<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Adminhtml\Seller\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Adminhtml block : Button Save
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class SaveButton extends AbstractButton implements ButtonProviderInterface
{
    /**
     * get the button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'          => __('Save Seller'),
            'class'          => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            'sort_order'     => 90,
        ];
    }
}
