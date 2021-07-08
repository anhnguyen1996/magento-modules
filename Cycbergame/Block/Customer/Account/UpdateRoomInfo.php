<?php


namespace Magenest\Cycbergame\Block\Customer\Account;

use Magento\Framework\View\Element\Template;

class UpdateRoomInfo extends Template
{
    protected $_customerSession;

    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        array $data = [])
    {
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getRoom()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $roomColleciton = $objectManager->create('Magenest\Cycbergame\Model\RoomExtraOption')->getCollection();
        return $roomColleciton;
    }

    public function isManager()
    {
        $customerSession = $this->_customerSession;

        $customerId = $customerSession->getCustomer()->getData('entity_id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerCollection = $objectManager->create('Magento\Customer\Model\CustomerFactory')->create()->getCollection();
        $customerCollection = $customerCollection
            ->addAttributeToSelect('is_manager')
            ->addAttributeToFilter('entity_id', ['=' => $customerId]);
        $customerResult = $customerCollection->getFirstItem();
        if ($customerResult->getData('is_manager') == 1) {
            return true;
        }
        return false;
    }
}