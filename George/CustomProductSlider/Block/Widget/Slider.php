<?php
declare(strict_types=1);

namespace George\CustomProductSlider\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Slider extends \George\CustomProductSlider\Block\ProductSlider implements BlockInterface
{
    protected $_template = 'George_CustomProductSlider::product/slider/cms-slider.phtml';

    public function getTitle(): string
    {
        return $this->getData('title') ?: parent::getTitle();
    }

    public function getMaxVisible(): int
    {
        return (int) ($this->getData('max_visible') ?: 4);
    }

    public function getEnableAutoSlide(): bool
    {
        return (bool) ($this->getData('enable_auto_slide') ?: $this->_scopeConfig->getValue('custom_product_slider/general/enable_auto_slide'));
    }

    public function getAutoSlideInterval(): int
    {
        return (int) ($this->getData('auto_slide_interval') ?: $this->_scopeConfig->getValue('custom_product_slider/general/auto_slide_interval'));
    }

    public function getEnableInfiniteLoop(): bool
    {
        return false; // Hardcode to false as per request
    }
}
