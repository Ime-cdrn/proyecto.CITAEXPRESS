<?php
// Archivo de autenticación global
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function verificarAutenticacion() {
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['id_cliente'])) {
        // Si no está logueado, redirigir a la página de bienvenida
        header("Location: includes/welcome.php");
        exit();
    }
}

function obtenerDatosUsuario() {
    if (isset($_SESSION['id_cliente'])) {
        include_once 'db_connection.php';
        
        $id_cliente = $_SESSION['id_cliente'];
        $sql = "SELECT id, nombre, correo FROM clientes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        $stmt->close();
        $conn->close();
    }
    return null;
}

function estaLogueado() {
    return isset($_SESSION['id_cliente']);
}
?>
