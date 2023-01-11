<?php 

declare(strict_types=1);

namespace Magenest\Test\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class AddProduct implements SchemaPatchInterface
{
   private $moduleDataSetup;


   public function __construct(

       ModuleDataSetupInterface $moduleDataSetup
   ) 
   {
       $this->moduleDataSetup = $moduleDataSetup;
   }


   public static function getDependencies()
   {
       return [];
   }


   public function getAliases()
   {
       return [];
   }


   public function apply()
   {
		$this->moduleDataSetup->getConnection()->startSetup();

        $product = $this->productFactory->create();
        $product->setTypeId('simple')
        ->setAttributeSetId(4)
        ->setName('Tricep Rope')
        ->setSku('Tricep-Rope')
        ->setPrice(20.00)
        ->setDescription('Its a tricep rope')
        ->setVisibility(4)
        ->setStatus(1)
        ->setCategoryIds([3])
        ->setWebsiteIds([1])
        ->setStockData([
            'use_config_manage_stock' => 0,
            'manage_stock' => 1,
            'is_in_stock' => 1,
            'qty' => 100
        ])
        ->save();

        $this->moduleDataSetup->getConnection()->endSetup();
   }
}