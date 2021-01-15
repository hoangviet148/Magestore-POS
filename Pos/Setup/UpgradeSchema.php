<?php

namespace Learning\Pos\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('pos_staff'),
                'name',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 50,
                    'nullable' => false,
                    'comment' => 'Name Staff'
                ]
            );
        }
        $setup->endSetup();
    }
}
