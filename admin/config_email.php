<?php
// Archivo central de configuración de email (admin/config_email.php)

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'aracelyapaza171@gmail.com');
define('SMTP_PASSWORD', 'uxuskamgbbyuzcww');
define('SMTP_FROM_EMAIL', 'aracelyapaza171@gmail.com');
define('SMTP_FROM_NAME', 'Sistema de Reservas');

// Cargar motor de envío
require_once __DIR__ . '/mailer.php';
?>