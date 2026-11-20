<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$config = require __DIR__ . '/includes/bootstrap.php';

$contact    = $config['contact'];
$address    = $config['address'];
$categories = $config['gallery_categories'];

// Solo se muestran fotos cuya categoría exista en la configuración.
$gallery = array_values(array_filter(
    $config['gallery'],
    static fn (array $img): bool => isset($categories[$img['category']])
));

$mapUrl = safe_external_url($address['maps_embed'], ['www.google.com']);
$instagramUser = preg_replace('/[^A-Za-z0-9._]/', '', $contact['instagram_user']) ?? '';
$fullAddress = sprintf('%s, %s %s, %s', $address['street'], $address['postal'], $address['city'], $address['region']);

require __DIR__ . '/templates/header.php';
?>
    <main id="contenido">

        <!-- Reservas -->
        <section class="section" aria-labelledby="reservas-titulo">
            <div class="container">
                <div class="panel">
                    <h1 id="reservas-titulo" class="section__title">Reserva directo en Airbnb</h1>

                    <div class="booking-grid">
                        <?php foreach ($config['airbnb_listings'] as $listing):
                            $url = airbnb_url($listing['id']);
                            if ($url === '') {
                                continue;
                            } ?>
                            <div class="booking-card">
                                <!-- El widget oficial de Airbnb reemplaza este contenido. Si no carga, quedan los enlaces. -->
                                <div class="airbnb-embed-frame"
                                     data-id="<?= e($listing['id']) ?>"
                                     data-view="home"
                                     data-hide-price="true">
                                    <a href="<?= e($url) ?>" target="_blank" rel="noopener noreferrer nofollow">Ver en Airbnb</a>
                                    <a href="<?= e($url) ?>" target="_blank" rel="noopener noreferrer nofollow"><?= e($listing['label']) ?></a>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <article class="features">
                            <h2 class="features__title">Dos caba�as iguales, en espejo</h2>
                            <p class="features__note">Cada una tiene:</p>
                            <ul class="features__list">
                                <?php foreach ($config['features'] as $feature): ?>
                                    <li><?= icon($feature['icon']) ?><span><?= e($feature['text']) ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galería + Instagram -->
        <section class="section" aria-labelledby="galeria-titulo">
            <div class="container media-grid">
                <div class="panel gallery" data-gallery>
                    <h2 id="galeria-titulo" class="section__title">Galería</h2>

                    <div class="gallery__filters" role="group" aria-label="Filtrar fotos">
                        <button type="button" class="chip" data-filter="all" aria-pressed="true">Todas</button>
                        <?php foreach ($categories as $key => $label): ?>
                            <button type="button" class="chip" data-filter="<?= e($key) ?>" aria-pressed="false"><?= e($label) ?></button>
                        <?php endforeach; ?>
                    </div>

                    <ul class="gallery__track" tabindex="0" aria-label="Fotos de las cabañas (desplázate horizontalmente)">
                        <?php foreach ($gallery as $i => $img): ?>
                            <li class="gallery__item" data-category="<?= e($img['category']) ?>">
                                <button type="button" class="gallery__thumb" aria-label="Ampliar foto: <?= e($img['alt']) ?>">
                                    <img src="<?= e($img['src']) ?>"
                                         alt="<?= e($img['alt']) ?>"
                                         width="350" height="250"
                                         <?= $i < 3 ? '' : 'loading="lazy"' ?>
                                         decoding="async">
                                </button>
                            </li>
                        <?php endforeach; ?>
                                        </ul>

                    <div class="gallery__cta">
                        <p>�Te gustaron las caba�as? Consulta disponibilidad directo con nosotros.</p>
                        <a class="btn btn--whatsapp"
                           href="<?= e(whatsapp_url($contact['whatsapp_number'], $contact['whatsapp_message'])) ?>"
                           target="_blank" rel="noopener noreferrer">
                            <?= icon('chat') ?> Escribir por WhatsApp
                        </a>
                    </div>
                </div>

                <aside class="panel instagram" aria-labelledby="instagram-titulo">
                    <h2 id="instagram-titulo" class="section__title">Instagram</h2>
                    <?php if ($instagramUser !== ''): ?>
                        <iframe class="instagram__embed"
                                src="https://www.instagram.com/<?= e($instagramUser) ?>/embed"
                                title="Publicaciones de @<?= e($instagramUser) ?> en Instagram"
                                loading="lazy"
                                referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        <a class="instagram__link" href="https://www.instagram.com/<?= e($instagramUser) ?>/" target="_blank" rel="noopener noreferrer">
                            <?= icon('camera') ?> @<?= e($instagramUser) ?>
                        </a>
                    <?php endif; ?>
                </aside>
            </div>
        </section>

        <!-- Ubicación -->
        <section class="section" aria-labelledby="ubicacion-titulo">
            <div class="container">
                <div class="panel">
                    <h2 id="ubicacion-titulo" class="section__title">Ubicación</h2>
                    <p class="map__address"><?= icon('pin') ?> <?= e($fullAddress) ?></p>
                    <?php if ($mapUrl !== ''): ?>
                        <div class="map__frame">
                            <iframe src="<?= e($mapUrl) ?>"
                                    title="Mapa: <?= e($fullAddress) ?>"
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Visor de fotos (usa <dialog>: accesible por teclado y lector de pantalla) -->
    <dialog class="lightbox" aria-label="Visor de fotos" data-lightbox>
        <figure class="lightbox__figure">
            <img class="lightbox__image" src="" alt="" data-lightbox-image>
            <figcaption class="lightbox__caption">
                <span data-lightbox-caption></span>
                <span class="lightbox__counter" data-lightbox-counter></span>
            </figcaption>
        </figure>
        <button type="button" class="lightbox__btn lightbox__btn--prev" data-lightbox-prev aria-label="Foto anterior"><?= icon('left') ?></button>
        <button type="button" class="lightbox__btn lightbox__btn--next" data-lightbox-next aria-label="Foto siguiente"><?= icon('right') ?></button>
        <button type="button" class="lightbox__btn lightbox__btn--close" data-lightbox-close aria-label="Cerrar visor"><?= icon('close') ?></button>
    </dialog>

    <!-- SDK de Airbnb: se carga una sola vez para todos los widgets. -->
    <script src="https://www.airbnb.cl/embeddable/airbnb_jssdk" async></script>
<?php require __DIR__ . '/templates/footer.php'; ?>
