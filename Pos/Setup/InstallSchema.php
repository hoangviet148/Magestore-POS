<?php

namespace Learning\Pos\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    /**
     * @inheritDoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Create table 'staff'
         */
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('pos_staff')) {

            $table = $installer->getConnection()->newTable(
                $installer->getTable('pos_staff')
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Staff ID'
            )
                ->addColumn(
                    'username',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable' => false],
                    'username Staff'
                )->addColumn(
                    'password',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable' => false],
                    'Password Staff'
                )->addColumn(
                    'email',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable' => false],
                    'Email Staff'
                )->addColumn(
                    'telephone',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    ['nullable' => false],
                    'Telephone Staff'
                )->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => true],
                    'Status Staff'
                )->setComment("Staff table");
            $installer->getConnection()->createTable($table);
            echo 'DONE';
        }
        $setup->endSetup();
    }
}
