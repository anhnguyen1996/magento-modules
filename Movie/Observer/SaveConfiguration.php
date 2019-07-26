<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveConfiguration implements ObserverInterface
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

        $pathChanges = $observer->getChangedPaths();
        foreach ($pathChanges as $path) {
            if ($path == 'section_movie/group_movie/text_field') {
                //get value config
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $scopeConfig = $objectManager->create('\Magento\Framework\App\Config\ScopeConfigInterface');
                $configValue = $scopeConfig->getValue($path, \Magento\Config\Block\System\Config\Form::SCOPE_DEFAULT);
                if ($configValue == 'Ping') {
                    $configValue = 'Pong';
                    //set value config
                    $objectManager->create('\Magento\Config\Model\ResourceModel\Config')
                        ->saveConfig(
                            $path,
                            $configValue,
                            \Magento\Config\Block\System\Config\Form::SCOPE_DEFAULT,
                            0
                        );
                }
            }
        }
        $this->logger->debug('Save Config');
    }
}