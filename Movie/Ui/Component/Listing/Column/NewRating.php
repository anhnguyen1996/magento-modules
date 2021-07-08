<?php
namespace Magenest\Movie\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class NewRating extends Column
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
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                $rating = $items['rating'];
                $maxRating = 10;
                $percent = ($rating * 100) / $maxRating;
                $items['rating'] =
                '<div class="field-summary-rating"><div class="rating-box"><div class="rating" style="width:'.$percent.'%">'.
                '</div></div></div>';
            }
        }
        return $dataSource;
    }
}