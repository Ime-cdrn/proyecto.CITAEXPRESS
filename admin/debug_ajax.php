<?php
// Script de depuración para verificar que AJAX funciona
header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'message' => 'Conexión AJAX funcionando correctamente',
    'timestamp' => date('Y-m-d H:i:s'),
    'server_info' => [
        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
        'POST_data' => $_POST,
        'file_exists' => file_exists('enviar_notificacion.php')
    ]
]);
?>
