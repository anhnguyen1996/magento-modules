<?php
namespace Magenest\Movie\Model\ResourceModel\SetupModule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\SetupModule', 'Magenest\Movie\Model\ResourceModel\SetupModule');
    }
}