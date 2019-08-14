<?php

namespace Magenest\Cycbergame\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $customerSetupFactory;

    public function __construct(
        \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $setup->startSetup();
        $customerSetup->addAttribute(
            'customer',
            'is_manager',
            [
                'label' => 'Is maneger',
                'type' => 'static',
                'frontend_input' => 'text',
                'default' => '0',
                'required' => false,
                'visible' => true,
                'position' => 105,
            ]
        );
        $isManagerAttribute = $customerSetup->getEavConfig()->getAttribute('customer', 'is_manager');
        $isManagerAttribute->setData('used_in_forms', ['adminhtml_customer','customer_account_create', 'customer_account_edit']);
        $isManagerAttribute->save();
        $setup->endSetup();
    }
}