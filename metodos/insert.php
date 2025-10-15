<?php
#prueba de envio de datos
#print_r($_POST);

# Verificar si se ha enviado el formulario
if (!isset($_POST['oculto'])) {
    exit(); // Si no se ha enviado, salir del script.
}

// Enforce login server-side before creating a reservation
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_cliente'])) {
    header('Location: ../clientes/login.php');
    exit();
}

# Incluir el archivo de conexión a la base de datos
include '../admin/model/conexion.php';

# Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$mensaje = $_POST['mensaje'];
$estado = $_POST['estado'];

# Verificar si ya existe una cita en la misma fecha y hora
$consulta = $db->prepare("SELECT COUNT(*) FROM reservas WHERE fecha = ? AND hora = ?");
$consulta->execute([$fecha, $hora]);
$existeCita = $consulta->fetchColumn();

if ($existeCita > 0) {
    header('Location: ../error.php');
    echo 'Ya existe una cita programada para la misma fecha y hora.';
} else {
    # Insertar el nuevo registro si no hay conflicto
    $sentencia = $db->prepare("INSERT INTO reservas(nombre, apellidos, correo, servicio, fecha, hora, mensajeadicional, estado)
    VALUES(?,?,?,?,?,?,?,?)");
    
    if ($sentencia->execute([$nombre, $apellidos, $correo, $servicio, $fecha, $hora, $mensaje, $estado])) {
        // Enviar correo de confirmación al cliente
        @require_once __DIR__ . '/../admin/config_email.php';
        if (function_exists('sendMail')) {
            $subject = 'Confirmación de reserva';
            $html = '<h2>Confirmación de Reserva</h2>' .
                    '<p>Hola ' . htmlspecialchars($nombre . ' ' . $apellidos) . ',</p>' .
                    '<p>Tu reserva ha sido registrada con éxito con los siguientes datos:</p>' .
                    '<ul>' .
                    '<li><strong>Servicio:</strong> ' . htmlspecialchars($servicio) . '</li>' .
                    '<li><strong>Fecha:</strong> ' . htmlspecialchars($fecha) . '</li>' .
                    '<li><strong>Hora:</strong> ' . htmlspecialchars($hora) . '</li>' .
                    '<li><strong>Estado:</strong> ' . htmlspecialchars($estado) . '</li>' .
                    '</ul>' .
                    '<p>Mensaje adicional: ' . nl2br(htmlspecialchars($mensaje)) . '</p>' .
                    '<p>Gracias por confiar en nosotros.</p>';
            // Intentar enviar, pero no bloquear el flujo si falla
            try { sendMail($correo, $subject, $html, $nombre . ' ' . $apellidos); } catch (Throwable $e) {}
        }
        header('Location: ../exito.php'); // Redirigir si la inserción fue exitosa.
    } else {
        echo 'Error al insertar datos.';
    }
}
?>