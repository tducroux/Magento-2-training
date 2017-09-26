<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Training\Seller\Api\Data\SellerInterface;

/**
 * Upgrade Schema
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface   $setup   Setup
     * @param ModuleContextInterface $context Context
     *
     * @return void
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->addColumnDescription($setup);
        }

        $setup->endSetup();
    }

    /**
     * Add the "description" column on seller table
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    protected function addColumnDescription(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable(SellerInterface::TABLE_NAME);

        $setup->getConnection()->addColumn(
            $tableName,
            SellerInterface::FIELD_DESCRIPTION,
            array(
                'type'     => Table::TYPE_TEXT,
                'length'   => null,
                'nullable' => true,
                'comment'  => 'Seller Description'
            )
        );
    }
}
