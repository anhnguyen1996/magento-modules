<?php
namespace Magenest\Cycbergame\Observer;

use Magento\Framework\Event\ObserverInterface;

class AddNewGamerAccount implements ObserverInterface
{
    /*
     * @var /Prs/Log/LoggerInterface $logger
     */
    protected $logger;
    protected  $collectionFactory;

    public function __construct(\Psr\Log\LoggerInterface $logger, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory)
    {
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cookie = $objectManager->get(
            'Magenest\Cycbergame\Cookie\Custom2'
        );
        $accountName = $cookie->get();
        $gamerAccountListModel = $objectManager->create('Magenest\Cycbergame\Model\GamerAccountList');
        $gamerAccountListCollection = $gamerAccountListModel->getCollection()->addFieldToFilter('account_name', ['=' => $accountName]);
        $existAccount = $gamerAccountListCollection;
        if (count($existAccount->getItems()) != 0) {
            $gamerAccountListModel->load($existAccount->getFirstItem()->getData('id'));
        }
        $gamerAccountListModel->setData('product_id', $observer->getData('order')->getItems()[0]->getData('product_id'));
        $gamerAccountListModel->setData('name', $observer->getData('order')->getData('customer_firstname'));
        $gamerAccountListModel->setData('account_name', $accountName);
        $gamerAccountListModel->setData('password','1');
        $oldHour = (int)$existAccount->getFirstItem()->getData('hour');
        $newHour = (int)$observer->getData('order')->getData('total_qty_ordered');
        $gamerAccountListModel->setData('hour', $oldHour + $newHour);
        $gamerAccountListModel->save();
    }
}