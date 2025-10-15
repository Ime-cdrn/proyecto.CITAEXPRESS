<?php
/**
 * Archivo de configuración principal del Sistema de Citas
 * Contiene todas las configuraciones necesarias para el funcionamiento del sistema
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Contraseña vacía para XAMPP por defecto
define('DB_NAME', 'citas');
define('DB_CHARSET', 'utf8mb4');

// Configuración de la aplicación
define('APP_NAME', 'Sistema de Citas Profesional');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/citas/');

// Configuración de sesiones
define('SESSION_LIFETIME', 3600); // 1 hora en segundos
define('SESSION_NAME', 'citas_session');

// Configuración de zona horaria
date_default_timezone_set('America/Mexico_City');

// Configuración de errores (cambiar a false en producción)
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Configuración de email (para futuras notificaciones)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', ''); // Configurar cuando sea necesario
define('SMTP_PASSWORD', ''); // Configurar cuando sea necesario

// Configuración de archivos
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'pdf']);

// Rutas del sistema
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes/');
define('UPLOADS_PATH', ROOT_PATH . '/uploads/');

// Crear directorio de uploads si no existe
if (!file_exists(UPLOADS_PATH)) {
    mkdir(UPLOADS_PATH, 0755, true);
}
?>
