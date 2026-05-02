/**
 * WP 360 Viewer Logic
 * Professional Version 1.6 - Unified Zoom Behavior & Cursors
 */

document.addEventListener('DOMContentLoaded', () => {

    const containers = document.querySelectorAll('.wp360-container');
    if (!containers.length) return;

    containers.forEach(container => {
        const globalSettings = window.wp360Settings || {};
        const settings = {
            autoSpin: parseInt(globalSettings.autoSpin || 0),
            dragRotation: parseInt(globalSettings.dragRotation !== undefined ? globalSettings.dragRotation : 1),
            speed: parseInt(globalSettings.speed || 80),
            zoomEnable: parseInt(globalSettings.zoomEnable !== undefined ? globalSettings.zoomEnable : 1),
            zoomOnHover: parseInt(globalSettings.zoomOnHover !== undefined ? globalSettings.zoomOnHover : 1),
            zoomOnClick: parseInt(globalSettings.zoomOnClick !== undefined ? globalSettings.zoomOnClick : 1),
            zoomLevel: parseFloat(globalSettings.zoomLevel || 1.5),
            inertia: parseFloat(globalSettings.inertia !== undefined ? globalSettings.inertia : 0.92),
            hotspots: parseInt(globalSettings.hotspots || 0),
            showControls: parseInt(globalSettings.showControls !== undefined ? globalSettings.showControls : 1)
        };

        // Interaction Override: If buttons are enabled, disable image hover/click zoom
        if (settings.showControls === 1) {
            settings.zoomOnHover = 0;
            settings.zoomOnClick = 0;
        }

        const images = JSON.parse(container.dataset.images || '[]');
        if (!images || images.length === 0) return;

        let index = 0;
        let isDragging = false;
        let isMouseOver = false;
        let isZoomActive = false;

        let lastX = 0;
        let lastY = 0;
        let moveDelta = 0;

        let velocity = 0;
        let lastMoveTime = 0;
        let rafId = null;

        const img = document.createElement('img');
        img.src = images[index];
        img.draggable = false;
        img.className = 'wp360-main-img';

        Object.assign(img.style, {
            width: "100%", height: "100%", objectFit: "contain", display: "block",
            transformOrigin: "center center", transform: "scale(1)",
            transition: "transform 0.25s ease-out",
            pointerEvents: "none"
        });

        container.innerHTML = '';
        container.appendChild(img);

        const updateImage = (newIndex) => {
            index = (newIndex + images.length) % images.length;
            img.src = images[index];
        };

        const updateZoomOrigin = (x, y) => {
            if (settings.zoomEnable !== 1 || isDragging) return;
            const rect = container.getBoundingClientRect();
            const xPct = ((x - rect.left) / rect.width) * 100;
            const yPct = ((y - rect.top) / rect.height) * 100;
            img.style.transformOrigin = `${xPct}% ${yPct}%`;
        };

        const setZoom = (active) => {
            if (settings.zoomEnable !== 1 || isDragging) return;
            isZoomActive = active;

            if (active) {
                container.classList.add('wp360-zoomed');
                img.style.transform = `scale(${settings.zoomLevel})`;
                container.style.cursor = 'zoom-out';
            } else {
                container.classList.remove('wp360-zoomed');
                img.style.transform = "scale(1)";
                updateCursor();
            }

            // Sync with button UI
            const btn = container.querySelector('.wp360-btn.zoom-toggle');
            if (btn) btn.classList.toggle('active', active);
        };

        const updateCursor = () => {
            if (isDragging) {
                container.style.cursor = 'grabbing';
            } else if (isZoomActive) {
                container.style.cursor = 'zoom-out';
            } else if (settings.zoomEnable === 1 && (settings.zoomOnHover === 1 || settings.zoomOnClick === 1)) {
                container.style.cursor = 'zoom-in';
            } else {
                container.style.cursor = 'grab';
            }
        };

        const toggleZoom = (e) => {
            if (settings.zoomEnable !== 1) return;
            const newState = !isZoomActive;
            if (newState) updateZoomOrigin(e.clientX, e.clientY);
            setZoom(newState);
        };

        if (settings.showControls === 1) {
            const controls = document.createElement('div');
            controls.className = 'wp360-controls';
            controls.innerHTML = `
                <button type="button" class="wp360-btn prev" title="Rotate Left">
                    <svg viewBox="0 0 24 24" width="20" height="20" style="fill: currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                </button>
                <button type="button" class="wp360-btn zoom-toggle" title="Toggle Zoom">
                    <svg viewBox="0 0 24 24" width="20" height="20" style="fill: currentColor;"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                </button>
                <button type="button" class="wp360-btn next" title="Rotate Right">
                    <svg viewBox="0 0 24 24" width="20" height="20" style="fill: currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                </button>
            `;
            container.appendChild(controls);
            controls.querySelector('.prev').addEventListener('click', (e) => { e.stopPropagation(); updateImage(index - 1); });
            controls.querySelector('.next').addEventListener('click', (e) => { e.stopPropagation(); updateImage(index + 1); });
            controls.querySelector('.zoom-toggle').addEventListener('click', (e) => { e.stopPropagation(); toggleZoom(e); });
        }

        container.addEventListener('contextmenu', (e) => e.preventDefault());
        container.style.touchAction = "none";

        const handleMove = (e) => {
            if (isDragging) {
                const now = Date.now();
                const dt = now - lastMoveTime;
                const diff = e.clientX - lastX_drag;
                if (dt > 0) velocity = velocity * 0.4 + diff * 0.6;
                moveDelta += diff;
                lastX_drag = e.clientX;
                lastMoveTime = now;
                const threshold = 5;
                const steps = Math.trunc(moveDelta / threshold);
                if (steps !== 0) { moveDelta -= steps * threshold; updateImage(index + steps); }
                return;
            }

            if (isMouseOver) {
                updateZoomOrigin(e.clientX, e.clientY);
            }
        };

        let lastX_drag = 0;
        let startX = 0;
        let startY = 0;
        const handleDown = (e) => {
            if (e.target.closest('.wp360-btn')) return;
            cancelAnimationFrame(rafId);

            startX = e.clientX;
            startY = e.clientY;
            lastX_drag = e.clientX;
            lastMoveTime = Date.now();
            velocity = 0;

            if (settings.dragRotation === 1) {
                isDragging = true;
                if (container.setPointerCapture) container.setPointerCapture(e.pointerId);
                updateCursor();
                setZoom(false);
            }
        };

        const handleUp = (e) => {
            const dist = Math.sqrt(Math.pow(e.clientX - startX, 2) + Math.pow(e.clientY - startY, 2));

            if (isDragging) {
                isDragging = false;
                if (container.releasePointerCapture) { try { container.releasePointerCapture(e.pointerId); } catch (err) { } }

                if (dist < 5 && settings.zoomEnable === 1 && settings.zoomOnClick === 1) {
                    toggleZoom(e);
                } else {
                    if (isMouseOver && settings.zoomOnHover === 1) {
                        updateZoomOrigin(e.clientX, e.clientY);
                        setZoom(true);
                    }
                    updateCursor();
                    startInertia();
                }
            } else if (dist < 5 && settings.zoomEnable === 1 && settings.zoomOnClick === 1) {
                toggleZoom(e);
            }
        };

        const startInertia = () => {
            if (Math.abs(velocity) < 0.1) return;
            const loop = () => {
                if (isDragging) return;
                moveDelta += velocity;
                const threshold = 5;
                const steps = Math.trunc(moveDelta / threshold);
                if (steps !== 0) { moveDelta -= steps * threshold; updateImage(index + steps); }
                velocity *= settings.inertia;
                if (Math.abs(velocity) > 0.1) rafId = requestAnimationFrame(loop);
                else velocity = 0;
            };
            rafId = requestAnimationFrame(loop);
        };

        container.addEventListener('pointerdown', handleDown);
        container.addEventListener('pointermove', handleMove);
        container.addEventListener('pointerup', handleUp);
        container.addEventListener('pointercancel', handleUp);

        container.addEventListener('mouseenter', (e) => {
            isMouseOver = true;
            if (settings.zoomOnHover === 1) {
                updateZoomOrigin(e.clientX, e.clientY);
                setZoom(true);
            }
            updateCursor();
        });

        container.addEventListener('mouseleave', () => {
            isMouseOver = false;
            setZoom(false); // ALWAYS unzoom when mouse leaves
            updateCursor();
        });

        const runAutoRotate = () => {
            if (settings.autoSpin === 1 && !isDragging && !isMouseOver && Math.abs(velocity) < 0.1) {
                updateImage(index + 1);
            }
            setTimeout(runAutoRotate, settings.speed);
        };
        runAutoRotate();
        updateCursor();
    });
});
