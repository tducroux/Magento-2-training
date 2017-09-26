<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

/**
 * Admin Action : seller/delete
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Delete extends AbstractAction
{
    /**
     * Execute the action
     *
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        // check if we know what should be deleted
        $sellerId = (int) $this->getRequest()->getParam('seller_id');
        if ($sellerId) {
            try {
                /** @var \Training\Seller\Model\Seller $model */
                $model = $this->modelFactory->create();
                $model->getResource()->load($model, $sellerId);
                $model->getResource()->delete($model);

                // display success message
                $this->messageManager->addSuccessMessage(__('The seller has been deleted.'));

                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());

                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['seller_id' => $sellerId]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('The seller to delete does not exist.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
