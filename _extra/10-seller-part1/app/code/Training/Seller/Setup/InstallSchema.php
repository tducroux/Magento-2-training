<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Training\Seller\Api\Data\SellerInterface;

/**
 * Install Schema
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2016 Smile
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface   $setup   Setup
     * @param ModuleContextInterface $context Context
     *
     * @return void
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     * @SuppressWarnings("PMD.ExcessiveMethodLength")
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $tableName = $setup->getTable(SellerInterface::TABLE_NAME);

        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(
                SellerInterface::FIELD_SELLER_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true]
            )->addColumn(
                SellerInterface::FIELD_IDENTIFIER,
                Table::TYPE_TEXT,
                64,
                ['nullable' => false]
            )->addColumn(
                SellerInterface::FIELD_NAME,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false]
            )->addColumn(
                SellerInterface::FIELD_CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT]
            )->addColumn(
                SellerInterface::FIELD_UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE]
            )->addIndex(
                $setup->getIdxName(
                    SellerInterface::TABLE_NAME,
                    [SellerInterface::FIELD_IDENTIFIER],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [SellerInterface::FIELD_IDENTIFIER],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->setComment(
                'Training - Seller'
            );


        $setup->startSetup();

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
