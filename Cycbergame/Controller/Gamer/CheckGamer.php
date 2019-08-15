<?php
namespace  Magenest\Cycbergame\Controller\Gamer;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;

class CheckGamer extends Action
{
    public function __construct(\Magento\Framework\App\Action\Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $accountName = $this->getRequest()->getPostValue('account_name');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $gamerAccountListModel = $objectManager->create('Magenest\Cycbergame\Model\GamerAccountList');
        $gamerAccountListCollection = $gamerAccountListModel->getCollection()->addFieldToFilter('account_name', $accountName);
        if($accountName != '') {
            if ( count($gamerAccountListCollection->getItems()) != 0) {
                echo '<p style="color:red">Account was exist in oursystem. You are buying hour for this acocunt</p>';
            } else {
                echo '<p style="color:blue">We will createnew account for you.Default password = 1. You should change the password afterlogin</p>';

            }
        }
    }
}