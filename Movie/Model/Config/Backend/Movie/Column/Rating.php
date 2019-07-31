<?php
namespace Magenest\Movie\Model\Config\Backend\Movie\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Rating extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [])
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore();
        $mediaPath = $storeManager->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $halfStarImagePath = $mediaPath .'import/icons8-star-half-48.png';
        $starImagePath = $mediaPath . 'import/icons8-star-64.png';
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                $rating = $items['rating'];
                $items['rating'] = '';
                $star = (int)($rating/2);
                for ($i = 0; $i < $star; $i++) {
                    $items['rating'].= '<img src="'.$starImagePath.'" alt="start" height="42" width="42"/>';
                }
                if ($rating % 2 != 0) {
                   $items['rating'].= '<img src="'.$halfStarImagePath.'" alt="start" height="42" width="42"/>';
                }
            }
        }
        return $dataSource;
    }
}