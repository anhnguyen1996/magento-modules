<?php
namespace Magenest\Movie\Controller\Ko;

class SearchMovie extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $movieModel = $this->_objectManager->create('Magenest\Movie\Model\Movie');
        /*
         * @var \Magenest\Movie\Model\ResourceModel\Movie\Collection $movieCollection
         * */
        $nameRequest = $this->getRequest()->getParam('name');
        $movieCollection = $movieModel->getCollection();
        if ($nameRequest != "") {
            $movieCollection = $movieCollection->AddFieldToFilter('name', ['like' => "%".$nameRequest."%"]);
        }
        $movieResult = $movieCollection->getItems();
        $movieList = [];
        foreach ($movieResult as $movie) {
            $movieId = $movie->getData('movie_id');
            $movieName = $movie->getData('name');
            $movieDescription = $movie->getData('description');
            $movieRating = $movie->getData('rating');
            $movieObject = [
                'movie_id' => $movieId,
                'name' => $movieName,
                'description' => $movieDescription,
                'rating' => $movieRating
            ];
            $movieList[] = $movieObject;
        }
        echo json_encode($movieList);
    }
}