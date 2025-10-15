<?php
session_start();

// FORZAR LOGOUT - Destruir cualquier sesión existente
session_destroy();
session_start();

include 'includes/db_connection.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $conn->real_escape_string($_POST['correo']);
    $password_plana = $_POST['password'];

    $sql = "SELECT id, password FROM clientes WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id_cliente, $password_hasheada);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password_plana, $password_hasheada)) {
        $_SESSION['id_cliente'] = $id_cliente;
        header("Location: /citas/reservas.php");
        exit();
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
    }
    $stmt->close();
}

$conn->close();
?>