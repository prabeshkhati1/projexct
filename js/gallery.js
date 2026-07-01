document.addEventListener('DOMContentLoaded', () => {
    const lightbox = document.querySelector('.lightbox');
    if (!lightbox) return;
    const img = lightbox.querySelector('img');
    const caption = lightbox.querySelector('.lightbox-caption');
    const close = lightbox.querySelector('.close-lightbox');

    document.querySelectorAll('.gallery-item').forEach(btn => {
        btn.addEventListener('click', () => {
            img.src = btn.dataset.image;
            img.alt = btn.dataset.title;
            img.classList.remove('zoomed');
            caption.textContent = btn.dataset.title;
            lightbox.classList.add('open');
        });
    });

    img.addEventListener('click', () => img.classList.toggle('zoomed'));
    close.addEventListener('click', () => lightbox.classList.remove('open'));
    lightbox.addEventListener('click', e => {
        if (e.target === lightbox) lightbox.classList.remove('open');
    });
});
