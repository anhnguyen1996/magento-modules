<?php
namespace Magenest\Movie\Block;

use Magento\Framework\View\Element\Template;

class MovieData extends Template
{
    public function getMovieDataByDirectSQL()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $movieTableName = $resource->getTableName('magenest_movie'); //gives table name with prefix
        $actorTableName = $resource->getTableName('magenest_actor'); //gives table name with prefix
        $directorTableName = $resource->getTableName('magenest_director'); //gives table name with prefix
        $movieActorTableName = $resource->getTableName('magenest_movie_actor'); //gives table name with prefix
        $sql = "SELECT m.name as Movie_Name, m.rating as Movie_Rating, d.name as DirectorName, a.name as ActorName FROM ".
            $movieTableName." m, ".
            $directorTableName." d, ".
            $actorTableName." a, ".
            $movieActorTableName." ma ".
            "WHERE m.director_id = d.director_id AND ".
            "ma.movie_id = m.movie_id AND ".
            "ma.actor_id = a.actor_id";

        $result = $connection->fetchAll($sql);
        return $result;
    }

    public function getMovieDataByCollectionSQL()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $movieTableName = $resource->getTableName('magenest_movie'); //gives table name with prefix
        $actorTableName = $resource->getTableName('magenest_actor'); //gives table name with prefix
        $directorTableName = $resource->getTableName('magenest_director'); //gives table name with prefix
        $movieActorTableName = $resource->getTableName('magenest_movie_actor'); //gives table name with prefix

        $movieCollection = $objectManager->create('Magenest\Movie\Model\Movie')->getCollection();
        $movieCollection->addFieldToSelect(
            [
                'name',
                'rating'
            ]
        )->join(
            ['d' => $directorTableName],
            'main_table.director_id = d.director_id',
            'd.name as director_name'
        );
        //->join(
        //            ['a' => $actorTableName],
        //            'ma.actor_id = a.actor_id',
        //            'a.name as Actor Name'
        //        )
        return $movieCollection;
    }
}