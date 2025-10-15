<?php
// Script de diagnóstico para conexión SMTP con Gmail
include_once 'config_email.php';

// Función para mostrar mensaje con estilo
function mostrarMensaje($tipo, $titulo, $mensaje) {
    $color = ($tipo == 'error') ? 'red' : (($tipo == 'warning') ? 'orange' : 'green');
    $icono = ($tipo == 'error') ? '❌' : (($tipo == 'warning') ? '⚠️' : '✅');
    $bg_color = ($tipo == 'error') ? '#ffe6e6' : (($tipo == 'warning') ? '#fff3cd' : '#e6ffe6');
    
    echo "<div style='color: $color; background: $bg_color; padding: 15px; margin: 15px 0; border-radius: 5px;'>";
    echo "<strong>$icono $titulo</strong><br>";
    echo $mensaje;
    echo "</div>";
}

// Estilos CSS
echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Diagnóstico SMTP Gmail</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2, h3 { color: #333; }
        .container { max-width: 800px; margin: 0 auto; }
        .step { background: #f8f9fa; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .code { background: #f1f1f1; padding: 10px; border-radius: 3px; font-family: monospace; }
        .btn { display: inline-block; background: #007bff; color: white; padding: 10px 15px; 
               text-decoration: none; border-radius: 5px; margin-top: 10px; }
        .btn:hover { background: #0069d9; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔍 Diagnóstico de Conexión SMTP con Gmail</h1>";

// Verificar configuración
echo "<div class='step'>";
echo "<h2>📋 Paso 1: Verificando configuración</h2>";

// Verificar valores de configuración
if (SMTP_USERNAME == 'tu-email@gmail.com' || SMTP_USERNAME == 'tu_correo@gmail.com') {
    mostrarMensaje('error', 'CONFIGURACIÓN INCOMPLETA', 
        "Debes configurar tu email real en config_email.php<br>
        Cambia 'tu-email@gmail.com' por tu Gmail real");
    exit;
}

if (SMTP_PASSWORD == 'tu-app-password' || SMTP_PASSWORD == 'tu_contraseña_de_app') {
    mostrarMensaje('error', 'CONFIGURACIÓN INCOMPLETA', 
        "Debes configurar tu contraseña de aplicación en config_email.php<br>
        Cambia 'tu-app-password' por tu contraseña de aplicación de Gmail");
    exit;
}

echo "SMTP Host: " . SMTP_HOST . "<br>";
echo "SMTP Port: " . SMTP_PORT . "<br>";
echo "SMTP Username: " . SMTP_USERNAME . "<br>";
echo "SMTP From Email: " . SMTP_FROM_EMAIL . "<br>";

mostrarMensaje('success', 'CONFIGURACIÓN BÁSICA CORRECTA', 
    "Los valores de configuración están definidos correctamente.");
echo "</div>";

// Probar conexión SMTP
echo "<div class='step'>";
echo "<h2>🔌 Paso 2: Probando conexión SMTP</h2>";
echo "Intentando conectar a " . SMTP_HOST . " en puerto " . SMTP_PORT . "...<br>";

$resultado = probarConexionSMTP();

if ($resultado['exito']) {
    mostrarMensaje('success', 'CONEXIÓN EXITOSA', 
        "Se estableció conexión con el servidor SMTP de Gmail correctamente.<br>
        Esto significa que tus credenciales son válidas y el servidor está accesible.");
} else {
    mostrarMensaje('error', 'ERROR DE CONEXIÓN', 
        "No se pudo conectar al servidor SMTP de Gmail.<br>
        Error: " . ($resultado['error'] ?? 'Desconocido') . "<br><br>
        <strong>Posibles causas:</strong><br>
        • Contraseña de aplicación incorrecta o expirada<br>
        • Verificación en 2 pasos no activada<br>
        • Restricciones de seguridad en tu cuenta de Gmail<br>
        • Firewall o antivirus bloqueando la conexión<br>
        • Problemas de red");
}
echo "</div>";

// Probar envío de email
echo "<div class='step'>";
echo "<h2>📧 Paso 3: Probando envío de email</h2>";

if (!$resultado['exito']) {
    mostrarMensaje('warning', 'PRUEBA OMITIDA', 
        "Se omite la prueba de envío porque la conexión SMTP falló.<br>
        Primero debes resolver los problemas de conexión.");
} else {
    $email_prueba = SMTP_USERNAME; // Enviar a ti mismo para probar
    $asunto_prueba = "✅ Diagnóstico SMTP - Sistema de Reservas";
    $mensaje_prueba = "
    <!DOCTYPE html>
    <html>
    <head><meta charset='UTF-8'></head>
    <body style='font-family: Arial, sans-serif; padding: 20px;'>
        <div style='background: #f8f9fa; padding: 30px; border-radius: 10px; max-width: 600px;'>
            <h2 style='color: #007bff;'>🎉 ¡Prueba Exitosa!</h2>
            <p>Si recibes este email, la configuración SMTP está funcionando correctamente.</p>
            <p><strong>Fecha de prueba:</strong> " . date('d/m/Y H:i:s') . "</p>
            <p style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724;'>
                ✅ El sistema de notificaciones de reservas está listo para usar.
            </p>
        </div>
    </body>
    </html>";

    echo "Enviando email de prueba a: <strong>" . $email_prueba . "</strong><br>";

    try {
        $resultado = enviarEmail($email_prueba, $asunto_prueba, $mensaje_prueba, 'Usuario de Prueba');
        // Se llama a enviarEmail con el quinto parámetro a `true` para activar el modo de depuración.
        // La salida detallada de la conexión SMTP aparecerá en la caja de abajo si hay errores.
        echo "<div class='code' style='background: #333; color: #eee; padding: 15px; border-radius: 5px; max-height: 300px; overflow-y: auto; font-family: monospace; white-space: pre-wrap;'><strong>Salida de depuración de PHPMailer:</strong><br>";
        $resultado = enviarEmail($email_prueba, $asunto_prueba, $mensaje_prueba, 'Usuario de Prueba', true);
        echo "</div>";
        
        if ($resultado) {
            mostrarMensaje('success', 'EMAIL ENVIADO CORRECTAMENTE', 
                "El email de prueba se envió correctamente.<br>
                Revisa tu bandeja de entrada (y carpeta de spam) en: <strong>" . $email_prueba . "</strong><br>
                Si recibes el email, el sistema está funcionando perfectamente.");
        } else {
            mostrarMensaje('error', 'ERROR AL ENVIAR EMAIL', 
                "No se pudo enviar el email de prueba.<br>
            mostrarMensaje('error', 'ERROR AL ENVIAR EMAIL',
                "No se pudo enviar el email de prueba. Revisa la salida de depuración de arriba para ver el error exacto de PHPMailer.<br>
                <strong>Posibles causas:</strong><br>
                • Problemas con la configuración de PHPMailer<br>
                • Restricciones en tu cuenta de Gmail<br>
                • Problemas con el formato del mensaje");
                • Credenciales incorrectas (revisa el Paso 2).<br>
                • Problemas de conexión con Gmail (firewall, etc).");
        }
        
    } catch (Exception $e) {
        mostrarMensaje('error', 'EXCEPCIÓN', $e->getMessage());
        mostrarMensaje('error', 'EXCEPCIÓN INESPERADA', $e->getMessage());
    }
}
echo "</div>";

// Instrucciones para actualizar contraseña de aplicación
echo "<div class='step'>";
echo "<h2>🔑 Cómo actualizar tu contraseña de aplicación</h2>";
echo "<ol>
    <li>Ve a tu <a href='https://myaccount.google.com/security' target='_blank'>Cuenta de Google > Seguridad</a></li>
    <li>Asegúrate de que la <strong>verificación en 2 pasos</strong> esté activada</li>
    <li>Busca <strong>Contraseñas de aplicaciones</strong> (debajo de 'Iniciar sesión en Google')</li>
    <li>Selecciona <strong>Correo</strong> como aplicación y <strong>Otro</strong> como dispositivo</li>
    <li>Escribe un nombre (ej. 'Sistema de Reservas') y haz clic en <strong>Generar</strong></li>
    <li>Copia la contraseña generada (16 caracteres sin espacios)</li>
    <li>Actualiza el archivo <code>config_email.php</code> con la nueva contraseña</li>
</ol>";
echo "</div>";

// Solución de problemas comunes
echo "<div class='step'>";
echo "<h2>🛠️ Solución de problemas comunes</h2>";
echo "<ul>
    <li><strong>Error 'Access denied':</strong> La contraseña de aplicación es incorrecta o ha expirado</li>
    <li><strong>Error 'Authentication required':</strong> Debes activar la verificación en 2 pasos</li>
    <li><strong>Error 'Connection refused':</strong> Posible bloqueo por firewall o antivirus</li>
    <li><strong>No llegan los correos:</strong> Revisa la carpeta de spam</li>
    <li><strong>Gmail bloquea el acceso:</strong> Verifica si has recibido alertas de seguridad en tu Gmail</li>
</ul>";
echo "</div>";

echo "<div class='step'>";
echo "<h2>📝 Próximos pasos</h2>";
echo "<p>Si todas las pruebas son exitosas:</p>
<ul>
    <li>Ve a <a href='mod_reservas.php'>Gestión de Reservas</a> e intenta cambiar el estado de una reserva</li>
    <li>Verifica que el cliente reciba el email de confirmación o cancelación</li>
</ul>
<p>Si sigues teniendo problemas:</p>
<ul>
    <li>Genera una nueva contraseña de aplicación</li>
    <li>Verifica que no haya restricciones en tu cuenta de Gmail</li>
    <li>Prueba con otra cuenta de Gmail</li>
</ul>";
echo "</div>";

echo "</div></body></html>";
?>