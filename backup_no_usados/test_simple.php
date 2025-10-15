<?php
require_once 'config_email.php';
require_once 'mailer.php';

echo "Probando envío con mail() nativa...<br>";

$resultado = sendMail('aracelyapaza171@gmail.com', 'Prueba Simple', '<h1>Email de prueba</h1>');

if ($resultado) {
    echo "Proceso completado";
} else {
    echo "Proceso falló";
}
?>
