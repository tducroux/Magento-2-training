<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Training\Seller\Model\SellerFactory;

/**
 * Abstract Admin action for seller
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
abstract class AbstractAction extends Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Training\Seller\Model\SellerFactory
     */
    protected $modelFactory;

    /**
     * PHP Constructor
     *
     * @param \Magento\Backend\App\Action\Context          $context
     * @param \Magento\Framework\Registry                  $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory   $pageFactory
     * @param \Training\Seller\Model\SellerFactory         $modelFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $pageFactory,
        SellerFactory $modelFactory
    ) {
        parent::__construct($context);

        $this->coreRegistry        = $coreRegistry;
        $this->resultPageFactory   = $pageFactory;
        $this->modelFactory        = $modelFactory;
    }

    /**
     * Is it allowed ?
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Training_Seller::manage');
    }

    /**
     * Init the current model
     *
     * @return \Training\Seller\Model\Seller
     */
    protected function initModel()
    {
        // Get the ID
        $modelId = (int) $this->getRequest()->getParam('seller_id');

        /** @var \Training\Seller\Model\Seller $model */
        $model = $this->modelFactory->create();

        // Initial checking
        if ($modelId) {
            $model->getResource()->load($model, $modelId);
            if (!$model->getId()) {
                return null;
            }
        }

        // Register model to use later in blocks
        $this->coreRegistry->register('current_seller', $model);

        return $model;
    }
}
