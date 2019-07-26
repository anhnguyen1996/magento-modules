<?php
namespace Magenest\Movie\Model\Config\Backend;

use Magento\Framework\App\Config\Value;

class TextField extends \Magento\Framework\App\Config\Value
{
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [])
    {
        $this->_scopeConfig = $config;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    protected function _afterLoad()
    {
        $value = $this->_scopeConfig->getValue('section_movie/group_movie/text_field', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $this->setValue ($value);
    }
}