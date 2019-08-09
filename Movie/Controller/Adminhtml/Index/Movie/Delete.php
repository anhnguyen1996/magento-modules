<?php
namespace Magenest\Movie\Controller\Adminhtml\Index\Movie;


use Magento\Backend\App\Action;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $movieModel;
    protected $movieActorModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magenest\Movie\Model\Movie $movieModel,
        \Magenest\Movie\Model\MovieActor $movieActorModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->movieModel = $movieModel;
        $this->movieActorModel = $movieActorModel;
        parent::__construct($context);
    }

    public function execute()
    {

        $id = $this->getRequest()->getParam('id');
        //$this->movieModel = $this->_objectManager->create('Magenest\Movie\Model\Movie');
        $movie = $this->movieModel->load($id);
        if(!$movie)
        {
            $this->messageManager->addError(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('movie/index/movie', array('_current' => true));
        }

        try{
            $movie->delete();
            $this->messageManager->addSuccess(__('Your contact has been deleted !'));
        }
        catch(\Exception $e)
        {
            $this->messageManager->addError(__('Error while trying to delete contact'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('movie/index/movie', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('movie/index/movie', array('_current' => true));
    }
}