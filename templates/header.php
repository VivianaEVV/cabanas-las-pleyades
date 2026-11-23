<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$site    = $config['site'];
$contact = $config['contact'];
$pageTitle = 'Cabañas ' . $site['name'] . ' en El Quisco | A ' . $site['beach_minutes'] . ' min de la playa';
$ogImage   = rtrim($site['url'], '/') . '/' . $site['og_image'];
?>
<!DOCTYPE html>
<html lang="<?= e($site['lang']) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($site['description']) ?>">
    <meta name="theme-color" content="#1f3347">
    <link rel="canonical" href="<?= e($site['url']) ?>">
    <link rel="icon" href="<?= e($site['logo']) ?>" type="image/png">

    <!-- Vista previa al compartir en WhatsApp, Facebook, etc. -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?= e($site['locale']) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($site['description']) ?>">
    <meta property="og:url" content="<?= e($site['url']) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= e(asset('assets/css/styles.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('assets/css/hero.css')) ?>">

    <script type="application/ld+json"><?= structured_data($config) ?></script>
    <script src="<?= e(asset('assets/js/main.js')) ?>" defer></script>
</head>
<body>
    <a class="skip-link" href="#contenido">Saltar al contenido</a>

    <header class="site-header">
        <div class="container site-header__inner">
            <a class="brand" href="./" aria-label="<?= e($site['name']) ?>, inicio">
                <img class="brand__logo" src="<?= e($site['logo']) ?>" alt="" width="100" height="100">
                <span class="brand__text">
                    <span class="brand__name"><?= e($site['name']) ?></span>
                    <span class="brand__tagline"><?= e($site['tagline']) ?></span>
                </span>
            </a>

            <nav class="contact-links" aria-label="Contacto">
                <a class="btn btn--whatsapp"
                   href="<?= e(whatsapp_url($contact['whatsapp_number'], $contact['whatsapp_message'])) ?>"
                   target="_blank" rel="noopener noreferrer">
                    <img class="btn__logo" src="img/whatsapp.png" alt="" width="22" height="22">
                    <span>WhatsApp <span class="btn__detail"><?= e($contact['whatsapp_display']) ?></span></span>
                </a>
                <a class="btn btn--email" href="mailto:<?= e($contact['email']) ?>"
                   aria-label="Enviar un correo a <?= e($contact['email']) ?>">
                    <?= icon('mail') ?>
                    <span>Correo <span class="btn__detail"><?= e($contact['email']) ?></span></span>
                </a>
            </nav>
        </div>
    </header>