<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

/**
 * Admin Action : seller/edit
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Edit extends AbstractAction
{
    /**
     * Execute the action
     *
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $model = $this->initModel();
        if (is_null($model)) {
            $this->messageManager->addErrorMessage(__('This seller does not exists.'));
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $breadcrumbTitle = $model->getId() ? __('Edit Seller') : __('New Seller');
        $resultPage
            ->setActiveMenu('Training_Seller::manage')
            ->addBreadcrumb(__('Sellers'), __('Sellers'))
            ->addBreadcrumb($breadcrumbTitle, $breadcrumbTitle);

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Sellers'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId()
            ? __("Edit Seller #%1", $model->getIdentifier())
            : __('New Seller')
        );

        return $resultPage;
    }
}
