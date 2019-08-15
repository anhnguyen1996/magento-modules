<?php
namespace Magenest\Cycbergame\Block\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\View as ProductView;

class View extends ProductView
{
    protected $roomResult;

    /**
     * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
     */
    protected $layoutProcessors;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        array $layoutProcessors = [],
        array $data = []
    ) {
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $request = $objectManager->create('Magento\Framework\App\Request\Http');
        $roomExtraOptionCollection = $objectManager->create('Magenest\Cycbergame\Model\ResourceModel\RoomExtraOption\Collection');
        $this->roomResult = $roomExtraOptionCollection->addFieldToFilter('product_id', ['=', $this->getProduct()->getId()])->getFirstItem();

        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->layoutProcessors = $layoutProcessors;
    }

    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }

    public function getNumberPc()
    {
        return $this->roomResult->getData('number_pc');
    }

    public function getAddress()
    {
        return $this->roomResult->getData('address');
    }

    public function getFoodPrice()
    {
        return $this->roomResult->getData('food_price');
    }

    public function getDrinkPrice()
    {
        return $this->roomResult->getData('drink_price');
    }
}