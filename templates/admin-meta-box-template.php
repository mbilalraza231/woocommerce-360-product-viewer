<?php
/**
 * Admin Meta Box Template for WP 360 Viewer
 * 
 * Displays the hidden input and visual image preview on the product edit screen.
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$images = get_post_meta( $post->ID, 'wp360_images', true );
$images_arr = $images ? explode( ',', $images ) : array();

// Nonce for security
wp_nonce_field( 'wp360_save_images', 'wp360_images_nonce' );
?>

<div class="wp360-meta-box-wrap" style="padding: 10px 0;">
    <p style="margin-top: 0;">Select multiple images to create your 360 viewer sequence. For best results, use images of the same dimensions and naming sequence.</p>
    
    <div id="wp360-image-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">
        <?php foreach ( $images_arr as $url ) : ?>
            <?php if ( ! empty( $url ) ) : ?>
                <div class="wp360-preview-img" style="width: 80px; height: 80px; border: 1px solid #ccc; border-radius: 3px; background: #f9f9f9; overflow: hidden;">
                    <img src="<?php echo esc_url( $url ); ?>" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <input type="hidden" id="wp360_images_input" name="wp360_images" value="<?php echo esc_attr( $images ); ?>">
    
    <button type="button" class="button button-primary" id="wp360_upload_images_btn">
        <?php echo empty( $images ) ? 'Add 360 Images' : 'Edit 360 Images'; ?>
    </button>
    <button type="button" class="button" id="wp360_clear_images_btn" style="<?php echo empty( $images ) ? 'display:none;' : ''; ?>">
        Clear Images
    </button>
</div>
