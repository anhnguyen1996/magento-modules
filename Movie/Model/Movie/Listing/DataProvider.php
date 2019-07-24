<?php
namespace Magenest\Movie\Model\Movie\Listing;

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
        array $data = [])
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('Magenest\Movie\Model\Movie');
        $movieCollection = $model->getCollection();
        $movieCollection->join(
            ['d' => 'magenest_director'],
            'main_table.director_id = d.director_id',
            'd.name as director_name'
        );
        $this->collection = $movieCollection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}