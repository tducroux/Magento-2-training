<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Training\Seller\Model\SellerFactory;

/**
 * Admin Action : seller/inlineEdit
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class InlineEdit extends AbstractAction
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * InlineEdit constructor.
     *
     * @param \Magento\Backend\App\Action\Context              $context
     * @param \Magento\Framework\Registry                      $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory       $pageFactory
     * @param \Training\Seller\Model\SellerFactory             $modelFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        Context       $context,
        Registry      $coreRegistry,
        PageFactory   $pageFactory,
        SellerFactory $modelFactory,
        JsonFactory   $jsonFactory
    ) {
        $this->jsonFactory = $jsonFactory;

        parent::__construct($context, $coreRegistry, $pageFactory, $modelFactory);
    }

    /**
     * Execute the action
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
                return $this->getResult($messages, $error);
            }

            foreach (array_keys($postItems) as $modelId) {
                try {
                    /** @var \Training\Seller\Model\Seller $model */
                    // only one seller is always given in the post items array
                    //@SmileAnalyserSkip magento2/performances
                    $model = $this->modelFactory->create();
                    $model->getResource()->load($model, $modelId);

                    if ($model->getId() != $modelId) {
                        throw new \Exception('Invalid id');
                    }

                    $model->populateFromArray($postItems[$modelId]);
                    $model->getResource()->save($model);
                } catch (\Exception $e) {
                    $messages[] = '[Seller #'.$modelId.'] ' . __($e->getMessage());
                    $error = true;
                }
            }
        }

        return $this->getResult($messages, $error);
    }

    /**
     * Get the result
     *
     * @param string[] $messages
     * @param bool     $error
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    protected function getResult($messages, $error)
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();

        return $resultJson->setData(['messages' => $messages, 'error' => $error]);
    }
}
