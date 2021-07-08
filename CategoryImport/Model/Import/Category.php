<?php
namespace Magenest\CategoryImport\Model\Import;

use Magento\AdvancedPricingImportExport\Model\Import\AdvancedPricing;
use Magento\CatalogImportExport\Model\Import\Product\RowValidatorInterface as ValidatorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Magento\ImportExport\Test\Fixture\ImportData;
use Magento\Catalog\Model\Category as CatalogCategory;
use Magento\Catalog\Setup\CategorySetup;

class Category extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{
    protected $import;
    protected $_categoryFactory;
    protected $_category;
    protected $_repository;
    protected $csv;
    protected $request;
    /**
     * Address attributes collection
     *
     * @var \Magento\Customer\Model\ResourceModel\Attribute\Collection
     */
    protected $_attributeCollection;

    protected $categorySetupFactory;

    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\ImportExport\Helper\Data $importExportData,
        \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
        \Magento\Eav\Model\Config $config, ResourceConnection $resource,
        \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Stdlib\StringUtils $string,
        ProcessingErrorAggregatorInterface $errorAggregator,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\Category $category,
        \Magento\Framework\File\Csv $csv,
        \Magento\Catalog\Api\CategoryRepositoryInterface $repository,
        \Magento\Framework\App\Request\Http $request,
        CategorySetup $categorySetupFactory
    ) {
        $this->_category = $category;
        $this->_categoryFactory = $categoryFactory;
        $this->_repository = $repository;
        $this->csv = $csv;
        $this->request = $request;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->_connection = $resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        parent::__construct($jsonHelper, $importExportData, $importData, $config, $resource, $resourceHelper, $string, $errorAggregator);
    }


    public function validateRow(array $rowData, $rowNum)
    {
//        if (isset($this->_validatedRows[$rowNum])) {
//            return !$this->getErrorAggregator()->isRowInvalid($rowNum);
//        }
//        $this->_validatedRows[$rowNum] = true;
//        return !$this->getErrorAggregator()->isRowInvalid($rowNum);
        return true;
    }

    public function getEntityTypeCode()
    {
        return CatalogCategory::ENTITY;
    }

    protected function _importData()
    {
        if (\Magento\ImportExport\Model\Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            //$this->deleteAdvancedPricing();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_REPLACE == $this->getBehavior()) {
            //$this->replaceAdvancedPricing();
        } elseif (\Magento\ImportExport\Model\Import::BEHAVIOR_APPEND == $this->getBehavior()) {
            $this->saveAdvancedCatogory();
        }
        return true;
    }

/*    public function getValidColumnNames()
    {
        return ['id', 'parent_id', 'name'];
        //return $this->validColumnNames;
    }*/

    /**
     * Save advanced pricing
     *
     * @return $this
     */
    public function saveAdvancedCatogory()
    {
        $this->saveAndReplaceAdvancedCategories();
        return $this;
    }

    public function saveAndReplaceAdvancedCategories() {
        $post=$this->request->getFiles();
        if(isset($post)) {
            /*
             * if(isset($post['file_upload']['tmp_name'])) {
                $arrResult=$this->csv->getData($post['file_upload']['tmp_name']);
            */
            if(isset($post['import_file']['tmp_name'])) {
                $arrResult=$this->csv->getData($post['import_file']['tmp_name']);
                foreach ($arrResult as $key=> $value) {
                    if ($key > 0) {
                        // to skip the 1st row i.e title
                        $parentid = 2;
                        if(is_string($value[1])) {
                            $categoryTitle = $value[1]; // Category Name
                            $collection = $this->_categoryFactory->create()->getCollection()->addFieldToFilter('name', ['in'=> $categoryTitle]);
                            if ($collection->getSize()) {
                                $parentid = $collection->getFirstItem()->getId();
                            }
                        }
                        else if(is_int(($value[1]))) $parentid=$value[1];
                        //echo $parentid."<br>";//For reference
                        $data = [ 'data'=>[ "parent_id"=>$parentid,
                            'name' => $value[2],
                            "is_active" => true,
                            "position" => 10,
                            "include_in_menu" => true,
                        ]];
                        $checkCategory = $this->_categoryFactory->create()->getCollection()->addFieldToFilter('name', ['in'=> $value[2]])->addFieldToFilter('parent_id', ['in'=> $parentid]);
                        if( !$checkCategory->getData()) {
                            $category = $this->_categoryFactory->create($data);
                            $result = $this->_repository->save($category);
                        }
                    }
                    //$this->messageManager->addSuccessMessage('Category Imported Successfully');
                }
            }
        }
    }

}