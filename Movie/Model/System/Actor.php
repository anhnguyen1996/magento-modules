<?php
namespace Magenest\Movie\Model\System;

use Magento\Framework\Data\OptionSourceInterface;

class Actor implements OptionSourceInterface
{

    public function getActorValuesForForm($empty = false)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $actorCollection = $objectManager->create('Magenest\Movie\Model\Actor')->getCollection();
        $options = [];
        if ($empty) {
            $options[] = ['label' => '', 'value' => ''];
        }
        foreach ($actorCollection as $actor) {
            $options[] = [
                'label' => $actor->getData('name'),
                'value' => $actor->getData('actor_id')
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
        return $this->getActorValuesForForm();
    }
}