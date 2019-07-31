<?php
namespace Magenest\Movie\Model\Config\Backend\Sales\Order\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class EvenOdd extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                $entityId = $items['entity_id'];
                $class = '';
                $value = '';
                if ($entityId % 2 == 0) {
                    $class = 'grid-severity-notice';
                    $value = 'SUCCESS';
                } else {
                    $class = 'grid-severity-critical';
                    $value = 'ERROR';
                }
                $items['odd_even'] = '<span class="' . $class . '"><span>' . $value . '</span></span>';
            }
        }
        return $dataSource;
    }
}