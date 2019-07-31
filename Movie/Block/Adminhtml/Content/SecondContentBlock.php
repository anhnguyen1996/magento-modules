<?php
namespace Magenest\Movie\Block\Adminhtml\Content;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory as InvoiceCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory as CreditmemoCollectionFactory;

class SecondContentBlock extends Template
{
    protected $_productCollectionFactory;
    protected $_customerCollectionFactory;
    protected $_orderCollectionFactory;
    protected $_invoiceCollectionFactory;
    protected $_creditmemoCollectionFactory;

    public function __construct(
        Template\Context $context,
        ProductCollectionFactory $productCollectionFactory,
        CustomerCollectionFactory $customerCollectionFactory,
        OrderCollectionFactory $orderCollectionFactory,
        InvoiceCollectionFactory $invoiceCollectionFactory,
        CreditmemoCollectionFactory $creditmemoCollectionFactory,
        array $data = [])
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        $this->_invoiceCollectionFactory = $invoiceCollectionFactory;
        $this->_creditmemoCollectionFactory = $creditmemoCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getCustomerQuantity()
    {
        $customerCollection = $this->_customerCollectionFactory->create();
        $size = $customerCollection->getSize();
        return $size;
    }

    public function getOrderQuantity()
    {
        $orderCollection = $this->_orderCollectionFactory->create();
        $size = $orderCollection->getSize();
        return $size;
    }

    public function getProductQuantity()
    {
        $productCollection = $this->_productCollectionFactory->create();
        $size = $productCollection->getSize();
        return $size;
    }

    public function getInvoiceQuantity()
    {
        $invoiceCollection = $this->_invoiceCollectionFactory->create();
        $size = $invoiceCollection->getSize();
        return $size;
    }

    public function getCreditMemoQuantity()
    {
        $creditmemoCollection = $this->_creditmemoCollectionFactory->create();
        $size = $creditmemoCollection->getSize();
        return $size;
    }

}