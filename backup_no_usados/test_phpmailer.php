<?php
require_once 'config_email.php';
require_once 'mailer.php';

echo "Probando envío con PHPMailer y cacert.pem nuevo...<br>";

$resultado = sendMail('aracelyapaza171@gmail.com', 'Prueba PHPMailer', '<h1>Email de prueba con PHPMailer</h1>');

if ($resultado) {
    echo "Email enviado correctamente con PHPMailer";
} else {
    echo "Error al enviar con PHPMailer";
}
?>