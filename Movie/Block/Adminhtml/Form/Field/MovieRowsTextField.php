<?php
namespace Magenest\Movie\Block\Adminhtml\Form\Field;

class MovieRowsTextField extends \Magento\Config\Block\System\Config\Form\Field
{

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context, array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        //$html = $element->getElementHtml();
        //$value = $element->getData('value');
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $movieModel = $objectManager->create('Magenest\Movie\Model\Movie');
        $movieCollection = $movieModel->getCollection();
        $size = $movieCollection->getSize();
        $element->setData('value',$size);
        $element->setReadonly(true);
        return $element->getElementHtml();
    }


}