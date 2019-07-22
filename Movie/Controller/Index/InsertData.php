<?php
namespace Magenest\Movie\Controller\Index;

use Magento\Framework\App\Action\Action;

class InsertData extends Action
{

    public function execute()
    {
        //Step 1
        //$this->insertDataToActorTable();
        //$this->insertDataToDirectorTable();

        //Step 2
        //$this->insertDataToMovieTable();

        //Step 3
        //$this->insertDataToMovieActorTable();
    }

    private function insertDataToActorTable()
    {
        $actorData = [
            ['name' => 'Anh'],
            ['name' => 'Bao'],
            ['name' => 'Chuong'],
            ['name' => 'Dung']
        ];
        foreach ($actorData as $actorDataElememt) {
            $actorModel = $this->_objectManager->create('Magenest\Movie\Model\Actor');
            foreach ($actorDataElememt as $key => $value) {
                if ($key == 'name') {
                    $actorModel->setName($value);
                }
            }
            $actorModel->save();
        }
    }

    private function insertDataToDirectorTable()
    {
        $directorData = [
            ['name' => 'DirectorA'],
            ['name' => 'DirectorB']
        ];
        foreach ($directorData as $directorDataElememt) {
            $directorModel = $this->_objectManager->create('Magenest\Movie\Model\Director');
            foreach ($directorDataElememt as $key => $value) {
                if ($key == 'name') {
                    $directorModel->setName($value);
                }
            }
            $directorModel->save();
        }
    }

    private function insertDataToMovieTable()
    {
        $movieData = [
            [
                'name' => 'Interstellar',
                'description' => 'This is movie about human survival at galaxy',
                'rating' => 9,
                'director_id' => 1
            ],
            [
                'name' => 'Chernobyl',
                'description' => 'Movie talk about nuclear disaster at Chernobyl Moscov',
                'rating' => 8,
                'director_id' => 2
            ]
        ];
        foreach ($movieData as $movieDataElememt) {
            $movieModel = $this->_objectManager->create('Magenest\Movie\Model\Movie');
            foreach ($movieDataElememt as $key => $value) {
                if ($key == 'name') {
                    $movieModel->setName($value);
                }
                if ($key == 'description') {
                    $movieModel->setDescription($value);
                }
                if ($key == 'rating') {
                    $movieModel->setRating($value);
                }
                if ($key == 'director_id') {
                    $movieModel->setDirectorId($value);
                }
            }
            $movieModel->save();
        }
    }

    private function insertDataToMovieActorTable()
    {
        $movieActorData = [
            ['movie_id' => 1, 'actor_id' => 1],
            ['movie_id' => 1, 'actor_id' => 2],
            ['movie_id' => 2, 'actor_id' => 3],
            ['movie_id' => 2, 'actor_id' => 4]
        ];
        foreach ($movieActorData as $movieActorDataElememt) {
            $movieActorModel = $this->_objectManager->create('Magenest\Movie\Model\MovieActor');
            foreach ($movieActorDataElememt as $key => $value) {
                if ($key == 'movie_id') {
                    $movieActorModel->setMovieId($value);
                }
                if ($key == 'actor_id') {
                    $movieActorModel->setActorId($value);
                }
            }
            $movieActorModel->save();
        }
    }
}