<?php
namespace Magenest\Movie\Block\Pricing\Render;

use Magento\Framework\Pricing\Amount\AmountInterface;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Pricing\Render\Amount as VendorAmount;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Framework\Pricing\SaleableInterface;
use Magento\Framework\View\Element\Template;

class Amount extends VendorAmount
{
    public function __construct(Template\Context $context, AmountInterface $amount, PriceCurrencyInterface $priceCurrency, RendererPool $rendererPool, SaleableInterface $saleableItem = null, PriceInterface $price = null, array $data = [])
    {
        parent::__construct($context, $amount, $priceCurrency, $rendererPool, $saleableItem, $price, $data);
    }

    public function getPriceUnit()
    {
        return "VND";
    }
}