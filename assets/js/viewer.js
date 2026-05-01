document.addEventListener('DOMContentLoaded', () => {
    const containers = document.querySelectorAll('.wp360-container');

    containers.forEach(container => {
        const imagesJson = container.getAttribute('data-images');
        const images = JSON.parse(imagesJson);

        if (!images || images.length === 0) {
            container.innerHTML = '<p>No images provided</p>';
            return;
        }

        // Create and configure image element
        const img = document.createElement('img');
        img.src = images[0];
        img.alt = '360 Viewer';
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'contain';
        img.draggable = false;

        // Clear container and add image
        container.innerHTML = '';
        container.appendChild(img);

        // Initialize variables
        let index = 0;
        let isDragging = false;
        let lastX = 0;

        // Prevent native drag
        img.addEventListener('dragstart', e => e.preventDefault());

        // START
        img.addEventListener('pointerdown', (e) => {
            isDragging = true;
            lastX = e.clientX;

            img.setPointerCapture(e.pointerId);
            img.style.cursor = "grabbing";
        });

        // MOVE
        img.addEventListener('pointermove', (e) => {

            if (!isDragging) return;

            const diff = e.clientX - lastX;

            if (Math.abs(diff) > 6) {

                if (diff > 0) {
                    index = (index + 1) % images.length;
                } else {
                    index = (index - 1 + images.length) % images.length;
                }

                img.src = images[index];
                lastX = e.clientX;
            }
        });

        // STOP
        const stop = (e) => {
            isDragging = false;
            img.style.cursor = "grab";

            try {
                img.releasePointerCapture(e.pointerId);
            } catch (err) {}
        };

        img.addEventListener('pointerup', stop);
        img.addEventListener('pointercancel', stop);
    });
});