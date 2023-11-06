<?php

declare(strict_types=1);

namespace Scandiweb\Test\Setup\Patch\Data;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddProduct implements DataPatchInterface
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

    /**
     * Summary of apply
     * @return void
     */
    public function apply(): void
    {
        $this->appState->emulateAreaCode('adminhtml', [$this, 'execute']);
    }

    /**
     * Execute the patch.
     *
     * @return void
     */
    public function execute(): void
    {
        $product = $this->productInterfaceFactory->create();

        if ($product->getIdBySku('Tricep-Rope')) {
            return;
        }

        $attributeSetId = $this->eavSetup->getAttributeSetId(Product::ENTITY, 'Default');
        $websiteIDs = [$this->storeManager->getStore()->getWebsiteId()];

        $product->setTypeId(Type::TYPE_SIMPLE)
            ->getAttributeSetId($attributeSetId)
            ->setWebsiteIds($websiteIDs)
            ->setName('Tricep Rope')
            ->setSku('Tricep-Rope')
            ->setPrice(20)
            ->setWeight(1)
            ->setShortDescription('Its a tricep rope')
            ->setTaxClassId(0)
            ->setDescription('Its a tricep rope')
            ->setVisibility(Product\Visibility::VISIBILITY_BOTH)
            ->setStatus(Product\Status::STATUS_ENABLED)
            ->setCategoryIds([3]);

        $this->setup->save($product);

        $sourceItem = $this->sourceItemFactory->create();
        $sourceItem->setSourceCode('default');
        $sourceItem->setQuantity(10);
        $sourceItem->setSku($product->getSku());
        $sourceItem->setStatus(SourceItemInterface::STATUS_IN_STOCK);
        $this->sourceItems[] = $sourceItem;

        $this->sourceItemsSaveInterface->execute($this->sourceItems);

        $this->categoryLink->assignProductToCategories($product->getSku(), [2]);
    }

    /**
     * {@inheritDoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}