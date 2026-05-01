document.querySelectorAll('.wp360-container').forEach(container => {

    const images = JSON.parse(container.dataset.images);
    let index = 0;

    const img = document.createElement('img');
    img.src = images[index];
    container.appendChild(img);

    let startX = 0;
    let isDragging = false;

    container.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX;
    });

    window.addEventListener('mouseup', () => {
        isDragging = false;
    });

    container.addEventListener('mousemove', (e) => {
        if (!isDragging) return;

        let diff = e.clientX - startX;

        if (Math.abs(diff) > 5) {
            if (diff > 0) {
                index = (index + 1) % images.length;
            } else {
                index = (index - 1 + images.length) % images.length;
            }

            img.src = images[index];
            startX = e.clientX;
        }
    });

});