<?php
// Renombrar el archivo original para forzar que index.php sea el principal
session_start();
include 'includes/db_connection.php';

// Si ya está logueado, redirigir a reservas
if (isset($_SESSION['id_cliente'])) {
    header("Location: /citas/reservas.php");
    exit();
}

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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reservas - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/modern-style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(236, 240, 241, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(189, 195, 199, 0.3);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header i {
            font-size: 3rem;
            color: #3498db;
            margin-bottom: 1rem;
        }
        .login-header h2 {
            color: #2c3e50;
            font-weight: 700;
        }
        .login-header p {
            color: #7f8c8d;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #bdc3c7;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: rgba(248, 249, 250, 0.9);
            color: #2c3e50;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
            background: rgba(255, 255, 255, 1);
        }
        .form-label {
            color: #2c3e50;
            font-weight: 600;
        }
        .btn-login {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.4);
        }
        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid #e74c3c;
            color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="bi bi-calendar-check"></i>
            <h2 class="fw-bold">¡Bienvenido!</h2>
            <p class="text-muted">Sistema de Reservas Profesional</p>
            <p class="text-info">Inicia sesión con tu Gmail y contraseña</p>
        </div>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="mb-3">
                <label for="correo" class="form-label">
                    <i class="bi bi-envelope me-2"></i>Gmail / Correo Electrónico
                </label>
                <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@gmail.com" required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-2"></i>Contraseña
                </label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
            </button>
        </form>
        
        <div class="text-center mt-4">
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>¿Primera vez aquí?</strong><br>
                ¡Regístrate gratis y comienza a gestionar tus reservas!
            </div>
            <a href="clientes/register.php" class="btn btn-outline-primary w-100">
                <i class="bi bi-person-plus me-2"></i>Crear Cuenta Nueva
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
