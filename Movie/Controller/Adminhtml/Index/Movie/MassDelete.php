<?php
namespace Magenest\Movie\Controller\Adminhtml\Index\Movie;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var MovieCollection
     */
    protected $movieCollection;


    /**
     * @param Context $context
     * @param Filter $filter
     * @param MovieCollection $collection
     */
    public function __construct(Context $context, Filter $filter)
    {
        $this->filter = $filter;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $selected = $this->getRequest()->getPostValue('selected');
        if (is_numeric($selected)) {
            $selected[] = $selected;
        }
        $movieModel = $this->_objectManager->create('Magenest\Movie\Model\Movie');
        $count = count($selected);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $movieModel->load($selected[$i]);
                $movieModel->delete();
            }
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $count));
        } else {
            $this->messageManager->addErrorMessage(__('Delete error'));
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('movie/index/movie');
    }
}