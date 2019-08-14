<?php
namespace Magenest\Cycbergame\Block\Customer\Account;

use Magento\Framework\View\Element\Template;

class EditRoomInfo extends Template
{
    protected $_resultRoom;

    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $request = $objectManager->create('Magento\Framework\App\RequestInterface');
        $id = $request->getParam('id');
        $roomCollection = $objectManager->create('Magenest\Cycbergame\Model\RoomExtraOption')->getCollection();
        $roomCollection->addFieldToFilter('id', ['=' => $id]);
        $this->_resultRoom = $roomCollection->getFirstItem();
        parent::__construct($context, $data);
    }


    public function getId()
    {
        return $this->_resultRoom->getData('id');
    }

    public function getName()
    {
        return $this->_resultRoom->getData('name');
    }

    /*public function getPrice()
    {
        return $this->_resultRoom->getData('price');
    }*/

    public function getAddress()
    {
        return $this->_resultRoom->getData('address');
    }

    public function getNumberPc()
    {
        return $this->_resultRoom->getData('number_pc');
    }

    public function getFoodPrice()
    {
        return $this->_resultRoom->getData('food_price');
    }

    public function getDrinkPrice()
    {
        return $this->_resultRoom->getData('drink_price');
    }
}