<?php
namespace Magenest\Movie\Controller\Adminhtml\Index\Movie;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $jsonFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false  ;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);

            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $entityId) {
                    /** load your model to update the data */
                    $model = $this->_objectManager->create('Magenest\Movie\Model\Movie')->load($entityId);
                    try {
//                        $directorCollection = $this->_objectManager->create('Magenest\Movie\Model\Director')->getCollection();
//                        $directorCollection->addFieldToFilter('name',['=' => $postItems[$entityId]['director_name']]);
//                        $directorId = $directorCollection->getFirstItem()->getData('director_id');
//                        $model->setData('director_id', $directorId);
                        $model->setData(array_merge($model->getData(), $postItems[$entityId]));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Error:]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}