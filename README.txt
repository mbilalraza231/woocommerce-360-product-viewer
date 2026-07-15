=== WP 360 Viewer ===
Contributors: mbilalraza231
Tags: woocommerce, 360 viewer, product rotation, 360 degree, product viewer
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A premium, high-performance, and lightweight 360° product rotation viewer for WooCommerce using Vanilla JS.

== Description ==

WP 360 Viewer is a lightweight yet powerful solution for showcasing WooCommerce products from every angle. Built completely with modern Vanilla JavaScript and a highly optimized PHP autoloader architecture, it offers a seamless, jQuery-free experience.

It integrates directly into your WooCommerce product edit screen, allowing you to easily upload multiple images from the WordPress Media Library to generate a beautiful, interactive 360-degree rotation view on your product pages.

= Key Features =
* **High Performance**: Zero dependencies, lightweight vanilla JavaScript. No jQuery.
* **WooCommerce Integration**: Dedicated "360 Viewer Images" meta box.
* **Professional Zoom**: Integrated magnification with "Smart Origin" tracking.
* **Smooth Rotation**: Physics-based inertia for a realistic "momentum" feel.
* **Modern UI**: Clean, glassmorphism UI with inline SVGs.
* **Deep Customization**: Control speed, inertia, and zoom levels via the settings page.

== Installation ==

1. Upload the `wp-360-viewer` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Visit '360 Viewer' in your admin sidebar to configure global settings.
4. Edit a WooCommerce product to add your 360 images.

== Frequently Asked Questions ==

= How many images should I use? =
For a smooth rotation effect, we recommend using between 24 and 36 images.

= Why isn't the rotation perfectly smooth? =
Ensure all images are shot from the exact same distance and have the exact same dimensions. The product should be perfectly centered in every frame.

== Screenshots ==

1. The Admin Settings page.
2. The WooCommerce Product Meta Box for selecting images.
3. The frontend 360 Viewer in action.

== Changelog ==

= 1.0.0 =
* Initial Release.
* Implemented Vanilla JS frontend and media uploader.
* Added custom PSR-4 style autoloader architecture.