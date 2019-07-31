<?php
namespace Magenest\Movie\Block\Adminhtml\Content;

use Magento\Framework\View\Element\Template;
use Magenest\Movie\Model\ResourceModel\SetupModule\Collection as SetupModuleCollection;

class FirstContentBlock extends Template
{
    private $_setupModuleCollection;

    public function __construct(
        Template\Context $context,
        SetupModuleCollection $setupModuleCollection,
        array $data = [])
    {
        $this->_setupModuleCollection = $setupModuleCollection;
        parent::__construct($context, $data);
    }

    public function getModuleQuantityInstalled()
    {
        $setupModuleCollection = $this->_setupModuleCollection;
        $count = $setupModuleCollection->addFieldToFilter('module', ['nlike' => 'Magento%'])->getSize();
        return $count;
    }

    public function getModuleNameInstalled()
    {
        $setupModuleCollection = $this->_setupModuleCollection->addFieldToSelect('module');
        return $setupModuleCollection;
    }

}