<?php
// Cargar configuración de email
require_once __DIR__ . '/config_email.php';

// Cargar la función sendMail
require_once __DIR__ . '/mailer.php';

// Enviar correo de prueba
$resultado = sendMail(
    'aracelyapaza171@gmail.com', // Cambia por tu email
    'Prueba desde localhost',
    '<h1>¡Funciona!</h1><p>Este correo se envió desde <strong>XAMPP</strong>.</p>',
    'Tu Nombre'
);

// Mostrar resultado
if ($resultado) {
    echo "✅ Correo enviado correctamente";
} else {
    echo "❌ Error al enviar el correo";
}
?>