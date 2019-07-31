<?php
namespace  Magenest\Movie\Controller\Adminhtml\Content;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class FirstContentContainer extends Action
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
        $result->getConfig()->getTitle()->prepend(__('First Contain Container'));
        return $result;
    }
}