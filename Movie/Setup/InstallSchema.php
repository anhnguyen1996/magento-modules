<?php
namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        //First create primarily Director Table
        $setup->startSetup();
        $connection = $setup->getConnection();
        $magenestDirectorTable = $this->createMagenestDirectorTable($setup, $connection);
        $connection->createTable($magenestDirectorTable);
        //After create Actor Table
        $connection = $setup->getConnection();
        $magenestActorTable = $this->createMagenestActorTable($setup, $connection);
        $connection->createTable($magenestActorTable);
        $setup->endSetup();
    }


    /**
     * @param SchemaSetupInterface $setup
     * @param AdapterInterface $connection
     * @return Table
     */
    private function createMagenestDirectorTable(SchemaSetupInterface $setup, AdapterInterface $connection)
    {
        $table = $connection->newTable($setup->getTable('magenest_director'));
        $table->addColumn(
            'director_id',
            Table::TYPE_INTEGER,
            null,
            [
                'primary' => true,
                'identity' => true,
                'nullable' => false,
                'unsigned' => true
            ],
            'Director Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [],
            'Director Name'
        );
        return $table;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param AdapterInterface $connection
     * @return Table
     */
    private function createMagenestActorTable(SchemaSetupInterface $setup, AdapterInterface $connection)
    {
        $table = $connection->newTable($setup->getTable('magenest_actor'));
        $table->addColumn(
            'actor_id',
            Table::TYPE_INTEGER,
            null,
            [
                'primary' => true,
                'identity' => true,
                'nullable' => false,
                'unsigned' => true
            ],
            'Actor Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [],
            'Actor Name'
        );
        return $table;
    }
}