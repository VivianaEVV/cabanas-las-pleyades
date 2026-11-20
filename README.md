# Las Pleyades: sitio web

Sitio de Cabañas Las Pleyades (El Quisco). PHP 8.1+ sin frameworks ni dependencias.

## Estructura

```
.
├── index.php              Página principal (solo presentación)
├── .htaccess              HTTPS, bloqueo de carpetas internas, caché, compresión
├── includes/
│   ├── bootstrap.php      Arranque: carga config, helpers y envía cabeceras
│   ├── config.php         ← TODO el contenido editable (contacto, fotos, textos)
│   ├── helpers.php        Escape de HTML, cabeceras de seguridad, URLs seguras
│   └── icons.php          Íconos SVG (reemplazan a Font Awesome)
├── templates/
│   ├── header.php         <head>, SEO y cabecera
│   └── footer.php         Pie de página
├── assets/
│   ├── css/styles.css
│   └── js/main.js
└── img/                   Mismas rutas que antes (Logo.png, exterior/, cabana1/, cabana2/)
```

## Instalación

1. Sube todo al hosting junto con tu carpeta `img/` actual (no cambia ninguna ruta).
2. Borra los archivos antiguos `index.html`, `styles.css` y `script.js`
   (el `.htaccess` redirige `index.html` a la página nueva por si alguien lo tenía guardado).
3. Verifica que el hosting use PHP 8.1 o superior.

Para probar en tu computador: `php -S localhost:8000` dentro de la carpeta y abre http://localhost:8000.

## Editar contenido

Todo está en `includes/config.php`:

- **Agregar una foto:** copia la imagen a `img/...` y añade una línea en `gallery`.
- **Nueva categoría de fotos:** agrégala en `gallery_categories`; el botón aparece solo.
- **Cambiar teléfono, correo o Instagram:** sección `contact`.

## Seguridad

- Toda salida pasa por `e()` (`htmlspecialchars`), lo que previene XSS.
- Las URLs externas (mapa, Airbnb, WhatsApp) se validan antes de imprimirse.
- Cabeceras: Content-Security-Policy, HSTS, X-Frame-Options, nosniff, Referrer-Policy y Permissions-Policy.
- `includes/` y `templates/` no son accesibles desde el navegador.
- Errores de PHP van al log del servidor, nunca a la pantalla.

### Activar la CSP (importante)

La política CSP viene en **modo solo-reporte** (`csp_report_only => true`), para no romper el
widget de Airbnb si este carga algo desde un dominio no previsto. Con el sitio publicado:

1. Abre la página, presiona F12 y revisa la pestaña **Consola**.
2. Si no aparecen avisos de "Content Security Policy", cambia a `false` en `config.php`.
3. Si aparecen, agrega el dominio indicado a la directiva correspondiente en `helpers.php`.

## Mejoras respecto a la versión anterior

- Corregido: al filtrar la galería, el visor abría la foto equivocada.
- El script de Airbnb se cargaba dos veces; ahora una.
- Visor con `<dialog>`: teclado, Escape, foco y lector de pantalla funcionan bien; además permite deslizar con el dedo.
- Imágenes con carga diferida (`loading="lazy"`) y CSS/JS con versión automática para la caché.
- SEO: meta descripción, Open Graph (vista previa en WhatsApp) y datos estructurados de schema.org.
- Año del pie de página automático.
