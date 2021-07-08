<?php
namespace Magenest\Movie\Model\System;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            [
                'value' => 1,
                'label' => __('Active')
            ],
            [
                'value' => 2,
                'label' => __('Inactive')
            ]
        ];
    }
}