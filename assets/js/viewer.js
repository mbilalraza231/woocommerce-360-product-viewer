document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.wp360-container').forEach(container => {

        const images = JSON.parse(container.dataset.images);
        if (!images || images.length === 0) return;

        let index = 0;
        let isDragging = false;
        let lastX = 0;

        const img = document.createElement('img');
        img.src = images[0];
        img.alt = '360 Viewer';
        img.draggable = false;

        img.style.width = "100%";
        img.style.height = "100%";
        img.style.objectFit = "contain";

        container.innerHTML = '';
        container.appendChild(img);

        // IMPORTANT: use container (stable target)
        container.style.touchAction = "none"; // prevents browser gesture interference

        container.addEventListener('pointerdown', (e) => {
            // Block right-click drag rotation
            if (e.button === 2) return;

            // force reset any stuck state
            try {
                container.releasePointerCapture(e.pointerId);
            } catch (err) {}

            isDragging = true;
            lastX = e.clientX;

            container.setPointerCapture(e.pointerId);
            container.style.cursor = "grabbing";
        });

        container.addEventListener('pointermove', (e) => {

            if (!isDragging) return;

            const diff = e.clientX - lastX;

            if (Math.abs(diff) > 5) {

                if (diff > 0) {
                    index = (index + 1) % images.length;
                } else {
                    index = (index - 1 + images.length) % images.length;
                }

                img.src = images[index];
                lastX = e.clientX;
            }
        });

        const stop = (e) => {
            isDragging = false;
            container.style.cursor = "grab";

            try {
                container.releasePointerCapture(e.pointerId);
            } catch (err) {}
        };

        container.addEventListener('pointerup', stop);
        container.addEventListener('pointercancel', (e) => {
            isDragging = false;
            try {
                container.releasePointerCapture(e.pointerId);
            } catch (err) {}
            container.style.cursor = "grab";
        });
        container.addEventListener('lostpointercapture', () => {
            isDragging = false;
        });

        container.addEventListener('contextmenu', e => e.preventDefault());

    });

    // Global safety reset for focus loss
    window.addEventListener('blur', () => {
        document.querySelectorAll('.wp360-container').forEach(container => {
            container.style.cursor = "grab";
        });
    });

});