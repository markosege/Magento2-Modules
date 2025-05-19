function initSliderComponent(enableAutoSlide, enableInfiniteLoop, autoSlideInterval) {
    'use strict';
    return {
        active: 0,
        itemCount: 0,
        autoSlideInterval: null,
        enableAutoSlide: enableAutoSlide,
        enableInfiniteLoop: enableInfiniteLoop,
        slideIntervalDuration: autoSlideInterval || 5000,
        getSlider() {
            return this.$root.querySelector('.js_slides');
        },
        pageSize: 4,
        pageFillers: 0,
        calcPageSize() {
            const slider = this.getSlider();
            if (slider) {
                this.itemCount = slider.querySelectorAll('.js_slide').length;
                this.pageSize = Math.round(slider.clientWidth / slider.querySelector('.js_slide').clientWidth) || 4;
                this.pageFillers = (
                    this.pageSize * Math.ceil(this.itemCount / this.pageSize)
                ) - this.itemCount;
            }
        },
        calcActive() {
            const slider = this.getSlider();
            if (slider) {
                const sliderItems = this.itemCount + this.pageFillers;
                const calculatedActiveSlide = slider.scrollLeft / (slider.scrollWidth / sliderItems);
                this.active = Math.round(calculatedActiveSlide / this.pageSize) * this.pageSize;
            }
        },
        scrollPrevious() {
            let newIndex = this.active - this.pageSize;
            if (newIndex < 0) {
                newIndex = 0; // Stop at the first slide
            }
            this.scrollTo(newIndex);
        },
        scrollNext() {
            let newIndex = this.active + this.pageSize;
            if (newIndex >= this.itemCount) {
                newIndex = this.itemCount - this.pageSize; // Stop at the last slide
            }
            this.scrollTo(newIndex);
        },
        scrollTo(idx) {
            const slider = this.getSlider();
            if (slider) {
                const slideWidth = slider.scrollWidth / (this.itemCount + this.pageFillers);
                slider.scrollTo({
                    left: Math.floor(slideWidth) * idx,
                    behavior: 'smooth' // Add smooth scrolling
                });
                this.active = idx;
            }
        },
        startAutoSlide() {
            if (this.enableAutoSlide && !this.autoSlideInterval) {
                this.autoSlideInterval = setInterval(() => {
                    if (this.active + this.pageSize >= this.itemCount) {
                        this.scrollTo(0); // Reset to first slide when reaching the end
                    } else {
                        this.scrollNext();
                    }
                }, this.slideIntervalDuration);
            }
        },
        stopAutoSlide() {
            if (this.autoSlideInterval) {
                clearInterval(this.autoSlideInterval);
                this.autoSlideInterval = null;
            } else {
            }
        },
        skipCarouselToNavigation(navSelector) {
            const element = document.getElementById(navSelector);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'end' });
                const button = element.querySelector('button:not([disabled])');
                this.$nextTick(() => button && button.focus({ preventScroll: true }));
            }
        },
        init() {
            this.calcPageSize();
            this.startAutoSlide();
            // Add event listeners for hover
            this.$root.addEventListener('mouseover', (event) => {
                this.stopAutoSlide();
            });
            this.$root.addEventListener('mouseout', (event) => {
                if (!this.$root.contains(event.relatedTarget)) {
                    this.startAutoSlide();
                }
            });
        }
    };
}

// Fallback for hyva.formatString
if (typeof hyva === 'undefined') {
    window.hyva = {};
}
if (typeof hyva.formatString === 'undefined') {
    hyva.formatString = function(str, ...args) {
        return str.replace(/%(\d+)/g, (_, i) => args[i - 1] || '');
    };
}
