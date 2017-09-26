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
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Product;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Model\Customer;

/**
 * Upgrade Data
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
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
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * PHP Constructor
     *
     * @param EavConfig            $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     * @param EavSetupFactory      $eavSetupFactory
     *
     * @return InstallData
     */
    public function __construct(
        EavConfig            $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        EavSetupFactory      $eavSetupFactory
    ) {
        $this->eavConfig            = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavSetupFactory      = $eavSetupFactory;
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

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $this->addProductAttribute($setup);
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


    /**
     * Add the attribute "training_seller_id" on the product model
     *
     * @param ModuleDataSetupInterface $setup
     *
     * @return void
     */
    protected function addProductAttribute(ModuleDataSetupInterface $setup)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            'training_seller_ids',
            [
                'label'                    => 'Training Sellers',
                'type'                     => 'varchar',
                'input'                    => 'multiselect',
                'backend'                  => \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class,
                'frontend'                 => '',
                'class'                    => '',
                'source'                   => \Training\Seller\Option\Seller::class,
                'global'                   => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                'visible'                  => true,
                'required'                 => false,
                'user_defined'             => true,
                'default'                  => '',
                'searchable'               => false,
                'filterable'               => false,
                'comparable'               => true,
                'visible_on_front'         => true,
                'used_in_product_listing'  => false,
                'is_html_allowed_on_front' => true,
                'unique'                   => false,
                'apply_to'                 => 'simple,configurable'
            ]
        );

        $eavSetup->addAttributeGroup(
            Product::ENTITY,
            'bag',
            'Training'
        );

        $eavSetup->addAttributeToGroup(
            Product::ENTITY,
            'bag',
            'Training',
            'training_seller_ids'
        );

        $this->eavConfig->clear();
    }
}
