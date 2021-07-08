<?php
namespace Magenest\Cycbergame\Block\Customer\Form;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Block\Form\Edit as CustomerEdit;

class Edit extends CustomerEdit
{
    protected $customerCollectionFactory;
    protected $customerSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        array $data = [])
    {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $customerCollection = $this->customerCollectionFactory->create();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->customerSession = $objectManager->create('Magento\Customer\Model\Session');;
        $customerId = $this->customerSession->getCustomer()->getData('entity_id');

        $customerCollection
            //->addAttributeToSelect(['is_manager'])
            ->addAttributeToFilter('entity_id', ['=', $customerId]);
        $this->resultCustomer = $customerCollection->getFirstItem();
        parent::__construct($context, $customerSession, $subscriberFactory, $customerRepository, $customerAccountManagement, $data);
    }

    public function isManager()
    {
        if ($this->resultCustomer->getData('is_manager') == 1) {
            return true;
        }
        return false;
    }
}