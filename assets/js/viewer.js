document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.wp360-container').forEach(container => {

        const images = JSON.parse(container.dataset.images);
        if (!images || images.length === 0) return;

        const autoSpin = container.dataset.autoSpin === '1';
        const spinSpeed = parseInt(container.dataset.spinSpeed) || 80;

        let index = 0;
        let isDragging = false;
        let lastX = 0;
        let moveDelta = 0;

        const img = document.createElement('img');
        img.src = images[0];
        img.alt = '360 Viewer';
        img.draggable = false;

        img.style.width = "100%";
        img.style.height = "100%";
        img.style.objectFit = "contain";

        container.innerHTML = '';
        container.appendChild(img);

        container.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });

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
            moveDelta += diff;
            lastX = e.clientX;

            const threshold = 6;
            const rawSteps = Math.trunc(moveDelta / threshold);
            const maxSteps = 3;
            const steps = Math.sign(rawSteps) * Math.min(Math.abs(rawSteps), maxSteps);

            if (steps !== 0) {
                moveDelta -= steps * threshold;
                index = (index + steps + images.length * 1000) % images.length;
                img.src = images[index];
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

        container.addEventListener('mousedown', (e) => {
            if (e.detail > 1) e.preventDefault();
        });

        function autoRotate() {
            if (isDragging || !autoSpin) {
                setTimeout(autoRotate, spinSpeed);
                return;
            }

            index = (index + 1) % images.length;
            img.src = images[index];
            setTimeout(autoRotate, spinSpeed);
        }

        if (autoSpin) {
            autoRotate();
        }

    });

    // Global safety reset for focus loss
    window.addEventListener('blur', () => {
        document.querySelectorAll('.wp360-container').forEach(container => {
            container.style.cursor = "grab";
        });
    });

});
