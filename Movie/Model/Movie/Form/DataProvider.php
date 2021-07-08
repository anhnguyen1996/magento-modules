<?php
namespace Magenest\Movie\Model\Movie\Form;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var array
     */
    protected $_loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('Magenest\Movie\Model\Movie');
        $movieCollection = $model->getCollection();
        $this->collection = $movieCollection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }


    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->collection->getItems();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        foreach ($items as $movie) {
            //get Actor ID
            $movieId = null;
            $movieId = $movie->getData('movie_id');
            /** @var \Magenest\Movie\Model\ResourceModel\Actor\Collection $actorColelction*/
            $actorColelction = $objectManager->create('Magenest\Movie\Model\Actor')->getCollection();;
            $actorColelction
                ->join(
                    ['ma' => 'magenest_movie_actor'],
                    'main_table.actor_id = ma.actor_id',
                    null
                )->join(
                    ['m' => 'magenest_movie'],
                    'ma.movie_id = m.movie_id',
                    'm.movie_id'
                )->addFieldToFilter('m.movie_id', ['=' => $movieId]);
            $actorItems = $actorColelction->getItems();
            $actorIds = [];
            foreach ($actorItems  as $item) {
                $actorIds[] = $item->getData('actor_id');
            }
            //set ActorID for Movie Collection
            $movie->addData(['actor_id' => $actorIds]);
            $this->_loadedData[$movieId] = $movie->getData();
        }
        return $this->_loadedData;
    }
}