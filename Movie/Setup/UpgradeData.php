<?php
namespace Magenest\Movie\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Sales\Model\Order;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{
    protected $customerSetupFactory;
    private $attributeSetFactory;
    protected $salesSetupFactory;

    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        SalesSetupFactory $salesSetupFactory,
        AttributeSetFactory $attributeSetFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->salesSetupFactory = $salesSetupFactory;
    }


    public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) {

        if (version_compare($context->getVersion(), '2.0.4') < 0) {

            $setup->startSetup();
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();

            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY,
                'my_customer_image',
                [
                    'type' => 'text',
                    'label' => 'My Customer Image',
                    'input' => 'file',
                    "source" => '',
                    'required' => false,
                    'default' => '0',
                    'visible' => true,
                    'user_defined' => true,
                    'sort_order' => 210,
                    'position' => 210,
                    'system' => false,
                ]
            );

            $image = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'my_customer_image')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer', 'customer_account_create', 'customer_account_edit'],
                ]);

            $image->save();
            $setup->endSetup();
        }

        if (version_compare($context->getVersion(), '2.0.9') < 0) {
            $installer = $setup;

            $installer->startSetup();

            /** @var \Magento\Sales\Setup\SalesSetup $salesSetup */
            $salesSetup = $this->salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $installer]);

            $salesSetup->addAttribute(Order::ENTITY, 'odd_even',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'=> 255,
                    'visible' => false,
                    'nullable' => true,
                    'grid' => true
                ]
            );
            $installer->endSetup();
        }
    }
}