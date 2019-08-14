<?php
namespace Magenest\Cycbergame\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();
        $gamerAccountListTable = $this->createGamerAccountListTable($setup, $connection);
        $connection->createTable($gamerAccountListTable);
        $connection = $setup->getConnection();
        $roomExtraOptionTable = $this->createRoomExtraOptionTable($setup, $connection);
        $connection->createTable($roomExtraOptionTable);
        $setup->endSetup();
    }


    /**
     * @param SchemaSetupInterface $setup
     * @param AdapterInterface $connection
     * @return Table
     */
    private function createGamerAccountListTable(SchemaSetupInterface $setup, AdapterInterface $connection)
    {
        $table = $connection->newTable($setup->getTable('gamer_account_list'));
        $table->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            [
                'primary' => true,
                'identity' => true,
                'nullable' => false,
                'unsigned' => true
            ],
            'Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'name'
        )->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true
            ],
            'product_id'
        )->addColumn(
            'account_name',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'account_name'
        )->addColumn(
            'password',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'Password'
        )->addColumn(
            'hour',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true
            ],
            'Hour'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ],
            'created_at'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ],
            'updated_at'
        )->addIndex(
            $setup->getIdxName(
                'gamer_account_list', ['product_id']
            ),
            ['product_id']
        )->addIndex(
            $setup->getIdxName(
                'gamer_account_list', ['account_name']
            ),
            ['account_name']
        );
        return $table;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param AdapterInterface $connection
     * @return Table
     */
    private function createRoomExtraOptionTable(SchemaSetupInterface $setup, AdapterInterface $connection)
    {
        $table = $connection->newTable($setup->getTable('room_extra_option'));
        $table->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            [
                'primary' => true,
                'identity' => true,
                'nullable' => false,
                'unsigned' => true
            ],
            'Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'name'
        )->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true
            ],
            'product_id'
        )->addColumn(
            'number_pc',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true
            ],
            'Hour'
        )->addColumn(
            'address',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'address'
        )->addColumn(
            'food_price',
            Table::TYPE_INTEGER,
            null,
            [
                'unsigned' => true
            ],
            'food_price'
        )->addColumn(
            'drink_price',
            Table::TYPE_INTEGER,
            null,
            [
                'unsigned' => true
            ],
            'drink_price'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ],
            'created_at'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ],
            'updated_at'
        )->addIndex(
            $setup->getIdxName(
                'gamer_account_list', ['product_id']
            ),
            ['product_id']
        );
        return $table;
    }
}