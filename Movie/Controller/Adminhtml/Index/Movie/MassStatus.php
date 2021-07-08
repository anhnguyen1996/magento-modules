<?php
namespace Magenest\Movie\Controller\Adminhtml\Index\Movie;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magenest\Movie\Model\ResourceModel\Movie\Collection as MovieCollection;

class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /*
     * @var MovieCollection
     * */
    protected  $movieCollection;

    /**
     * @param Context $context
     * @param Filter $filter
     *
     */
    public function __construct(Context $context, Filter $filter, MovieCollection $movieCollection)
    {
        $this->filter = $filter;
        $this->movieCollection = $movieCollection;
        parent::__construct($context);
    }

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
                $movieModel->setData('status', $this->getRequest()->getParam('status'));
                $movieModel->save();
            }
            $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $count));
        } else {
            $this->messageManager->addErrorMessage(__('Update error'));
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('movie/index/movie');
    }
}