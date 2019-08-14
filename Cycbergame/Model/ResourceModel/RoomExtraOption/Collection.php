<?php
namespace Magenest\Cycbergame\Model\ResourceModel\RoomExtraOption;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Cycbergame\Model\RoomExtraOption','Magenest\Cycbergame\Model\ResourceModel\RoomExtraOption');
    }
}