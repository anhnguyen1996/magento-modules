<?php
namespace Magenest\Movie\Plugin\Catalog;

class CartAfter
{
    public function aroundGetItemData($subject, $proceed, $item)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $result = $proceed($item);
        $sku = $result['product_sku'];
        $productRepositoryFactory = $objectManager->create('Magento\Catalog\Model\ProductRepository');
        $product = $productRepositoryFactory->get($sku);
        //get Image url
        $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        $productImageUrl = $storeManager->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getSmallImage();
        //set Name
        $result['product_name'] = $product->getName();
        $result['product_image']['src'] = $productImageUrl;
        return $result;
    }
}