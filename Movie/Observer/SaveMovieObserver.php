<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveMovieObserver implements ObserverInterface
{
    /*
     * @var /Prs/Log/LoggerInterface $logger
     */
    protected $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->logger->debug('Save Movie');
        $id = $observer->getId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $movie = $objectManager->create('Magenest\Movie\Model\Movie')->load($id);
        $movie->setRating(0);
        $movie->save();
    }
}