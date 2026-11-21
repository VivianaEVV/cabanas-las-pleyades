/**
 * Las Pleyades: galerí­a filtrable y visor de fotos.
 * Sin dependencias. No usa innerHTML con datos (evita inyecciÃ³n de HTML).
 */
(() => {
    'use strict';

    const gallery = document.querySelector('[data-gallery]');
    const dialog = document.querySelector('[data-lightbox]');

    if (!gallery || !dialog) {
        return;
    }

    const filterButtons = [...gallery.querySelectorAll('[data-filter]')];
    const items = [...gallery.querySelectorAll('.gallery__item')];
    const track = gallery.querySelector('.gallery__track');

    const image = dialog.querySelector('[data-lightbox-image]');
    const caption = dialog.querySelector('[data-lightbox-caption]');
    const counter = dialog.querySelector('[data-lightbox-counter]');

    /** Fotos visibles segÃºn el filtro activo (lo que recorre el visor). */
    let visible = items;
    let current = 0;

    // ---------- Filtros ----------
    function applyFilter(category) {
        visible = items.filter((item) => category === 'all' || item.dataset.category === category);

        items.forEach((item) => {
            item.hidden = !visible.includes(item);
        });

        filterButtons.forEach((btn) => {
            btn.setAttribute('aria-pressed', String(btn.dataset.filter === category));
        });

        track.scrollTo({ left: 0, behavior: 'smooth' });
    }

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => applyFilter(btn.dataset.filter));
    });

    // ---------- Visor ----------
    function show(index) {
        const total = visible.length;
        if (total === 0) {
            return;
        }

        current = (index + total) % total; // navegaciÃ³n circular
        const thumb = visible[current].querySelector('img');

        image.src = thumb.currentSrc || thumb.src;
        image.alt = thumb.alt;
        caption.textContent = thumb.alt;
        counter.textContent = `${current + 1} / ${total}`;

        // Precarga la siguiente para que el cambio sea instantÃ¡neo.
        const next = visible[(current + 1) % total].querySelector('img');
        if (next) {
            new Image().src = next.src;
        }
    }

    function open(index) {
        show(index);
        if (!dialog.open) {
            dialog.showModal(); // maneja foco, Escape y bloquea el fondo
        }
    }

    // Se calcula el Ã­ndice dentro de las fotos VISIBLES
    // (el cÃ³digo anterior usaba el Ã­ndice global y abrÃ­a la foto equivocada al filtrar).
    gallery.addEventListener('click', (event) => {
        const thumb = event.target.closest('.gallery__thumb');
        if (!thumb) {
            return;
        }
        const index = visible.indexOf(thumb.closest('.gallery__item'));
        if (index !== -1) {
            open(index);
        }
    });

    dialog.querySelector('[data-lightbox-prev]').addEventListener('click', () => show(current - 1));
    dialog.querySelector('[data-lightbox-next]').addEventListener('click', () => show(current + 1));
    dialog.querySelector('[data-lightbox-close]').addEventListener('click', () => dialog.close());

    // Cerrar al hacer clic en el fondo oscuro.
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    // Al cerrar, devolver el foco a la miniatura correspondiente.
    dialog.addEventListener('close', () => {
        visible[current]?.querySelector('.gallery__thumb')?.focus();
    });

    dialog.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            show(current - 1);
        } else if (event.key === 'ArrowRight') {
            show(current + 1);
        }
    });

    // Deslizar con el dedo en celulares.
    let touchStartX = null;

    dialog.addEventListener('touchstart', (event) => {
        touchStartX = event.changedTouches[0].clientX;
    }, { passive: true });

    dialog.addEventListener('touchend', (event) => {
        if (touchStartX === null) {
            return;
        }
        const delta = event.changedTouches[0].clientX - touchStartX;
        touchStartX = null;

        if (Math.abs(delta) > 50) {
            show(delta > 0 ? current - 1 : current + 1);
        }
    }, { passive: true });
})();
