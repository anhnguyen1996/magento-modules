<?php
namespace Magenest\Cycbergame\Controller\Room;

class SaveRoom extends \Magento\Framework\App\Action\Action
{
    private $customerSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $request = $this->getRequest();
        $id = $request->getPostValue('id');
        $numberPc = $request->getPostValue('number_pc');
        $address = $request->getPostValue('address');
        $foodPrice = $request->getPostValue('food_price');
        $drinkPrice = $request->getPostValue('drink_price');
        $room = $objectManager->create('Magenest\Cycbergame\Model\RoomExtraOption')->load($id);
        $room->setNumberPc($numberPc);
        $room->setAddress($address);
        $room->setFoodPrice($foodPrice);
        $room->setDrinkPrice($drinkPrice);
        $room->save();
    }
}