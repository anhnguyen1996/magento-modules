<?php
namespace Magenest\Movie\Model\Config\Backend;

use Magento\Framework\App\Config\Value;

class ActorRowsTextField extends \Magento\Framework\App\Config\Value
{
    protected function _afterLoad()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $actorModel = $objectManager->create('Magenest\Movie\Model\Actor');
        $actorCollection = $actorModel->getCollection();
        $size = $actorCollection->getSize();
        $this->setValue($size);
    }
}