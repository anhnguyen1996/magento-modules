<?php
namespace Magenest\Movie\Controller\Ko;

class SaveCustomer extends \Magento\Framework\App\Action\Action
{
    private $customerCollectionFactory;
    private $customerRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $request = $this->getRequest();
        $customerId = $request->getParam('id');
        $firstName = $request->getParam('firstname');
        $lastName = $request->getParam('lastname');
        $customer = $this->customerRepository->getById($customerId);
        $customer->setFirstname($firstName);
        $customer->setLastname($lastName);
        $this->customerRepository->save($customer);
    }
}