<?php
namespace Magenest\Movie\Controller\Adminhtml\Index\Movie;

class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $movieModel = $this->_objectManager->create('Magenest\Movie\Model\Movie');
        $data = $this->getRequest()->getPostValue();
        if($data)
        {
            $id = $data['movie_id'];
            if ($id != '') {
                $movieModel = $movieModel->load($id);
            }
            try{
                $data = array_filter($data, function($value) {return $value !== ''; });
                $movieModel->setData($data);
                $movieModel->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('movie/index/movie');
            }
            catch(\Exception $d)
            {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('movie/index/movie/edit', ['id' => $movieModel->getId()]);
            }
        }
        return $resultRedirect->setPath('movie/index/movie');
    }
}
