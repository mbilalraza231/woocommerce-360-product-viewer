<?php

add_action('admin_menu', function () {
    add_menu_page(
        'WP 360 Viewer Settings',
        'WP 360 Viewer',
        'manage_options',
        'wp360-settings',
        'wp360_settings_page'
    );
});

function wp360_settings_page() {
    ?>
    <div class="wrap">
        <h1>WP 360 Viewer Settings</h1>

        <form method="post" action="options.php">
            <?php
            settings_fields('wp360_settings_group');
            do_settings_sections('wp360_settings_group');
            ?>

            <label>
                Auto Spin:
                <input type="checkbox" name="wp360_auto_spin" value="1" <?php checked(1, get_option('wp360_auto_spin'), true); ?> />
            </label>

            <br><br>

            <label>
                Spin Speed:
                <input type="number" name="wp360_speed" value="<?php echo get_option('wp360_speed', 80); ?>">
            </label>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', function () {
    register_setting('wp360_settings_group', 'wp360_auto_spin');
    register_setting('wp360_settings_group', 'wp360_speed');
});