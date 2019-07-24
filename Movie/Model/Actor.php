<?php
namespace Magenest\Movie\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Customer\Ui\Component\Listing\Column\Websites;

class Actor extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\ResourceModel\Actor');
    }
}
