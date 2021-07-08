<?php
namespace Magenest\Movie\Block\Adminhtml\Content;

use Magento\Framework\View\Element\Template;
use Magenest\Movie\Model\ResourceModel\SetupModule\Collection as SetupModuleCollection;

class FirstContentBlock extends Template
{
    private $_setupModuleCollection;
    protected $fullModuleList;

    public function __construct(
        Template\Context $context,
        SetupModuleCollection $setupModuleCollection,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        array $data = [])
    {
        $this->_setupModuleCollection = $setupModuleCollection;
        $this->fullModuleList = $fullModuleList;
        parent::__construct($context, $data);
    }

    public function getModuleQuantityInstalled()
    {
        $allModules = $this->fullModuleList->getAll();
        /*$setupModuleCollection = $this->_setupModuleCollection;
        $count = $setupModuleCollection->addFieldToFilter('module', ['nlike' => 'Magento%'])->getSize();*/
        $count = 0;
        foreach ($allModules as $key => $value) {
            if(strpos($key, 'Magento') === false) {
                $count++;
            }
        }
        return $count;
    }

    public function getModuleNameInstalled()
    {
        $setupModuleCollection = $this->_setupModuleCollection->addFieldToSelect('module');
        return $setupModuleCollection;
    }
}