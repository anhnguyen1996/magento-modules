<?php
namespace Magenest\Movie\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SetupModule extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('setup_module', 'module');
    }
}