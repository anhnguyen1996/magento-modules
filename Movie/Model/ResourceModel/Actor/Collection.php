<?php
namespace Magenest\Movie\Model\ResourceModel\Actor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Actor','Magenest\Movie\Model\ResourceModel\Actor');
    }
}