<?php
namespace Magenest\Movie\Block\Customer\Account;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Filesystem\DirectoryList;

class Image extends Template
{
    protected $_customerSession;
    protected $_filesystem;

    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Filesystem $filesystem,
        array $data = [])
    {
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    public function getImage()
    {
        //1.Get Customer Id
        $customerSession = $this->_customerSession;

        $customerId = $customerSession->getCustomer()->getData('entity_id');
        //2.Get Image Path
            //2.1 Get media Path
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /*$fileSystem = $objectManager->create('\Magento\Framework\Filesystem');
        $mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();*/
        $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        $mediaPath = $storeManager->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            //2.2 Get image Path by CustomerCollection what we found customer Id
        $customerCollection = $objectManager->create('Magento\Customer\Model\CustomerFactory')->create()->getCollection();
        $customerResult = $customerCollection
            ->addAttributeToSelect('my_customer_image')
            ->addAttributeToFilter('entity_id', ['=' => $customerId]);
        $imagePath = $customerResult->getColumnValues('my_customer_image');
        //3.Combine between mediaPath and imagePath
        $customerImagePath = $mediaPath . 'customer' . $imagePath[0];
        return $customerImagePath;
    }
}