<?php
// admin/enviar_notificacion.php
header('Content-Type: application/json; charset=UTF-8');

function json_response($success, $message, $extra = []) {
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message,
    ], $extra));
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        json_response(false, 'Método no permitido');
    }

    $id_reserva   = (int)($_POST['id_reserva'] ?? 0);
    $nuevo_estado = trim($_POST['nuevo_estado'] ?? '');

    if ($id_reserva <= 0) json_response(false, 'ID inválido');
    if (!in_array($nuevo_estado, ['Confirmado', 'Cancelado'], true)) {
        json_response(false, 'Estado inválido');
    }

    // Conexión BD
    require_once __DIR__ . '/model/conexion.php';

    $stmt = $db->prepare('SELECT * FROM reservas WHERE ID = :id LIMIT 1');
    $stmt->execute([':id' => $id_reserva]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) json_response(false, 'Reserva no encontrada');

    // Actualizar estado
    $stmtUp = $db->prepare('UPDATE reservas SET Estado = :estado WHERE ID = :id');
    $stmtUp->execute([':estado' => $nuevo_estado, ':id' => $id_reserva]);

    // Datos del correo
    $to      = $reserva['Correo'];
    $nombre  = trim(($reserva['Nombre'] ?? '') . ' ' . ($reserva['Apellidos'] ?? ''));
    $servicio= $reserva['Servicio'] ?? '';
    $fecha   = $reserva['Fecha'] ?? '';
    $hora    = $reserva['Hora'] ?? '';

    $asunto = ($nuevo_estado === 'Confirmado') ? 'Confirmación de reserva' : 'Cancelación de reserva';
    $estado_texto = strtoupper($nuevo_estado);

    $mensaje_html = "
    <h2>$asunto</h2>
    <p>Hola <strong>$nombre</strong>,</p>
    <p>Tu reserva fue <b>$estado_texto</b>.</p>
    <ul>
      <li>Servicio: $servicio</li>
      <li>Fecha: $fecha</li>
      <li>Hora: $hora</li>
    </ul>
    <p>Saludos,<br>Sistema de Reservas</p>";

    // Enviar email
    require_once __DIR__ . '/config_email.php';
    $email_enviado = false;
    if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $email_enviado = sendMail($to, $asunto, $mensaje_html, $nombre);
    }

    json_response(true, 'Estado actualizado', [
        'email_enviado' => (bool)$email_enviado,
        'nuevo_estado' => $nuevo_estado,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    json_response(false, 'Error del servidor: ' . $e->getMessage());
}
