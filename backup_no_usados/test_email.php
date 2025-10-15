<?php
// Script de prueba para verificar envío de emails
include_once 'config_email.php'; // Esto carga también mailer.php

echo "<h2>🔧 Prueba de Configuración de Email</h2>";

// Verificar configuración
echo "<h3>📋 Verificando configuración:</h3>";
echo "SMTP Host: " . SMTP_HOST . "<br>";
echo "SMTP Port: " . SMTP_PORT . "<br>";
echo "SMTP Username: " . SMTP_USERNAME . "<br>";
echo "SMTP From Email: " . SMTP_FROM_EMAIL . "<br>";

if (SMTP_USERNAME == 'tu-email@gmail.com') {
    echo "❌ ERROR: Cambia tu-email@gmail.com en config_email.php<br>";
    exit;
}

if (SMTP_PASSWORD == 'tu-app-password') {
    echo "❌ ERROR: Cambia tu contraseña de aplicación en config_email.php<br>";
    exit;
}

echo "✅ Configuración básica completada<br>";

// Probar envío de email
$email_prueba   = SMTP_USERNAME; // te lo envías a ti mismo
$asunto_prueba  = "✅ Prueba - Sistema de Reservas";
$mensaje_prueba = "
<html>
<head><meta charset='UTF-8'></head>
<body>
    <h2>🎉 ¡Prueba Exitosa!</h2>
    <p>Si recibes este email, la configuración SMTP está funcionando correctamente.</p>
    <p><b>Fecha:</b> " . date('d/m/Y H:i:s') . "</p>
</body>
</html>";

echo "Enviando email de prueba a: <strong>" . $email_prueba . "</strong><br>";

try {
    // 🔑 usamos nuestra función real
    $resultado = sendMail($email_prueba, $asunto_prueba, $mensaje_prueba, 'Usuario de Prueba');
    
    if ($resultado) {
        echo "✅ ¡EMAIL ENVIADO CORRECTAMENTE!<br>Revisa tu bandeja de entrada/spam.";
    } else {
        echo "❌ ERROR: No se pudo enviar el email. Revisa la contraseña de aplicación o el firewall.";
    }
} catch (Exception $e) {
    echo "❌ EXCEPCIÓN: " . $e->getMessage();
}
?>