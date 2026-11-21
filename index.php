<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$config = require __DIR__ . '/includes/bootstrap.php';

$contact    = $config['contact'];
$address    = $config['address'];
$categories = $config['gallery_categories'];
$quote      = $config['quote'];
$reviews    = $config['reviews'];

$googleHosts    = ['share.google', 'g.page', 'maps.app.goo.gl', 'www.google.com', 'search.google.com', 'maps.google.com'];
$reviewsUrl     = safe_external_url($reviews['url'], $googleHosts);
$writeReviewUrl = safe_external_url($reviews['write_url'], $googleHosts);

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
                    <p class="booking__cta">
                        ¿Prefieres consultar directo con nosotros?
                        <a class="btn btn--primary" href="#cotizar"><?= icon('chat') ?> Cotizar mi estadía</a>
                    </p>

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
                            <h2 class="features__title">Dos cabañas iguales, en espejo</h2>
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
                        <p>¿Te gustaron las cabañas? Consulta disponibilidad directo con nosotros.</p>
                        <a class="btn btn--whatsapp" href="#cotizar">
                            <?= icon('chat') ?> Cotizar mi estadía
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
        <!-- Cotización -->
        <section class="section" id="cotizar" aria-labelledby="cotizar-titulo">
            <div class="container contact-grid">
                <div class="panel quote">
                    <h2 id="cotizar-titulo" class="section__title">Cotiza tu estadía</h2>
                    <p class="quote__intro">Se abrirá WhatsApp con tu mensaje listo para enviar.</p>

                    <form class="quote__form" data-quote-form
                          data-whatsapp="<?= e($contact['whatsapp_number']) ?>"
                          data-min-nights="<?= e($quote['min_nights']) ?>" novalidate>

                        <div class="quote__grid">
                            <div class="field field--wide">
                                <label for="q-nombre">Tu nombre</label>
                                <input id="q-nombre" name="nombre" type="text" required
                                       maxlength="60" autocomplete="name">
                                <p class="field__error" id="q-nombre-error" hidden>Escribe tu nombre.</p>
                            </div>

                            <div class="field">
                                <label for="q-cabana">Cabaña</label>
                                <select id="q-cabana" name="cabana">
                                    <?php foreach ($quote['cabins'] as $cabin): ?>
                                        <option value="<?= e($cabin) ?>"><?= e($cabin) ?></option>
                                    <?php endforeach; ?>
                                    <option value="Cualquiera disponible">Cualquiera</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="q-personas">Personas</label>
                                <select id="q-personas" name="personas">
                                    <?php for ($n = 1; $n <= $quote['max_guests']; $n++): ?>
                                        <option value="<?= $n ?>" <?= $n === 2 ? 'selected' : '' ?>><?= $n ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="field field--half">
                                <label for="q-llegada">Llegada</label>
                                <input id="q-llegada" name="llegada" type="date" required>
                            </div>

                            <div class="field field--half">
                                <label for="q-salida">Salida <span class="quote__nights" data-quote-nights aria-live="polite"></span></label>
                                <input id="q-salida" name="salida" type="date" required>
                            </div>

                            <p class="field__error field--full" id="q-fechas-error" hidden></p>

                            <ul class="quote__rules field--full">
                                <li><?= icon('clock') ?> Llegada desde las <?= e($quote['check_in']) ?></li>
                                <li><?= icon('clock') ?> Salida hasta las <?= e($quote['check_out']) ?></li>
                                <li><?= icon('moon') ?> Mínimo <?= e($quote['min_nights']) ?> noches</li>
                            </ul>

                            <div class="field field--full">
                                <label for="q-comentario">Comentario <span class="field__hint">(opcional)</span></label>
                                <textarea id="q-comentario" name="comentario" rows="2" maxlength="500"
                                          placeholder="Ej.: llegamos tarde, viajamos con niños, consultas por mascotas..."></textarea>
                            </div>
                        </div>

                        <div class="quote__actions">
                            <button type="submit" class="btn btn--whatsapp quote__submit">
                                <?= icon('chat') ?> Enviar por WhatsApp
                            </button>
                            <p class="quote__privacy">Tus datos no se guardan: solo se usan para armar el mensaje.</p>
                        </div>
                    </form>

                    <noscript>
                        <p class="quote__noscript">
                            Para cotizar, escríbenos a
                            <a href="<?= e(whatsapp_url($contact['whatsapp_number'])) ?>">WhatsApp</a>
                            o a <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a>.
                        </p>
                    </noscript>
                </div>

                <!-- Opiniones de Google -->
                <aside class="panel reviews" aria-labelledby="opiniones-titulo">
                    <h2 id="opiniones-titulo" class="section__title">Opiniones en Google</h2>

                    <div class="reviews__summary">
                        <span class="reviews__score"><?= e(number_format((float) $reviews['rating'], 1, ',', '')) ?></span>
                        <div>
                            <?= star_rating((float) $reviews['rating']) ?>
                            <p class="reviews__count"><?= e($reviews['count']) ?> opiniones</p>
                        </div>
                    </div>

                    <ul class="reviews__list">
                        <?php foreach ($reviews['items'] as $review): ?>
                            <li class="review">
                                <span class="review__avatar" aria-hidden="true"><?= e(function_exists('mb_substr') ? mb_substr($review['name'], 0, 1) : substr($review['name'], 0, 1)) ?></span>
                                <div class="review__body">
                                    <p class="review__author">
                                        <?= e($review['name']) ?>
                                        <?php if ($review['badge'] !== ''): ?>
                                            <span class="review__badge"><?= e($review['badge']) ?></span>
                                        <?php endif; ?>
                                    </p>
                                    <?= star_rating(5, 'stars stars--small') ?>
                                    <blockquote class="review__text"><p><?= e($review['text']) ?></p></blockquote>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if (!empty($reviews['also'])): ?>
                        <p class="reviews__also">
                            También nos dieron 5 estrellas: <?= e(implode(', ', $reviews['also'])) ?> y más.
                        </p>
                    <?php endif; ?>

                    <div class="reviews__actions">
                        <?php if ($reviewsUrl !== ''): ?>
                            <a class="btn btn--outline" href="<?= e($reviewsUrl) ?>" target="_blank" rel="noopener noreferrer">Ver todas en Google</a>
                        <?php endif; ?>
                        <?php if ($writeReviewUrl !== ''): ?>
                            <a class="btn btn--primary" href="<?= e($writeReviewUrl) ?>" target="_blank" rel="noopener noreferrer">Dejar una opinión</a>
                        <?php endif; ?>
                    </div>
                </aside>
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

    <script src="<?= e(asset('assets/js/cotizacion.js')) ?>" defer></script>

    <!-- SDK de Airbnb: se carga una sola vez para todos los widgets. -->
    <script src="https://www.airbnb.cl/embeddable/airbnb_jssdk" async></script>
<?php require __DIR__ . '/templates/footer.php'; ?>