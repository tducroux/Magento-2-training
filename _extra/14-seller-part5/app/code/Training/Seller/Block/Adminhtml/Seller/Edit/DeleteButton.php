<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Adminhtml\Seller\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Adminhtml block : Button Delete
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class DeleteButton extends AbstractButton implements ButtonProviderInterface
{
    /**
     * get the button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getObjectId()) {
            $message = htmlentities(__('Are you sure you want to delete this seller?'));

            $data = [
                'label'      => __('Delete Seller'),
                'class'      => 'delete',
                'on_click'   => "deleteConfirm('{$message}', '{$this->getDeleteUrl()}')",
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['seller_id' => $this->getObjectId()]);
    }
}
