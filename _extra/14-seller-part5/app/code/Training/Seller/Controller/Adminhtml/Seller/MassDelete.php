<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

/**
 * Admin Action : seller/massDelete
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class MassDelete extends AbstractAction
{
    /**
     * Execute the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $sellerIds = $this->geSellerIds();

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');

        if (count($sellerIds)<1) {
            $this->messageManager->addErrorMessage(__('Please select seller(s).'));
            return $resultRedirect;
        }

        try {
            /** @var \Training\Seller\Model\ResourceModel\Seller $resourceModel */
            $resourceModel = $this->modelFactory->create()->getResource();
            $resourceModel->deleteIds($sellerIds);
            $this->messageManager->addSuccessMessage(
                __('Total of %1 seller(s) were deleted.', count($sellerIds))
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect;
    }

    /**
     * Get the seller ids
     *
     * @return int[]
     */
    protected function geSellerIds()
    {
        $sellerIds = $this->getRequest()->getParam('selected');

        foreach ($sellerIds as $key => $value) {
            $value = (int) $value;

            if ($value<1) {
                unset($sellerIds[$key]);
                continue;
            }

            $sellerIds[$key] = $value;
        }

        $sellerIds = array_values($sellerIds);

        return $sellerIds;
    }
}
