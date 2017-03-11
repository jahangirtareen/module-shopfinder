<?php


namespace Tareen\Shopfinder\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table_tareen_shops = $setup->getConnection()->newTable($setup->getTable('tareen_shops'));

        
        $table_tareen_shops->addColumn(
            'shops_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Entity ID'
        );
        

        
        $table_tareen_shops->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'name'
        );
        

        
        $table_tareen_shops->addColumn(
            'identifier',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'identifier'
        );
        

        
        $table_tareen_shops->addColumn(
            'country',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'country'
        );
        

        
        $table_tareen_shops->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'image'
        );
        

        
        $table_tareen_shops->addColumn(
            'store_view',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'store_view'
        );
        

        
        $table_tareen_shops->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'created_at'
        );
        

        $setup->getConnection()->createTable($table_tareen_shops);

        $setup->endSetup();
    }
}
