<?php
// Inicia la sesión para poder usarla en futuras páginas
session_start();
// Incluye el archivo de conexión a la base de datos
include '../includes/db_connection.php';

$mensaje = "";
// Variables para repoblar el formulario en caso de error
$nombre = $apellidos = $correo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene y normaliza los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo = strtolower(trim($_POST['correo'] ?? ''));
    $password_plana = $_POST['password'] ?? '';

    $errores = [];

    // Validaciones del lado servidor
    if (mb_strlen($nombre) < 2 || mb_strlen($nombre) > 100) {
        $errores[] = "El nombre debe tener entre 2 y 100 caracteres.";
    }
    if (mb_strlen($apellidos) < 2 || mb_strlen($apellidos) > 120) {
        $errores[] = "Los apellidos deben tener entre 2 y 120 caracteres.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }
    if (strlen($password_plana) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    }

    // Verifica si el correo ya existe
    if (empty($errores)) {
        $stmt = $conn->prepare("SELECT 1 FROM clientes WHERE correo = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errores[] = "El correo ya está en uso.";
            }
            $stmt->close();
        } else {
            $errores[] = "Error interno al preparar la validación.";
        }
    }

    if (empty($errores)) {
        // Encripta la contraseña de forma segura
        $password_hasheada = password_hash($password_plana, PASSWORD_DEFAULT);

        // Inserta el nuevo cliente usando consulta preparada
        $sql = "INSERT INTO clientes (nombre, apellidos, correo, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $nombre, $apellidos, $correo, $password_hasheada);

            if ($stmt->execute()) {
                // Usamos la palabra 'exitoso' para activar el bloque de éxito del HTML
                $mensaje = "exitoso";
                // Limpia campos tras éxito
                $nombre = $apellidos = $correo = "";
            } else {
                if ($conn->errno == 1062) { // Duplicate entry (por si existe índice único en correo)
                    $mensaje = "El correo ya está en uso.";
                } else {
                    $mensaje = "Error al registrar. Intenta más tarde.";
                }
            }
            $stmt->close();
        } else {
            $mensaje = "Error al preparar el registro.";
        }
    } else {
        // Concatena errores en un solo mensaje
        $mensaje = implode(" ", $errores);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/modern-style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background: rgba(236, 240, 241, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(189, 195, 199, 0.3);
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header i {
            font-size: 3rem;
            color: #3498db;
            margin-bottom: 1rem;
        }
        .register-header h2 {
            color: #2c3e50;
            font-weight: 700;
        }
        .register-header p {
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
        .btn-register {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.4);
        }
        .alert-success {
            background: rgba(39, 174, 96, 0.1);
            border: 1px solid #27ae60;
            color: #1e8449;
        }
        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid #e74c3c;
            color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <i class="bi bi-person-plus"></i>
            <h2 class="fw-bold">Crear Cuenta</h2>
            <p class="text-muted">Únete a nuestro sistema de reservas</p>
        </div>
        
        <?php if ($mensaje): ?>
            <?php if (strpos($mensaje, 'exitoso') !== false): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    ¡Registro exitoso! Ahora puedes <a href="login.php" class="fw-bold">iniciar sesión</a>.
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <form action="register.php" method="post" novalidate>
            <div class="mb-3">
                <label for="nombre" class="form-label">
                    <i class="bi bi-person me-2"></i>Nombre
                </label>
                <input type="text" class="form-control" id="nombre" name="nombre" required minlength="2" maxlength="100" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">
                    <i class="bi bi-person-lines-fill me-2"></i>Apellidos
                </label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required minlength="2" maxlength="120" value="<?php echo htmlspecialchars($apellidos, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">
                    <i class="bi bi-envelope me-2"></i>Correo Electrónico
                </label>
                <input type="email" class="form-control" id="correo" name="correo" required value="<?php echo htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="bi bi-lock me-2"></i>Contraseña
                </label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8" autocomplete="new-password">
                <div class="form-text">Mínimo 8 caracteres.</div>
            </div>

            <button type="submit" class="btn btn-primary btn-register w-100">
                <i class="bi bi-person-plus me-2"></i>Registrarse
            </button>
        </form>
        
        <div class="text-center mt-4">
            <p class="mb-0">¿Ya tienes una cuenta? 
                <a href="login.php" class="text-decoration-none fw-bold">Inicia sesión aquí</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
