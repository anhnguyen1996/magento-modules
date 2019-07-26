<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveCustomerObserver implements ObserverInterface
{
    /*
     * @var /Prs/Log/LoggerInterface $logger
     */
    protected $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->logger->debug('Save Customer');
        $observer->getCustomer()->setFirstname('Magenest');
        $observer->getCustomer()->setLastname('Company');
    }
}