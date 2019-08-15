<?php
namespace Magenest\Cycbergame\Observer;

use Magento\Framework\Event\ObserverInterface;

class ProductSaveObserver implements ObserverInterface
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
        $roomObserver = $observer->getProduct();
        $typeId = $roomObserver->getData('type_id');
        if ($typeId == 'simple') {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $roomModel = $objectManager->create('Magenest\Cycbergame\Model\RoomExtraOption');
            $productId = null;
            if ($roomObserver->getData('entity_id')=='') {
                $productCollection = $this->collectionFactory->create()
                    ->addAttributeToSelect('entity_id')
                    ->setOrder('entity_id','DESC')
                    ->setPageSize(1);
                $productId = $productCollection->getFirstItem()->getData('entity_id');
                $productId++;
            } else {
                $productId = $roomObserver->getData('entity_id');
                $roomColleciton = $roomModel->getCollection();
                $roomColleciton
                    ->addFieldToSelect('id')
                    ->addFieldToFilter('product_id', ['=' => $productId]);
                $roomResult = $roomColleciton->getFirstItem();
                $roomModel->load($roomResult->getData('id'));
            }
            $roomModel->setData('name', $roomObserver->getData('name'));
            $roomModel->setData('product_id',$productId);
            $roomModel->setData('number_pc', $roomObserver->getData('quantity_and_stock_status')['qty']);
            $roomModel->setData('address','no address');
            $roomModel->setData('food_price',0);
            $roomModel->setData('drink_price',0);
            $roomModel->save();
        }
    }
}