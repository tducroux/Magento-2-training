<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Training\Seller\Model\SellerFactory;
use Training\Seller\Model\Seller;

/**
 * Install Data
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class InstallData implements InstallDataInterface
{
    /**
     * Seller Factory
     *
     * @var SellerFactory
     */
    protected $sellerFactory;

    /**
     * PHP Constructor
     *
     * @param SellerFactory $sellerFactory
     */
    public function __construct(
        SellerFactory $sellerFactory
    ) {
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * Installs data
     *
     * @param ModuleDataSetupInterface $setup   Setup
     * @param ModuleContextInterface   $context Context
     *
     * @return void
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        /** @var Seller $model */
        $model = $this->sellerFactory->create();
        $model->setIdentifier('main')->setName('Main Seller');
        $model->getResource()->save($model);
    }
}
