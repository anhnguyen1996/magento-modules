<?php
namespace Magenest\Movie\Block\Customer\Account;

use Magento\Framework\View\Element\Template;

class EditCustomer extends Template
{
    private $customerCollectionFactory;
    private $firstName;
    private $lastName;
    private $resultCustomer;
    private $customerSession;

    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        array $data = [])
    {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $customerCollection = $this->customerCollectionFactory->create();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->customerSession = $objectManager->create('Magento\Customer\Model\Session');;

        $customerId = $this->customerSession->getCustomer()->getData('entity_id');
        $customerCollection
            ->addAttributeToSelect(['firstname','lastname'])
            ->addAttributeToFilter('entity_id', ['=', $customerId]);
        $this->resultCustomer = $customerCollection->getFirstItem();
        parent::__construct($context, $data);
    }

    public function getFirstName()
    {
        $this->firstName = $this->resultCustomer->getData('firstname');
        return $this->firstName;
    }

    public function getLastName()
    {
        $this->lastName = $this->resultCustomer->getData('lastname');
        return $this->lastName;
    }

    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomer()->getData('entity_id');
        return $customerId;
    }
}