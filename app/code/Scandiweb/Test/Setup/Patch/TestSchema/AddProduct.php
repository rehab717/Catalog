<?php

declare(strict_types=1);

namespace Scandiweb\Test\Setup\Patch\Schema;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type;

class AddProduct implements SchemaPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */


    protected ModuleDataSetupInterface $setup;

    /**
     * @var ProductInterfaceFactory
     */


    protected ProductInterfaceFactory $productInterfaceFactory;

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ProductInterfaceFactory $productInterfaceFactory
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        ProductInterfaceFactory $productInterfaceFactory
    ) {
        $this->setup = $setup;
        $this->productInterfaceFactory = $productInterfaceFactory;
    }

    public static function getDependencies(): array
    {
        /**
         * Get the dependencies of this patch.
         *
         * @return array
         */
        return [];
    }

    public function getAliases(): array
    {
        /**
         * Get the aliases of this patch.
         *
         * @return array
         */
        return [];
    }

    /**
     * Execute the patch.
     *
     * @return void
     */
    public function execute(): void
    {
        $product = $this->productInterfaceFactory->create();
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
            ->setSourceItem('qty', 100)
            ->setVisibility(Product\Visibility::VISIBILITY_BOTH)
            ->setStatus(Product\Status::STATUS_ENABLED)
            ->setCategoryIds([3]);

        $this->setup->save($product);
    }
}