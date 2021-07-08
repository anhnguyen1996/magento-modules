<?php
namespace Magenest\Cycbergame\Model\ResourceModel\GamerAccountList;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magenest\Cycbergame\Model\GamerAccountList','Magenest\Cycbergame\Model\ResourceModel\GamerAccountList');
    }
}