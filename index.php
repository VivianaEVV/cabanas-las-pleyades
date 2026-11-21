<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$config = require __DIR__ . '/includes/bootstrap.php';

$contact    = $config['contact'];
$address    = $config['address'];
$categories = $config['gallery_categories'];
$quote      = $config['quote'];

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
            <div class="container">
                <div class="panel quote">
                    <h2 id="cotizar-titulo" class="section__title">Cotiza tu estadía</h2>
                    <p class="quote__intro">Completa los datos y se abrirá WhatsApp con tu mensaje listo para enviar.</p>

                    <form class="quote__form" data-quote-form
                          data-whatsapp="<?= e($contact['whatsapp_number']) ?>" novalidate>

                        <div class="field">
                            <label for="q-nombre">Tu nombre</label>
                            <input id="q-nombre" name="nombre" type="text" required
                                   maxlength="60" autocomplete="name">
                            <p class="field__error" id="q-nombre-error" hidden>Escribe tu nombre.</p>
                        </div>

                        <fieldset class="field">
                            <legend>Cabaña</legend>
                            <div class="choice-group">
                                <?php foreach ($quote['cabins'] as $i => $cabin): ?>
                                    <label class="choice">
                                        <input type="radio" name="cabana" value="<?= e($cabin) ?>" <?= $i === 0 ? 'checked' : '' ?>>
                                        <span><?= e($cabin) ?></span>
                                    </label>
                                <?php endforeach; ?>
                                <label class="choice">
                                    <input type="radio" name="cabana" value="Cualquiera disponible">
                                    <span>Cualquiera</span>
                                </label>
                            </div>
                        </fieldset>

                        <div class="field-row">
                            <div class="field">
                                <label for="q-llegada">Llegada</label>
                                <input id="q-llegada" name="llegada" type="date" required>
                            </div>
                            <div class="field">
                                <label for="q-salida">Salida</label>
                                <input id="q-salida" name="salida" type="date" required>
                            </div>
                        </div>
                        <p class="field__error" id="q-fechas-error" hidden></p>
                        <p class="quote__nights" data-quote-nights aria-live="polite"></p>

                        <fieldset class="field">
                            <legend>Personas <span class="field__hint">(máximo <?= e($quote['max_guests']) ?>)</span></legend>
                            <div class="choice-group">
                                <?php for ($n = 1; $n <= $quote['max_guests']; $n++): ?>
                                    <label class="choice choice--number">
                                        <input type="radio" name="personas" value="<?= $n ?>" <?= $n === 2 ? 'checked' : '' ?>>
                                        <span><?= $n ?></span>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </fieldset>

                        <div class="field">
                            <label for="q-comentario">Comentario <span class="field__hint">(opcional)</span></label>
                            <textarea id="q-comentario" name="comentario" rows="4" maxlength="500"
                                      placeholder="Ej.: llegamos tarde, viajamos con niños, consultas por mascotas?"></textarea>
                        </div>

                        <button type="submit" class="btn btn--whatsapp quote__submit">
                            <?= icon('chat') ?> Enviar cotización por WhatsApp
                        </button>
                        <p class="quote__privacy">Tus datos no se guardan en esta página: solo se usan para armar el mensaje.</p>
                    </form>

                    <noscript>
                        <p class="quote__noscript">
                            Para cotizar, escríbenos a
                            <a href="<?= e(whatsapp_url($contact['whatsapp_number'])) ?>">WhatsApp</a>
                            o a <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a>.
                        </p>
                    </noscript>
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

    <script src="<?= e(asset('assets/js/cotizacion.js')) ?>" defer></script>

    <!-- SDK de Airbnb: se carga una sola vez para todos los widgets. -->
    <script src="https://www.airbnb.cl/embeddable/airbnb_jssdk" async></script>
<?php require __DIR__ . '/templates/footer.php'; ?>