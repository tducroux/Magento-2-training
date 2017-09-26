<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Adminhtml\Seller\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Training\Seller\Api\SellerRepositoryInterface;

/**
 * Adminhtml block : Abstract Button
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
abstract class AbstractButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var SellerRepositoryInterface
     */
    protected $repository;

    /**
     * PHP Constructor
     *
     * @param Context                      $context
     * @param SellerRepositoryInterface $repository
     */
    public function __construct(
        Context                      $context,
        SellerRepositoryInterface $repository
    ) {
        $this->context    = $context;
        $this->repository = $repository;
    }

    /**
     * Return object ID
     *
     * @return int|null
     */
    public function getObjectId()
    {
        try {
            $modelId = (int) $this->context->getRequest()->getParam('seller_id');

            /** @var \Training\Seller\Api\Data\SellerInterface $model */
            $model = $this->repository->getById($modelId);

            return $model->getSellerId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array  $params
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * get the button data
     *
     * @return array
     */
    abstract public function getButtonData();
}
