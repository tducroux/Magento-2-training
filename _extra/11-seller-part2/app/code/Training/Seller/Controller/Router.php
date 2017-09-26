<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

/**
 * Seller Router
 *
 * @package   Training\Seller\Controller
 * @copyright 2016 Smile
 */
class Router implements RouterInterface
{
    /**
     * Magento Action Factory
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * PHP Constructor
     *
     * @param \Magento\Framework\App\ActionFactory $actionFactory Magento Action Factory
     */
    public function __construct(
        ActionFactory $actionFactory
    ) {
        $this->actionFactory = $actionFactory;
    }

    /**
     * Validate and Match Seller Pages and modify request
     *
     * @param \Magento\Framework\App\RequestInterface $request Magento Request
     *
     * @return bool
     */
    public function match(RequestInterface $request)
    {
        /** @var \Magento\Framework\App\Request\Http $request */
        $info = $request->getPathInfo();

        if (preg_match('%^/seller/(.+)\.html$%', $info, $match)) {
            $request->setPathInfo(sprintf('/seller/seller/view/identifier/%s', $match[1]));
            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        }

        if ($info == '/sellers.html') {
            $request->setPathInfo('/seller/seller/index');
            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        }

        return null;
    }
}
