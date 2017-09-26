<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Model\Customer;

/**
 * Upgrade Data
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavConfig
     */
    protected $eavConfig;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * PHP Constructor
     *
     * @param EavConfig            $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        EavConfig            $eavConfig,
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->eavConfig            = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * Installs data
     *
     * @param ModuleDataSetupInterface $setup   Setup
     * @param ModuleContextInterface   $context Context
     *
     * @return void
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $this->addCustomerAttribute($setup);
        }

        $setup->endSetup();
    }

    /**
     * Add the attribute "training_seller_id" on the customer model
     *
     * @param ModuleDataSetupInterface $setup
     *
     * @return void
     */
    protected function addCustomerAttribute(ModuleDataSetupInterface $setup)
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'training_seller_id',
            [
                'label'    => 'Training Seller',
                'type'     => 'int',
                'input'    => 'select',
                'source'   => \Training\Seller\Option\Seller::class,
                'required' => false,
                'system'   => false,
                'position' => 900,
            ]
        );

        $this->eavConfig->clear();

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'training_seller_id');
        $attribute->setData('used_in_forms', ['adminhtml_customer']);
        $attribute->save();

        $this->eavConfig->clear();
    }
}
