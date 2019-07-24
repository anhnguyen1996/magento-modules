<?php
namespace  Magenest\Movie\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Director extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {

        $result = $this->resultPageFactory->create();
        return $result;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::director');
    }
}