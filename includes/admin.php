<?php
if (!defined('ABSPATH')) exit;

function wp360_settings_page() {
?>
<div class="wrap wp360-admin-wrap">
    <h1>WP 360 Viewer Settings</h1>
    <p>Configure how your 360 product viewer behaves on the frontend.</p>
    
    <form method="post" action="options.php">
        <?php
        settings_fields('wp360_settings_group');
        do_settings_sections('wp360_settings_group');
        ?>

        <style>
            .wp360-admin-wrap h2 { border-bottom: 2px solid #ddd; padding-bottom: 10px; margin-top: 30px; color: #23282d; }
            .wp360-setting-row { margin-bottom: 20px; display: flex; align-items: center; }
            .wp360-setting-row label { width: 250px; font-weight: 600; display: inline-block; }
            .wp360-setting-row input[type="number"] { width: 80px; }
            .wp360-desc { color: #666; font-style: italic; margin-left: 10px; }
        </style>

        <h2>1. General Rotation</h2>
        
        <div class="wp360-setting-row">
            <label for="wp360_auto_spin">Enable Auto Spin</label>
            <input type="checkbox" id="wp360_auto_spin" name="wp360_auto_spin" value="1" <?php checked(1, get_option('wp360_auto_spin'), true); ?>>
            <span class="wp360-desc">Product will rotate automatically on page load.</span>
        </div>

        <div class="wp360-setting-row">
            <label for="wp360_speed">Spin Speed (ms)</label>
            <input type="number" id="wp360_speed" name="wp360_speed" value="<?php echo get_option('wp360_speed', 100); ?>">
            <span class="wp360-desc">Lower is faster (e.g., 50 is very fast, 200 is slow).</span>
        </div>

        <h2>2. User Interaction</h2>

        <div class="wp360-setting-row">
            <label for="wp360_drag_rotation">Enable Drag Rotation</label>
            <input type="checkbox" id="wp360_drag_rotation" name="wp360_drag_rotation" value="1" <?php checked(1, get_option('wp360_drag_rotation', 1), true); ?>>
            <span class="wp360-desc">Allow users to rotate by clicking and dragging.</span>
        </div>

        <div class="wp360-setting-row">
            <label for="wp360_inertia">Inertia Strength</label>
            <input type="number" step="0.01" min="0" max="0.99" id="wp360_inertia" name="wp360_inertia" value="<?php echo get_option('wp360_inertia', 0.92); ?>">
            <span class="wp360-desc">Smoothness of rotation after release (0.1 to 0.99). Recommended: 0.92</span>
        </div>

        <h2>3. Zoom Settings</h2>

        <div class="wp360-setting-row">
            <label for="wp360_zoom_enable">Enable Zoom</label>
            <input type="checkbox" id="wp360_zoom_enable" name="wp360_zoom_enable" value="1" <?php checked(1, get_option('wp360_zoom_enable', 1), true); ?>>
            <span class="wp360-desc">Allow users to magnify the product.</span>
        </div>

        <div class="wp360-setting-row">
            <label for="wp360_zoom_on_hover">Trigger Zoom on Hover</label>
            <input type="checkbox" id="wp360_zoom_on_hover" name="wp360_zoom_on_hover" value="1" <?php checked(1, get_option('wp360_zoom_on_hover', 1), true); ?>>
            <span class="wp360-desc">If disabled, users must click the Zoom Button to magnify.</span>
        </div>

        <div class="wp360-setting-row">
            <label for="wp360_zoom_level">Zoom Magnification</label>
            <input type="number" step="0.1" min="1" id="wp360_zoom_level" name="wp360_zoom_level" value="<?php echo get_option('wp360_zoom_level', 1.5); ?>">
            <span class="wp360-desc">How much the image scales (e.g., 1.5x, 2.0x).</span>
        </div>

        <h2>4. Features & UI</h2>

        <div class="wp360-setting-row">
            <label for="wp360_hotspots">Enable Hotspots</label>
            <input type="checkbox" id="wp360_hotspots" name="wp360_hotspots" value="1" <?php checked(1, get_option('wp360_hotspots'), true); ?>>
            <span class="wp360-desc">Enable the interactive hotspot layer.</span>
        </div>

        <div class="wp360-setting-row">
            <label for="wp360_show_controls">Show Navigation Buttons</label>
            <input type="checkbox" id="wp360_show_controls" name="wp360_show_controls" value="1" <?php checked(1, get_option('wp360_show_controls', 1), true); ?>>
            <span class="wp360-desc">Display Zoom, Left, and Right buttons at the bottom.</span>
        </div>

        <br><hr>
        <?php submit_button('Save Professional Settings'); ?>
    </form>
</div>
<?php
}

add_action('admin_menu', function () {
    add_menu_page(
        'WP 360 Viewer Settings',
        '360 Viewer',
        'manage_options',
        'wp-360-viewer',
        'wp360_settings_page',
        'dashicons-360',
        100
    );
});

add_action('admin_init', function () {
    register_setting('wp360_settings_group', 'wp360_auto_spin');
    register_setting('wp360_settings_group', 'wp360_drag_rotation');
    register_setting('wp360_settings_group', 'wp360_speed');
    register_setting('wp360_settings_group', 'wp360_show_controls');
    register_setting('wp360_settings_group', 'wp360_zoom_enable');
    register_setting('wp360_settings_group', 'wp360_zoom_on_hover');
    register_setting('wp360_settings_group', 'wp360_zoom_level');
    register_setting('wp360_settings_group', 'wp360_inertia');
    register_setting('wp360_settings_group', 'wp360_hotspots');
});