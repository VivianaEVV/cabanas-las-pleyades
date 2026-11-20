<?php

declare(strict_types=1);

// Nunca mostrar errores al visitante en producción; registrarlos en el log del servidor.
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/helpers.php';
require __DIR__ . '/icons.php';

/** @var array<string, mixed> $config */
$config = require __DIR__ . '/config.php';

send_security_headers((bool) $config['security']['csp_report_only']);
header('Content-Type: text/html; charset=UTF-8');

return $config;
