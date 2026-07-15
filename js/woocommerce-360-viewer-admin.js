/**
 * WP 360 Viewer Admin Logic (Vanilla JS)
 * Handles the WordPress Media Uploader for selecting 360 product images.
 */

document.addEventListener('DOMContentLoaded', () => {
    const uploadBtn = document.getElementById('wp360_upload_images_btn');
    const clearBtn = document.getElementById('wp360_clear_images_btn');
    const inputField = document.getElementById('wp360_images_input');
    const previewContainer = document.getElementById('wp360-image-preview-container');

    // Only run if the meta box is present on the page
    if (!uploadBtn) return;

    let mediaFrame;

    uploadBtn.addEventListener('click', (e) => {
        e.preventDefault();

        // If the frame already exists, just open it
        if (mediaFrame) {
            mediaFrame.open();
            return;
        }

        // Create the media frame
        mediaFrame = wp.media({
            title: 'Select 360 Viewer Images',
            button: {
                text: 'Use these images'
            },
            multiple: 'add' // Allow selecting multiple images
        });

        // When images are selected in the modal
        mediaFrame.on('select', () => {
            const selection = mediaFrame.state().get('selection');
            const urls = [];
            
            // Clear current preview
            previewContainer.innerHTML = '';

            selection.forEach((attachment) => {
                const att = attachment.toJSON();
                
                // Get full URL for saving to meta
                const fullUrl = att.url;
                
                // Prefer thumbnail size for the admin preview to save memory
                const thumbUrl = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                
                urls.push(fullUrl);

                // Add visual preview block
                const div = document.createElement('div');
                div.style.cssText = 'width: 80px; height: 80px; border: 1px solid #ccc; border-radius: 3px; background: #f9f9f9; overflow: hidden;';
                
                const img = document.createElement('img');
                img.src = thumbUrl;
                img.style.cssText = 'width: 100%; height: 100%; object-fit: contain;';
                
                div.appendChild(img);
                previewContainer.appendChild(div);
            });

            // Update the hidden input with a comma-separated string of URLs
            inputField.value = urls.join(',');
            
            // Update UI buttons
            uploadBtn.textContent = 'Edit 360 Images';
            clearBtn.style.display = 'inline-block';
        });

        // Open the frame
        mediaFrame.open();
    });

    // Handle clearing the images
    clearBtn.addEventListener('click', (e) => {
        e.preventDefault();
        inputField.value = '';
        previewContainer.innerHTML = '';
        uploadBtn.textContent = 'Add 360 Images';
        clearBtn.style.display = 'none';
    });
});
