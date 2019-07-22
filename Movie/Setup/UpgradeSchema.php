<?php
namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        //First create primarily Director Table
       /* if (version_compare($context->getVersion(), '2.0.1') < 0) {
            $connection = $setup->getConnection();
            $magenestMovieTable = $this->createMagenestMovieTable($setup, $connection);
            $connection->createTable($magenestMovieTable);
        }*/

        //After create Movie Table
        if (version_compare($context->getVersion(), '2.0.2') < 0) {
            $connection = $setup->getConnection();
            $magenestMovieActorTable = $this->createMagenestMovieActorTable($setup, $connection);
            $connection->createTable($magenestMovieActorTable);
        }
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param AdapterInterface $connection
     * @return Table
     */
    private function createMagenestMovieTable(SchemaSetupInterface $setup, AdapterInterface $connection)
    {

        $table = $connection->newTable($setup->getTable('magenest_movie'));
        $table->addColumn(
            'movie_id',
            Table::TYPE_INTEGER,
            null,
            [
                'primary' => true,
                'identity' => true,
                'nullable' => false,
                'unsigned' => true
            ],
            'Movie Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [],
            'Movie Name'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            255,
            [],
            'Movie Description'
        )->addColumn(
            'rating',
            Table::TYPE_INTEGER,
            null,
            [],
            'Movie Rating'
        )->addColumn(
            'director_id',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true
            ],
            'Director Id'
        )
        ->addForeignKey(
            $setup->getFkName(
                'magenest_movie',
                'director_id',
                'magenest_director',
                'director_id'
            ),
            'director_id',
            $setup->getTable('magenest_director'),
            'director_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );
        return $table;
    }

    /**
     * @param SchemaSetupInterface $setup
     * @param AdapterInterface $connection
     * @return Table
     */
    private function createMagenestMovieActorTable(SchemaSetupInterface $setup, AdapterInterface $connection)
    {
        $table = $connection->newTable($setup->getTable('magenest_movie_actor'));
        $table->addColumn(
            'movie_id',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true
            ],
            'Movie Id'
        )->addColumn(
            'actor_id',
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'unsigned' => true
            ],
            'Actor Id'
        )->addForeignKey(
            $setup->getFkName(
                'magenest_movie_actor',
                'movie_id',
                'magenest_movie',
                'movie_id'
            ),
            'movie_id',
            $setup->getTable('magenest_movie'),
            'movie_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName(
                'magenest_movie_actor',
                'actor_id',
                'magenest_actor',
                'actor_id'
            ),
            'actor_id',
            $setup->getTable('magenest_actor'),
            'actor_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );
        return $table;
    }
}