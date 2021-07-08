<?php
namespace Magenest\Movie\Controller\Jquery;

class SaveCustomer extends \Magento\Framework\App\Action\Action
{
    private $customerRepository;
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
        $request = $this->getRequest();
        $customerId = $request->getPostValue('id');
        $firstName = $request->getPostValue('firstname');
        $lastName = $request->getPostValue('lastname');
        $customer = $this->customerRepository->getById($customerId);
        $customer->setFirstname($firstName);
        $customer->setLastname($lastName);
        $this->customerRepository->save($customer);
    }
}