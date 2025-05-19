<?php
namespace George\CustomProductSlider\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class ProductSlider extends Template
{
    protected $productCollectionFactory;
    protected $scopeConfig;

    public function __construct(
        Template\Context $context,
        CollectionFactory $productCollectionFactory,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function isSliderEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'custom_product_slider/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getSliderTitle()
    {
        return $this->scopeConfig->getValue(
            'custom_product_slider/general/slider_title',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getMaxProducts()
    {
        return (int) $this->scopeConfig->getValue(
            'custom_product_slider/general/max_products',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCategoryId()
    {
        return $this->scopeConfig->getValue(
            'custom_product_slider/general/category_id',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function isAutoSlideEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'custom_product_slider/general/enable_auto_slide',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getAutoSlideInterval()
    {
        return (int) $this->scopeConfig->getValue(
            'custom_product_slider/general/auto_slide_interval',
            ScopeInterface::SCOPE_STORE
        ) ?: 5000; // Fallback to 5000ms
    }

    public function isInfiniteLoopEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'custom_product_slider/general/enable_infinite_loop',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'price', 'small_image'])
            ->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
            ->addAttributeToFilter('visibility', ['neq' => \Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE]);

        if ($categoryId = $this->getCategoryId()) {
            $collection->addCategoriesFilter(['in' => $categoryId]);
        }

        $collection->setPageSize($this->getMaxProducts());
        return $collection;
    }
}
