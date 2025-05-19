# George Custom Product Slider

The `George/CustomProductSlider` module is a Magento 2 extension that adds a customizable product slider to any page of a Magento site using the Hyvä Theme. Built with Alpine.js for interactivity and Tailwind CSS for styling, it leverages Hyvä’s `Slider` view model for seamless rendering.

## Features
- **Site-Wide Display**: Add the slider to any page via CMS blocks, widgets, or layout XML.
- **Non-Infinite Loop**: Stops at the last slide and resets to the first.
- **Smooth Scroll Effect**: Animated slide transitions.
- **Pause-on-Hover**: Auto-sliding pauses on hover and resumes on mouse leave.
- **Enhanced Controls**: Arrows and dots scale on hover with smooth transitions.
- **Configurable**: Customize title, maximum visible slides, auto-slide interval, and more.
- **Responsive**: Adapts to screen sizes using Tailwind CSS.
- **Accessible**: Includes ARIA attributes and keyboard navigation.

## Requirements
- Magento 2.4.x
- Hyvä Theme (latest as of May 2025)
- Composer
- Access to Magento admin and server filesystem

## Installation
1. **Create Module Directory**:
   ```bash
   mkdir -p app/code/George/CustomProductSlider
