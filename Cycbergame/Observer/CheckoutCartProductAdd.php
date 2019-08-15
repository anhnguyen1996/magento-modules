<?php
namespace Magenest\Cycbergame\Observer;

use Magento\Framework\Event\ObserverInterface;

class CheckoutCartProductAdd implements ObserverInterface
{
    /*
     * @var /Prs/Log/LoggerInterface $logger
     */
    protected $logger;
    protected $request;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->logger = $logger;
        $this->request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $account_name = $this->request->getPostValue('account_name');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $objectManager->get(
            'Magenest\Cycbergame\Cookie\Custom2'
        )->set($account_name, 3600);
    }
}