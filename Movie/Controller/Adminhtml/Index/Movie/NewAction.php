<?php
namespace Magenest\Movie\Controller\Adminhtml\Index\Movie;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;


class  NewAction extends Action
{
    private $resultPageFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultPageFactory->create();
        $result->getConfig()->getTitle()->prepend(__('New Movie'));
        return $result;
    }
}