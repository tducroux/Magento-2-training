<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
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
     * Model Factory
     *
     * @var \Training\Seller\Model\SellerFactory
     */
    protected $modelFactory;

    /**
     * PHP Constructor
     *
     * @param \Magento\Backend\App\Action\Context          $context
     * @param \Training\Seller\Model\SellerFactory         $modelFactory
     */
    public function __construct(
        Context $context,
        SellerFactory $modelFactory
    ) {
        parent::__construct($context);

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
}
