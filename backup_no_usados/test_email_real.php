<?php
// Probar envío de email con credenciales reales
include_once 'config_email.php';

echo "<h2>📧 Probando Email con Credenciales Reales</h2>";

// Verificar configuración
echo "<h3>📋 Configuración actual:</h3>";
echo "SMTP Host: " . SMTP_HOST . "<br>";
echo "SMTP Port: " . SMTP_PORT . "<br>";
echo "SMTP Username: " . SMTP_USERNAME . "<br>";
echo "SMTP From Email: " . SMTP_FROM_EMAIL . "<br>";

// Probar envío de email
$email_destino = SMTP_USERNAME; // Enviarte a ti mismo
$asunto = "✅ Prueba Real - Sistema de Reservas";
$mensaje = "
<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'></head>
<body style='font-family: Arial, sans-serif; padding: 20px;'>
    <div style='background: #f8f9fa; padding: 30px; border-radius: 10px; max-width: 600px;'>
        <h2 style='color: #007bff;'>🎉 ¡Prueba con Gmail Real!</h2>
        <p>Si recibes este email, tu configuración de Gmail funciona correctamente.</p>
        <p><strong>Enviado desde:</strong> " . SMTP_FROM_EMAIL . "</p>
        <p><strong>Fecha:</strong> " . date('d/m/Y H:i:s') . "</p>
        <div style='background: #d4edda; padding: 15px; border-radius: 5px; color: #155724; margin: 20px 0;'>
            ✅ Las notificaciones de reservas funcionarán correctamente.
        </div>
    </div>
</body>
</html>";

echo "<h3>📤 Enviando email de prueba...</h3>";
echo "Destinatario: <strong>" . $email_destino . "</strong><br><br>";

try {
    $resultado = enviarEmailPHPMailer($email_destino, $asunto, $mensaje, 'Usuario de Prueba');
    
    if ($resultado) {
        echo "<div style='color: green; background: #e6ffe6; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "✅ <strong>¡EMAIL ENVIADO EXITOSAMENTE!</strong><br>";
        echo "Revisa tu bandeja de entrada en: <strong>" . $email_destino . "</strong><br>";
        echo "También revisa la carpeta de SPAM por si acaso.<br>";
        echo "<strong>¡Las notificaciones de reservas funcionarán!</strong>";
        echo "</div>";
    } else {
        echo "<div style='color: red; background: #ffe6e6; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "❌ <strong>ERROR AL ENVIAR EMAIL</strong><br>";
        echo "Posibles causas:<br>";
        echo "• Contraseña de aplicación incorrecta<br>";
        echo "• Verificación en 2 pasos no activada<br>";
        echo "• Gmail bloqueando la conexión<br>";
        echo "• Problema de conectividad";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "❌ <strong>EXCEPCIÓN:</strong> " . $e->getMessage();
    echo "</div>";
}

echo "<hr>";
echo "<h3>🔧 Si no funciona:</h3>";
echo "<ol>";
echo "<li>Verifica que la contraseña de aplicación sea exacta (sin espacios extra)</li>";
echo "<li>Asegúrate de que la verificación en 2 pasos esté activada</li>";
echo "<li>Intenta generar una nueva contraseña de aplicación</li>";
echo "<li>Revisa que no haya firewall bloqueando el puerto 587</li>";
echo "</ol>";
?>
