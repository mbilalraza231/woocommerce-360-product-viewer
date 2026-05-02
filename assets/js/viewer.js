/**
 * WP 360 Viewer Logic
 * Professional Version 1.3 - Click vs Drag Solved
 */

document.addEventListener('DOMContentLoaded', () => {

    const containers = document.querySelectorAll('.wp360-container');
    if (!containers.length) return;

    containers.forEach(container => {
        // Fetch settings
        const globalSettings = window.wp360Settings || {};
        const settings = {
            autoSpin: parseInt(globalSettings.autoSpin || 0),
            dragRotation: parseInt(globalSettings.dragRotation !== undefined ? globalSettings.dragRotation : 1),
            speed: parseInt(globalSettings.speed || 80),
            zoomEnable: parseInt(globalSettings.zoomEnable !== undefined ? globalSettings.zoomEnable : 1),
            zoomOnHover: parseInt(globalSettings.zoomOnHover !== undefined ? globalSettings.zoomOnHover : 1),
            zoomLevel: parseFloat(globalSettings.zoomLevel || 1.5),
            inertia: parseFloat(globalSettings.inertia !== undefined ? globalSettings.inertia : 0.92),
            hotspots: parseInt(globalSettings.hotspots || 0),
            showControls: parseInt(globalSettings.showControls !== undefined ? globalSettings.showControls : 1)
        };

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
        img.src = images[0];
        img.draggable = false;
        img.className = 'wp360-main-img';

        Object.assign(img.style, {
            width: "100%", height: "100%", objectFit: "contain", display: "block",
            transformOrigin: "center center", transform: "scale(1)",
            transition: "transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1)",
            pointerEvents: "none"
        });

        container.innerHTML = '';
        container.appendChild(img);

        const updateImage = (newIndex) => {
            index = (newIndex + images.length) % images.length;
            img.src = images[index];
        };

        const setZoom = (active, x = null, y = null) => {
            if (settings.zoomEnable !== 1 || isDragging) return;
            isZoomActive = active;

            if (active) {
                container.classList.add('wp360-zoomed');
                img.style.transform = `scale(${settings.zoomLevel})`;
                if (x !== null && y !== null) {
                    const rect = container.getBoundingClientRect();
                    const xPct = ((x - rect.left) / rect.width) * 100;
                    const yPct = ((y - rect.top) / rect.height) * 100;
                    img.style.transformOrigin = `${xPct}% ${yPct}%`;
                }
            } else {
                container.classList.remove('wp360-zoomed');
                img.style.transform = "scale(1)";
                setTimeout(() => { if(!isZoomActive) img.style.transformOrigin = "center center"; }, 400);
            }
        };

        const toggleZoom = (e) => {
            const newState = !isZoomActive;
            setZoom(newState, e.clientX, e.clientY);
            const btn = container.querySelector('.wp360-btn.zoom-toggle');
            if (btn) btn.classList.toggle('active', newState);
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

            lastX = e.clientX;
            lastY = e.clientY;

            if (isMouseOver) {
                if (settings.zoomOnHover === 1 || isZoomActive) {
                    setZoom(true, e.clientX, e.clientY);
                }
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
                container.style.cursor = "grabbing";
                // We don't setZoom(false) here yet, we wait to see if they move
            }
        };

        const handleUp = (e) => {
            const dist = Math.sqrt(Math.pow(e.clientX - startX, 2) + Math.pow(e.clientY - startY, 2));
            
            if (isDragging) {
                isDragging = false;
                container.style.cursor = (settings.zoomEnable === 1) ? "zoom-in" : "grab";
                if (container.releasePointerCapture) { try { container.releasePointerCapture(e.pointerId); } catch(err) {} }
                
                // If they BARELY moved, treat it as a click instead of a drag release
                if (dist < 5 && settings.zoomEnable === 1) {
                    toggleZoom(e);
                } else {
                    // It was a real drag, restore zoom if needed
                    if (isMouseOver && (settings.zoomOnHover === 1 || isZoomActive)) {
                        setZoom(true, e.clientX, e.clientY);
                    }
                    startInertia();
                }
            } else if (dist < 5 && settings.zoomEnable === 1) {
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
            if (settings.zoomOnHover === 1 || isZoomActive) setZoom(true, e.clientX, e.clientY);
        });

        container.addEventListener('mouseleave', () => {
            isMouseOver = false;
            if (!isZoomActive) setZoom(false);
            if (!isDragging) container.style.cursor = settings.zoomEnable === 1 ? "zoom-in" : "grab";
        });

        const runAutoRotate = () => {
            if (settings.autoSpin === 1 && !isDragging && !isMouseOver && Math.abs(velocity) < 0.1) {
                updateImage(index + 1);
            }
            setTimeout(runAutoRotate, settings.speed);
        };
        runAutoRotate();
    });
});
