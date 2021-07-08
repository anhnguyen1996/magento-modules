<?php
namespace Magenest\Cycbergame\Model;

class GamerAccountList extends \Magento\Framework\Model\AbstractModel
{
    public function _construct() {
        $this->_init('Magenest\Cycbergame\Model\ResourceModel\GamerAccountList');
    }
}