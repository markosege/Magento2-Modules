<?php
namespace George\CustomProductSlider\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

class Category implements ArrayInterface
{
    protected $categoryCollectionFactory;

    public function __construct(CollectionFactory $categoryCollectionFactory)
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function toOptionArray()
    {
        $collection = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect(['name'])
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToFilter('level', ['gt' => 1]); // Exclude root category

        $options = [['value' => '', 'label' => __('All Categories')]];
        foreach ($collection as $category) {
            $options[] = [
                'value' => $category->getId(),
                'label' => str_repeat('--', $category->getLevel() - 2) . ' ' . $category->getName()
            ];
        }

        return $options;
    }
}
