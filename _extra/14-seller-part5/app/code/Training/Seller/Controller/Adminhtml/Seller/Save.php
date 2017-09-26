<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Training\Seller\Model\SellerFactory;

/**
 * Admin Action : seller/save
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class Save extends AbstractAction
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * PHP Constructor
     *
     * @param \Magento\Backend\App\Action\Context          $context
     * @param \Magento\Framework\Registry                  $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory   $pageFactory
     * @param \Training\Seller\Model\SellerFactory         $modelFactory
     * @param DataPersistorInterface                       $dataPersistor
     */
    public function __construct(
        Context                $context,
        Registry               $coreRegistry,
        PageFactory            $pageFactory,
        SellerFactory          $modelFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;

        parent::__construct($context, $coreRegistry, $pageFactory, $modelFactory);
    }

    /**
     * Execute the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $this->getRequest();
        $data = $request->getPostValue();

        // check if data sent
        if (!empty($data)) {
            if (empty($data['seller_id'])) {
                $data['seller_id'] = null;
            }
            $sellerId = $data['seller_id'];

            /** @var \Training\Seller\Model\Seller $model */
            $model = $this->modelFactory->create();

            if ($sellerId) {
                $model->getResource()->load($model, $sellerId);

                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This seller does not exist.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            // send the data to the model
            $model->populateFromArray($data);

            // try to save it
            try {
                // save the data
                $model->getResource()->save($model);

                // display success message
                $this->messageManager->addSuccessMessage(__('The seller has been saved.'));
                $this->dataPersistor->clear('training_seller_seller');

                // if asked, go back to view
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['seller_id' => $model->getId()]);
                }

                // go back to grid
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the seller. %1', $e->getMessage())
                );
            }

            $this->dataPersistor->set('training_seller_seller', $data);

            // redirect to edit form
            return $resultRedirect->setPath('*/*/edit', ['seller_id' => $sellerId]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
