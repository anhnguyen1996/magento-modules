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
        array $data = [])
    {

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
        foreach ($items as $movie) {
            $this->_loadedData[$movie->getId()] = $movie->getData();
        }
        return $this->_loadedData;
    }
}