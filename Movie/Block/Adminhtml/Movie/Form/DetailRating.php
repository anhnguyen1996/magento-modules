<?php
namespace Magenest\Movie\Block\Adminhtml\Movie\Form;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;

class DetailRating extends Template
{
    public $_request;

    public function __construct(Template\Context $context, RequestInterface $request, array $data = [])
    {
        $this->_request = $request;
        parent::__construct($context, $data);
    }

    public function getRating()
    {
        $movieId = $this->_request->getParam('id');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $movieCollection = $objectManager->create('Magenest\Movie\Model\Movie')->getCollection();
        $movieCollection->addFieldToSelect('rating')->addFieldToFilter('movie_id', ['=' => $movieId]);
        $rating = $movieCollection->getFirstItem()->getData('rating');
        return $rating;
    }
}