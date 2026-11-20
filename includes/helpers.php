<?php

declare(strict_types=1);

/**
 * Escapa texto para imprimirlo de forma segura dentro de HTML o de un atributo.
 * Toda salida dinámica del sitio debe pasar por aquí.
 */
function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

/**
 * Devuelve la ruta de un archivo estático con un parámetro de versión basado en
 * su fecha de modificación, para que el navegador descargue la versión nueva
 * cada vez que el archivo cambie (cache busting).
 */
function asset(string $path): string
{
    $path = ltrim($path, '/');
    $file = dirname(__DIR__) . '/' . $path;

    if (is_file($file)) {
        return $path . '?v=' . filemtime($file);
    }

    return $path;
}

/**
 * Valida que una URL externa use https y pertenezca a un dominio permitido.
 * Evita que un error de configuración inyecte un iframe o enlace arbitrario.
 *
 * @param list<string> $allowedHosts
 */
function safe_external_url(string $url, array $allowedHosts): string
{
    $parts = parse_url($url);

    if (
        $parts === false
        || ($parts['scheme'] ?? '') !== 'https'
        || !in_array($parts['host'] ?? '', $allowedHosts, true)
    ) {
        return '';
    }

    return $url;
}

/** Enlace a WhatsApp con mensaje prellenado. */
function whatsapp_url(string $number, string $message = ''): string
{
    $number = preg_replace('/\D+/', '', $number) ?? '';
    $url    = 'https://wa.me/' . $number;

    return $message !== '' ? $url . '?text=' . rawurlencode($message) : $url;
}

/** Enlace a un anuncio de Airbnb a partir de su ID numérico. */
function airbnb_url(string $id): string
{
    if (!ctype_digit($id)) {
        return '';
    }

    return 'https://www.airbnb.cl/rooms/' . $id;
}

/** Envía las cabeceras HTTP de seguridad. Debe llamarse antes de imprimir HTML. */
function send_security_headers(bool $cspReportOnly = true): void
{
    if (headers_sent()) {
        return;
    }

    // Solo se permiten los orígenes externos que el sitio realmente usa.
    $csp = implode('; ', [
        "default-src 'self'",
        "base-uri 'self'",
        "object-src 'none'",
        "form-action 'self'",
        "frame-ancestors 'none'",
        "script-src 'self' https://www.airbnb.cl https://*.airbnb.cl https://*.airbnb.com https://*.muscache.com",
        // El widget de Airbnb inserta estilos en línea; por eso 'unsafe-inline' solo en estilos.
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com",
        "img-src 'self' data: https://*.airbnb.com https://*.airbnb.cl https://*.muscache.com",
        "frame-src https://www.google.com https://www.instagram.com https://*.airbnb.cl https://*.airbnb.com",
        "connect-src 'self' https://*.airbnb.cl https://*.airbnb.com",
        'upgrade-insecure-requests',
    ]);

    header(($cspReportOnly ? 'Content-Security-Policy-Report-Only: ' : 'Content-Security-Policy: ') . $csp);
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
    header('Cross-Origin-Opener-Policy: same-origin');

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    if ($isHttps) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    // Oculta la versión de PHP (también conviene desactivar expose_php en php.ini).
    header_remove('X-Powered-By');
}

/**
 * Datos estructurados (schema.org) para que Google entienda que es un alojamiento.
 *
 * @param array<string, mixed> $config
 */
function structured_data(array $config): string
{
    $site    = $config['site'];
    $address = $config['address'];
    $contact = $config['contact'];

    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => 'LodgingBusiness',
        'name'        => 'Cabañas ' . $site['name'],
        'description' => $site['description'],
        'url'         => $site['url'],
        'image'       => rtrim($site['url'], '/') . '/' . $site['og_image'],
        'telephone'   => '+' . $contact['whatsapp_number'],
        'email'       => $contact['email'],
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $address['street'],
            'postalCode'      => $address['postal'],
            'addressLocality' => $address['city'],
            'addressRegion'   => $address['region'],
            'addressCountry'  => $address['country'],
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => $address['lat'],
            'longitude' => $address['lng'],
        ],
        'sameAs' => ['https://www.instagram.com/' . $contact['instagram_user'] . '/'],
    ];

    // Las banderas JSON_HEX_* impiden cerrar la etiqueta <script> desde los datos.
    return (string) json_encode(
        $data,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    );
}
