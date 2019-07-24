<?php
namespace Magenest\Movie\Model\System;

use Magento\Framework\Data\OptionSourceInterface;

class Movie extends \Magento\Framework\DataObject implements OptionSourceInterface
{

    public function getDirectorValuesForForm($empty = false)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $directorCollection = $objectManager->create('Magenest\Movie\Model\Director')->getCollection();
        $options = [];
        if ($empty) {
            $options[] = ['label' => '', 'value' => ''];
        }
        foreach ($directorCollection as $director) {
            $options[] = [
                'label' => $director->getData('name'),
                'value' => $director->getData('director_id')
            ];
        }
        return $options;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return $this->getDirectorValuesForForm();
    }
}