<?php

declare(strict_types=1);

/**
 * Configuración central del sitio.
 *
 * Todo el contenido editable vive aquí: para cambiar un teléfono, una foto
 * o un texto no es necesario tocar el HTML.
 */
return [
    'site' => [
        'name'        => 'Las Pleyades',
        'tagline'     => 'Arriendo de Cabañas',
        'description' => 'Cabañas para 4 o 5 personas en El Quisco, a 2 minutos caminando de la playa. '
                       . 'Cocina equipada, quincho privado y estacionamiento. Reserva directo en Airbnb.',
        'url'         => 'https://cabanaslaspleyades.cl',
        'locale'      => 'es_CL',
        'lang'        => 'es',
        'logo'        => 'img/Logo.png',
        'og_image'    => 'img/playa/01_playa.jpg',
        // Foto grande de la portada (cámbiala por la que más te guste).
        'hero_image'  => 'img/playa/05_cabanas_portada.jpg',
        // Minutos caminando a la playa (se usa en la portada, la lista y el mapa).
        'beach_minutes' => 2,
    ],

    'contact' => [
        // Solo dígitos, con código de país; se usa para armar el enlace wa.me.
        'whatsapp_number'  => '56983215511',
        'whatsapp_display' => '+56 9 8321 5511',
        'whatsapp_message' => 'Hola, quisiera consultar disponibilidad en Cabañas Las Pleyades.',
        'email'            => 'contacto@cabanaslaspleyades.cl',
        'instagram_user'   => 'cabanaslaspleyades',
    ],

    'address' => [
        'street'   => 'Pje. Pléyades 840',
        'postal'   => '2701765',
        'city'     => 'El Quisco',
        'region'   => 'Valparaíso',
        'country'  => 'CL',
        'lat'      => -33.16153937354966,
        'lng'      => -71.71262392433392,
        'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3340.552316989176!2d-71.71262392433392!3d-33.16153937354966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9669c12e6c7769c7%3A0x7f58c3f48c54c0e8!2sPje.%20Pl%C3%A9yades%20840%2C%202701765%20El%20Quisco%2C%20Valpara%C3%ADso!5e0!3m2!1ses!2scl!4v1653941234567!5m2!1ses!2scl',
    ],

    // Anuncios de Airbnb. Se muestran como tarjetas propias (sin el widget de Airbnb,
    // que trae barras de desplazamiento y no se puede ajustar).
    // Actualiza 'rating' cuando cambie la calificación en Airbnb.
    'airbnb_listings' => [
        [
            'id'     => '633184179397126110',
            'title'  => 'Cabaña 1',
            'image'  => 'img/cabana1/01_01.jpeg',
            'rating' => 4.64,
            'label'  => '2 dormitorios · 3 camas · 1 baño',
        ],
        [
            'id'     => '792266268813760127',
            'title'  => 'Cabaña 2',
            'image'  => 'img/cabana2/02_01.jpg',
            'rating' => 4.58,
            'label'  => '2 dormitorios · 3 camas · 1 baño',
        ],
    ],

    // Formulario de cotización (se envía como mensaje de WhatsApp).
    'quote' => [
        'cabins'     => ['Cabaña 1', 'Cabaña 2'],
        'max_guests' => 5,
        'min_nights' => 2,
        'check_in'   => '15:00',
        'check_out'  => '12:00',
    ],

    // Opiniones de Google (se actualizan a mano copiando desde Google).
    'reviews' => [
        'rating'    => 4.9,
        'count'     => 17,
        // Enlace a la ficha en Google ("Ver todas").
        'url'       => 'https://share.google/HyD25ODlWxmhCmJli',
        // Enlace para dejar una opinión: en Google, botón "Consigue más opiniones".
        // Si queda vacío, el botón no se muestra.
        'write_url' => '',
        'items' => [
            [
                'name'  => 'Paula M.',
                'date'  => 'Noviembre 2026',
                'text'  => 'Excelente lugar para descansar 🌟. Es muy acogedor y tranquilo. La experiencia fue maravillosa, especialmente por la atención de la administradora, quien siempre estuvo disponible y dispuesta a responder todas mis dudas. Sin duda, un lugar excepcional, totalmente recomendable. ¡Espero volver pronto!',
                'badge' => '',
            ],
            [
                'name'  => 'Rodolfo Z.',
                'date'  => 'Enero 2026',
                'text'  => 'Excelente, súper cerca de todo lo que se necesite y están súper equipadas.',
                'badge' => 'Local Guide',
            ],
            [
                'name'  => 'Ariel C.',
                'date'  => 'Junio 2025',
                'text'  => 'Excelente lugar para descansar y muy cercano a la playa. Lo mejor de todo... es pet-friendly. Las cabañas son bonitas, cómodas, y un buen espacio.',
                'badge' => '',
            ],
        ],
        // Personas que calificaron con 5 estrellas sin dejar comentario (vacío = no se muestra).
        'also' => [],
    ],

    // Nombre de ícono (ver includes/icons.php) => texto.
    'features' => [
        ['icon' => 'waves',    'text' => 'A 2 minutos caminando de la playa'],
        ['icon' => 'bed',      'text' => '2 dormitorios y 1 baño'],
        ['icon' => 'utensils', 'text' => 'Cocina equipada'],
        ['icon' => 'bed',      'text' => 'Dormitorio principal con cama de 2 plazas'],
        ['icon' => 'bed',      'text' => 'Segundo dormitorio con camarote (2 plazas abajo y plaza y media arriba)'],
        ['icon' => 'parking',  'text' => 'Estacionamiento compartido'],
        ['icon' => 'flame',    'text' => 'Pequeño quincho privado'],
        ['icon' => 'tree',     'text' => 'Patio compartido'],
        ['icon' => 'users',    'text' => 'Para 4 o 5 personas'],
    ],

    // Categorías de la galería: clave => etiqueta del botón.
    'gallery_categories' => [
        'playa'    => 'Playa y vistas',
        'exterior' => 'Exterior',
        'cabana1'  => 'Cabaña 1',
        'cabana2'  => 'Cabaña 2',
    ],

    // Las rutas de imágenes son las mismas del sitio original.
    'gallery' => [
        ['src' => 'img/playa/01_playa.jpg',        'alt' => 'La playa, a 2 minutos caminando',      'category' => 'playa'],
        ['src' => 'img/playa/02_vista_mar.jpg',    'alt' => 'Vista al mar desde las cabañas',       'category' => 'playa'],
        ['src' => 'img/playa/03_vista_terreno.jpg','alt' => 'Terreno, estacionamiento y vista al mar', 'category' => 'playa'],
        ['src' => 'img/playa/04_cabanas.jpg',      'alt' => 'Frente de las cabañas',                'category' => 'exterior'],

        ['src' => 'img/exterior/00_01.jpeg', 'alt' => 'Vista exterior de las cabañas', 'category' => 'exterior'],
        ['src' => 'img/exterior/00_02.jpg',  'alt' => 'Jardín y áreas verdes',         'category' => 'exterior'],
        ['src' => 'img/exterior/00_03.jpg',  'alt' => 'Entrada principal',             'category' => 'exterior'],
        ['src' => 'img/exterior/00_04.jpeg', 'alt' => 'Patio compartido',              'category' => 'exterior'],
        ['src' => 'img/exterior/00_05.jpeg', 'alt' => 'Área de estacionamiento',       'category' => 'exterior'],
        ['src' => 'img/exterior/00_06.jpg',  'alt' => 'Vista hacia la playa',          'category' => 'exterior'],
        ['src' => 'img/exterior/00_07.jpg',  'alt' => 'Quincho y parrilla',            'category' => 'exterior'],
        ['src' => 'img/exterior/00_08.jpeg', 'alt' => 'Terraza exterior',              'category' => 'exterior'],
        ['src' => 'img/exterior/00_09.jpeg', 'alt' => 'Paisaje natural',               'category' => 'exterior'],
        ['src' => 'img/exterior/00_10.jpg',  'alt' => 'Ambiente relajante',            'category' => 'exterior'],

        ['src' => 'img/cabana1/01_01.jpeg', 'alt' => 'Sala de estar, cabaña 1',        'category' => 'cabana1'],
        ['src' => 'img/cabana1/01_02.jpeg', 'alt' => 'Dormitorio principal, cabaña 1', 'category' => 'cabana1'],
        ['src' => 'img/cabana1/01_03.jpeg', 'alt' => 'Cocina equipada, cabaña 1',      'category' => 'cabana1'],
        ['src' => 'img/cabana1/01_04.jpeg', 'alt' => 'Baño, cabaña 1',                 'category' => 'cabana1'],
        ['src' => 'img/cabana1/01_05.jpeg', 'alt' => 'Detalles de decoración, cabaña 1', 'category' => 'cabana1'],
        ['src' => 'img/cabana1/01_06.jpeg', 'alt' => 'Camarote, cabaña 1',             'category' => 'cabana1'],
        ['src' => 'img/cabana1/01_07.jpeg', 'alt' => 'Vista general, cabaña 1',        'category' => 'cabana1'],

        ['src' => 'img/cabana2/02_01.jpg',  'alt' => 'Sala de estar, cabaña 2',        'category' => 'cabana2'],
        ['src' => 'img/cabana2/02_02.jpeg', 'alt' => 'Dormitorio, cabaña 2',           'category' => 'cabana2'],
        ['src' => 'img/cabana2/02_03.jpeg', 'alt' => 'Cocina, cabaña 2',               'category' => 'cabana2'],
        ['src' => 'img/cabana2/02_04.jpeg', 'alt' => 'Baño, cabaña 2',                 'category' => 'cabana2'],
        ['src' => 'img/cabana2/02_05.jpeg', 'alt' => 'Área de descanso, cabaña 2',     'category' => 'cabana2'],
        ['src' => 'img/cabana2/02_06.jpeg', 'alt' => 'Detalles, cabaña 2',             'category' => 'cabana2'],
    ],

    'security' => [
        /*
         * Mientras esté en true, el navegador solo REPORTA en la consola lo que la
         * política CSP bloquearía, sin bloquearlo. Revisa la consola (F12) con el
         * sitio publicado; si no aparecen avisos, cámbialo a false para aplicarla.
         */
        'csp_report_only' => true,
    ],
];
