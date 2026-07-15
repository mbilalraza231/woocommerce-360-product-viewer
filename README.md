# 📸 WP 360 Viewer
**A Premium, High-Performance 360° Product Rotation Plugin for WordPress and WooCommerce**

WP 360 Viewer is a lightweight yet powerful solution for showcasing products from every angle. Built with modern Vanilla JavaScript and a highly optimized, professional PHP architecture, it offers a seamless experience for e-commerce and portfolio websites.

---

## ✨ Key Features
- **🚀 High Performance & Zero Dependencies**: 100% Vanilla JavaScript on the frontend. No heavy jQuery libraries, resulting in lightning-fast load times.
- **🏗️ Professional Architecture**: Built on a modular, class-based PSR-4 style autoloader architecture.
- **🖼️ WooCommerce Integration**: Seamlessly adds a dedicated "360 Viewer Images" meta box to the WooCommerce Product screen. Uses the native WordPress Media Uploader for easy multi-image selection.
- **🔍 Professional Zoom**: Integrated magnification with "Smart Origin" tracking and a dedicated UI toggle.
- **🔄 Smooth Rotation**: Physics-based inertia for a realistic "momentum" feel when spinning products.
- **🎮 Navigation Controls**: Clean, modern glassmorphism UI for Zoom, Prev, and Next actions using inline SVGs instead of heavy image sprites.
- **📱 Responsive & Touch Ready**: Fully optimized for mobile devices with smooth touch-drag interactions.
- **⚙️ Deep Customization**: Control speed, inertia, zoom levels, and UI visibility directly from the WordPress Admin Dashboard.

---

## 🛠 Installation

1. Upload the `wp-360-viewer` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the **'Plugins'** menu in WordPress.
3. Visit **'360 Viewer'** in your sidebar to configure your global settings.

---

## 📖 Usage

### Adding 360 Images to a WooCommerce Product
1. Edit any WooCommerce Product.
2. Scroll down to the **360 Product Viewer Images** meta box.
3. Click "Add 360 Images" and `Shift+Click` or `Ctrl+Click` multiple images in your Media Library.
4. Save the product! The 360 viewer will automatically replace the standard WooCommerce product image.

### Displaying anywhere via Shortcode
You can also display a standalone viewer anywhere using a simple shortcode:

```text
[wp360 images="url1.jpg, url2.jpg, url3.jpg"]
```

### Tips for Best Results:
- Use at least **24 to 36 images** for a smooth rotation effect.
- Ensure all images have the exact same dimensions and the product is perfectly centered.
- For high-resolution zoom, use images with a width of at least **1500px**.

---

## 🎨 Professional Interaction Defaults
The plugin comes pre-configured with industry-standard defaults:
- **Drag Rotation**: Enabled for natural exploration.
- **Inertia**: Set to `0.92` for a premium, heavy feel.
- **Transition**: `cubic-bezier(0.165, 0.84, 0.44, 1)` for smooth scaling.

---

## 📄 License
Licensed under the GPL-2.0+ License. Feel free to use and customize for your own projects!
