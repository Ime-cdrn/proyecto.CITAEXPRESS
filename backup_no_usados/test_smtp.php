<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

require 'config_email.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2; // 👈 nivel de debug (0 = off, 2 = verbose)
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USERNAME;
    $mail->Password   = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
    $mail->Port       = SMTP_PORT; // 587
    $mail->CharSet    = 'UTF-8';

    // 🔒 Validación SSL con cacert.pem
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => true,
            'verify_peer_name'  => true,
            'allow_self_signed' => false,
            'cafile'            => 'C:/xamp/php/extras/ssl/cacert.pem' // 👈 ruta correcta en tu PC
        ]
    ];

    $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
    $mail->addAddress(SMTP_USERNAME, 'Prueba');

    $mail->isHTML(true);
    $mail->Subject = 'Prueba SMTP directa';
    $mail->Body    = 'Si recibes este correo, la conexión SMTP funciona ✅';

    $mail->send();
    echo "✅ Email enviado correctamente";
} catch (Exception $e) {
    echo "❌ Error detallado: " . $mail->ErrorInfo;
}
