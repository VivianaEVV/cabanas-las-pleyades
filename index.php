<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$config = require __DIR__ . '/includes/bootstrap.php';

$site       = $config['site'];
$contact    = $config['contact'];
$beachMinutes = (int) $site['beach_minutes'];
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

    <!-- Portada -->
        <section class="portada" aria-labelledby="hero-titulo">
            <!-- Formas de fondo (decorativas) -->
            <svg class="portada__fondo" viewBox="0 0 1440 600" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                <path class="portada__mancha portada__mancha--coral" d="M1180 0 H1440 V170 C1380 190 1330 140 1290 95 C1250 50 1200 40 1180 0 Z"/>
                <path class="portada__mancha portada__mancha--coral" d="M1440 420 V600 H1110 C1150 560 1210 520 1290 515 C1360 510 1400 470 1440 420 Z"/>
                <path class="portada__mancha portada__mancha--agua" d="M0 0 H860 C800 60 860 130 820 200 C780 270 700 260 690 340 C680 420 760 470 700 540 C670 575 610 600 560 600 H0 Z"/>
                <path class="portada__mancha portada__mancha--mar" d="M0 0 H780 C720 70 770 140 720 210 C670 280 590 270 585 350 C580 430 640 480 560 560 C530 590 480 600 440 600 H0 Z"/>
            </svg>

            <!-- Dibujos de playa: estrellas de mar y una ola (decorativos) -->
            <svg class="portada__dibujo portada__dibujo--estrella1" viewBox="0 0 100 100" aria-hidden="true" focusable="false">
                <path d="M38.8 36.6 C41.5 22.2 43.5 22.7 43.5 11.5 Q50.0 7.0 56.5 11.5 C56.5 22.7 58.5 22.2 61.2 36.6 C75.7 34.7 75.8 36.7 86.5 33.3 Q92.8 38.1 90.5 45.7 C79.9 49.2 81.0 50.9 68.1 57.9 C74.4 71.1 72.5 71.8 79.1 80.9 Q76.5 88.4 68.5 88.6 C61.9 79.5 60.6 81.1 50.0 71.0 C39.4 81.1 38.1 79.5 31.5 88.6 Q23.5 88.4 20.9 80.9 C27.5 71.8 25.6 71.1 31.9 57.9 C19.0 50.9 20.1 49.2 9.5 45.7 Q7.2 38.1 13.5 33.3 C24.2 36.7 24.3 34.7 38.8 36.6 Z"/>
                <g class="portada__puntos">
                    <circle cx="50.0" cy="40.0" r="2.2"/>
                    <circle cx="50.0" cy="30.0" r="2.2"/>
                    <circle cx="50.0" cy="21.0" r="2.2"/>
                    <circle cx="61.4" cy="48.3" r="2.2"/>
                    <circle cx="70.9" cy="45.2" r="2.2"/>
                    <circle cx="79.5" cy="42.4" r="2.2"/>
                    <circle cx="57.1" cy="61.7" r="2.2"/>
                    <circle cx="62.9" cy="69.8" r="2.2"/>
                    <circle cx="68.2" cy="77.1" r="2.2"/>
                    <circle cx="42.9" cy="61.7" r="2.2"/>
                    <circle cx="37.1" cy="69.8" r="2.2"/>
                    <circle cx="31.8" cy="77.1" r="2.2"/>
                    <circle cx="38.6" cy="48.3" r="2.2"/>
                    <circle cx="29.1" cy="45.2" r="2.2"/>
                    <circle cx="20.5" cy="42.4" r="2.2"/>
                    <circle cx="50" cy="52" r="2.6"/>
                </g>
            </svg>
            <svg class="portada__dibujo portada__dibujo--estrella2" viewBox="0 0 100 100" aria-hidden="true" focusable="false">
                <path d="M38.8 36.6 C41.5 22.2 43.5 22.7 43.5 11.5 Q50.0 7.0 56.5 11.5 C56.5 22.7 58.5 22.2 61.2 36.6 C75.7 34.7 75.8 36.7 86.5 33.3 Q92.8 38.1 90.5 45.7 C79.9 49.2 81.0 50.9 68.1 57.9 C74.4 71.1 72.5 71.8 79.1 80.9 Q76.5 88.4 68.5 88.6 C61.9 79.5 60.6 81.1 50.0 71.0 C39.4 81.1 38.1 79.5 31.5 88.6 Q23.5 88.4 20.9 80.9 C27.5 71.8 25.6 71.1 31.9 57.9 C19.0 50.9 20.1 49.2 9.5 45.7 Q7.2 38.1 13.5 33.3 C24.2 36.7 24.3 34.7 38.8 36.6 Z"/>
                <g class="portada__puntos">
                    <circle cx="50.0" cy="40.0" r="2.2"/>
                    <circle cx="50.0" cy="30.0" r="2.2"/>
                    <circle cx="50.0" cy="21.0" r="2.2"/>
                    <circle cx="61.4" cy="48.3" r="2.2"/>
                    <circle cx="70.9" cy="45.2" r="2.2"/>
                    <circle cx="79.5" cy="42.4" r="2.2"/>
                    <circle cx="57.1" cy="61.7" r="2.2"/>
                    <circle cx="62.9" cy="69.8" r="2.2"/>
                    <circle cx="68.2" cy="77.1" r="2.2"/>
                    <circle cx="42.9" cy="61.7" r="2.2"/>
                    <circle cx="37.1" cy="69.8" r="2.2"/>
                    <circle cx="31.8" cy="77.1" r="2.2"/>
                    <circle cx="38.6" cy="48.3" r="2.2"/>
                    <circle cx="29.1" cy="45.2" r="2.2"/>
                    <circle cx="20.5" cy="42.4" r="2.2"/>
                    <circle cx="50" cy="52" r="2.6"/>
                </g>
            </svg>
            <svg class="portada__dibujo portada__dibujo--ola" viewBox="0 0 140 50" aria-hidden="true" focusable="false">
                <path d="M4 44 C20 44 24 12 50 10 C70 8 80 24 70 33 C62 40 50 33 55 25 C58 20 65 21 66 26 M70 33 C80 43 96 45 110 39 C120 35 126 31 136 31"/>
            </svg>

            <div class="container portada__grid">
                <div class="portada__texto">
                    <p class="portada__chip"><?= icon('walk') ?> <?= e($beachMinutes) ?> min caminando a la playa</p>
                    <h1 id="hero-titulo" class="portada__titulo">Despierta a pasos del mar</h1>
                    <p class="portada__datos">Caba&ntilde;as para 4 a 5 personas &middot; El Quisco &middot; Litoral Central</p>
                    <p class="portada__mascotas">
                        <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
                            <circle cx="5" cy="10" r="2.3"/><circle cx="9.5" cy="5.5" r="2.3"/><circle cx="14.5" cy="5.5" r="2.3"/><circle cx="19" cy="10" r="2.3"/>
                            <path d="M12 11c-3 0-6.5 4.2-6.5 7 0 1.7 1.3 2.6 3 2.6 1.4 0 2.3-.8 3.5-.8s2.1.8 3.5.8c1.7 0 3-.9 3-2.6 0-2.8-3.5-7-6.5-7z"/>
                        </svg>
                        &iexcl;Somos pet-friendly!
                    </p>
                    <div class="portada__acciones">
                        <a class="btn btn--sun" href="#cotizar"><?= icon('chat') ?> Cotizar mi estad&iacute;a</a>
                        <a class="btn btn--glass" href="#galeria">Ver fotos</a>
                    </div>
                </div>

                <!-- Fotos tipo postal. Cambia las rutas para usar otras fotos. -->
                <div class="portada__fotos">
                    <figure class="portada__foto portada__foto--a">
                        <img src="img/cabana2/02_01.jpg" alt="Comedor y cocina de la caba&ntilde;a" fetchpriority="high" decoding="async">
                    </figure>
                    <figure class="portada__foto portada__foto--b">
                        <img src="img/playa/03_vista_terreno.jpg" alt="Terreno, estacionamiento y vista al mar" fetchpriority="high" decoding="async">
                    </figure>
                    <figure class="portada__foto portada__foto--c">
                        <img src="img/cabana1/01_03.jpeg" alt="Dormitorio principal" decoding="async">
                    </figure>
                    <figure class="portada__foto portada__foto--d">
                        <img src="img/playa/04_cabanas.jpg" alt="Frente de las caba&ntilde;as" decoding="async">
                    </figure>
                </div>
            </div>

            <svg class="hero__wave" viewBox="0 0 1440 90" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                <path d="M0 50 C 180 90 360 10 540 40 S 900 90 1080 50 S 1320 10 1440 40 L1440 90 L0 90 Z"/>
            </svg>
        </section>
        <!-- Reservas -->
        <section class="section" aria-labelledby="reservas-titulo">
            <div class="container">
                <div class="panel">
                    <h2 id="reservas-titulo" class="section__title">Reserva directo en Airbnb</h2>
                    <p class="booking__cta">
                        <span><strong>Reserva directo y paga hasta 15% menos</strong> que en Airbnb.</span>
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
        <section class="section" id="galeria" aria-labelledby="galeria-titulo">
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
                    <p class="map__beach"><?= icon('walk') ?> A <?= e($beachMinutes) ?> minutos caminando de la playa</p>
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
                    <p class="quote__intro">Cotizando directo pagas hasta 15% menos que en Airbnb.</p>
                    <p class="quote__intro">Se abrir&aacute; WhatsApp con tu mensaje listo para enviar.</p>

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
                                <img class="btn__logo" src="img/whatsapp.png" alt="" width="22" height="22"> Enviar por WhatsApp
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
