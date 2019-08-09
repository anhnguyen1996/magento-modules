<?php

namespace Magenest\Movie\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Escaper;

class Sendemail extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    protected $escaper;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {

        $this->_request = $request;
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->escaper = $objectManager->create('\Magento\Framework\Escaper');
        //$this->escaper = $escaper;
        parent::__construct($context);
    }


    public function execute()
    {
        $store = $this->_storeManager->getStore()->getId();
        $sender = [
            'name' => $this->escaper->escapeHtml('Anh'),
            'email' => $this->escaper->escapeHtml('ngvutuananh1996@gmail.com'),
        ];
        $transport = $this->_transportBuilder->setTemplateIdentifier('movie_test_template')
            ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
            ->setTemplateVars(
                [
                    'store' => $this->_storeManager->getStore(),
                ]
            )
            //->setFrom('general')
                ->setFrom($sender)
            // you can config general email address in Store -> Configuration -> General -> Store Email Addresses
            ->addTo('isora4396@gmail.com', 'Anh')
            ->getTransport();
        $transport->sendMessage();
        return $this;
    }
}