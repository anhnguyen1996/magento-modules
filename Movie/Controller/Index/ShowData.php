<?php
namespace Magenest\Movie\Controller\Index;

use Magento\Framework\App\Action\Action;

class ShowData extends Action
{

    public function execute()
    {
        $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $movieTableName = $resource->getTableName('magenest_movie'); //gives table name with prefix
        $actorTableName = $resource->getTableName('magenest_actor'); //gives table name with prefix
        $directorTableName = $resource->getTableName('magenest_director'); //gives table name with prefix
        $movieActorTableName = $resource->getTableName('magenest_movie_actor'); //gives table name with prefix

       /* SELECT m.name, m.rating, d.name, a.name,
        FROM magenest_movie m, magenest_director d, magenest_actor a, magenest_movie_actor ma
        WHERE m.director_id = d.director_id AND
        ma.movie_id = m.movie_id AND
        ma.actor_id = a.actor_id*/


        $sql = "SELECT m.name as Movie_Name, m.rating as Movie_Rating, d.name as DirectorName, a.name as ActorName FROM ".
            $movieTableName." m, ".
            $directorTableName." d, ".
            $actorTableName." a, ".
            $movieActorTableName." ma ".
            "WHERE m.director_id = d.director_id AND ".
            "ma.movie_id = m.movie_id AND ".
            "ma.actor_id = a.actor_id";

        /*
         * fetchOne – fetches one record from result (usually used for fetching counts etc)
         * fetchRow – get only one row from result (associative array)
         * fetchCol – get non-associative array from result (flat array, usually used for getting a list of values, for example – entity id’s)
         * fetchAll – fetches all records as an array of associative arrays
         * fetchPairs – returns data in an array of key-value pairs, as an associative array with a single entry per row (example: selecting two fields like id and name)
         * */
       /* $result = $connection->fetchAll($sql);
        $displayResult = var_dump($result);
        $displayResult = '<pre>'.$displayResult.'<pre>';
        $this->getResponse()->setBody($displayResult);*/

        $movieCollection = $this->_objectManager->create('Magenest\Movie\Model\Movie')->getCollection();
        $movieCollection->addFieldToSelect(
            [
                'name',
                'rating'
            ]
        )->join(
            ['d' => $directorTableName],
            'main_table.director_id = d.director_id',
            'd.name'
        )->join(
            ['ma' => $movieActorTableName],
            'ma.movie_id = main_table.movie_id',
            null
        )->join(
            ['a' => $actorTableName],
            'ma.actor_id = a.actor_id',
            'a.name'
        );

        $output = '';
        foreach ($movieCollection as $movie) {
            $output .= \Zend_Debug::dump($movie->debug(), null,
                false);
        }

        $this->getResponse()->setBody($output);
    }
}