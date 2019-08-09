<?php
namespace Magenest\Movie\Controller\Adminhtml\Index\Movie;

class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $movieModel = $this->_objectManager->create('Magenest\Movie\Model\Movie');
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $data['movie_id'];
            if ($id != '') {
                $movieModel = $movieModel->load($id);
            }
            try {
                $data = array_filter($data, function($value) {return $value !== ''; });
                $movieModel->setData($data);
                $movieModel->save();

                //start add new actor for movie
                if (isset($data['actor_id'])) {
                    $actorIds = [];
                    $actorIds = $data['actor_id'];
                    $movieId = null;
                    if($id == ''){
                        $movieId = $this->getNewId();
                    }else {
                        $movieId = $id;
                    }
                    $this->deleteAllRecordByMovieId($movieId);
                    for ($i = 0; $i < count($actorIds); $i++) {
                        $movieActorModel = $this->_objectManager->create('Magenest\Movie\Model\MovieActor');
                        $movieActorModel->setMovieId($movieId);
                        $movieActorModel->setActorId($actorIds[$i]);
                        $movieActorModel->save();
                    }
                }
                //end add new actor for movie

                //event Chapter 7 test
                if ($id == '') {
                    $newId = $this->getNewId();
                    $parameter = [
                        'id' => $newId
                    ];
                    $this->_eventManager->dispatch('set_movie_raring_equal_zero', $parameter);
                }
                //end event

                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('movie/index/movie');
            }
            catch (\Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('movie/index/movie/edit', ['id' => $movieModel->getId()]);
            }
        }
        return $resultRedirect->setPath('movie/index/movie');
    }

    private function getNewId()
    {
        $movieModel = $this->_objectManager->create('Magenest\Movie\Model\Movie');
        $collectionMovieToGetNewId =
            $movieModel->getCollection()
                ->addFieldToSelect('movie_id')
                ->setOrder('movie_id','DESC')
                ->setPageSize(1);
        //get New Movie Id to pass into observer, after edit Rating at Observer
        $newId = $collectionMovieToGetNewId->getFirstItem()->getData('movie_id');
        return $newId;
    }

    private function checkInvalidInSertMovieActor($movieId, $actorId)
    {
        $movieActorModel = $this->_objectManager->create('Magenest\Movie\Model\MovieActor');
        $movieActorCollection = $movieActorModel->getCollection();
        $movieActorCollection
            ->addFieldToFiler('movie_id',['=', $movieId])
            ->addFieldToFiler('actor_id',['=', $actorId]);
        $size = $movieActorCollection->getSize();
        if ($size > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function deleteAllRecordByMovieId($movieId)
    {
        $sql = 'DELETE FROM magenest_movie_actor WHERE movie_id = '.$movieId;
        $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $connection->query($sql);
    }
}
