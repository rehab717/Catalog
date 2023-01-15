<?php 

declare(strict_types=1);

namespace Scandiweb\Test\Setup\Patch\Schema;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type;

class AddProduct implements SchemaPatchInterface
{
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
        $objectManager = ObjectManager::getInstance();
        $productRepository = $objectManager->get(ProductRepositoryInterface::class);

        $product = $objectManager->create(Product::class);
        $product->setTypeId(Type::TYPE_SIMPLE)
            ->setAttributeSetId(4)
            ->setWebsiteIds([1])
            ->setName('Tricep Rope')
            ->setSku('Tricep-Rope')
            ->setPrice(20)
            ->setWeight(1)
            ->setShortDescription('Its a tricep rope')
            ->setTaxClassId(0)
            ->setDescription('Its a tricep rope')
            ->setStockData([
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1,
                'qty' => 100
            ])
            ->setVisibility(Product\Visibility::VISIBILITY_BOTH)
            ->setStatus(Status::STATUS_ENABLED)
            ->setCategoryIds([3]);

        $productRepository->save($product);
    }
}
