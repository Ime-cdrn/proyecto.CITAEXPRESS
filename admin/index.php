<?php
session_start();

// Incluye el archivo de conexión a la base de datos
require_once 'model/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta para verificar el inicio de sesión
    $query = "SELECT * FROM usuarios WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            header("Location: inicio.php");
            exit();
        } else {
            $error_message = "Contraseña incorrecta. Por favor, inténtalo de nuevo.";
        }
    } else {
        $error_message = "Nombre de usuario no encontrado. Por favor, regístrate o verifica tus credenciales.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --pastel-pink: #f8d7da;
            --pastel-lavender: #e8d5ff;
            --pastel-mint: #d1ecf1;
            --soft-purple: #b19cd9;
            --soft-rose: #f2a2a8;
            --soft-blue: #a8d8ea;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-light: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-tertiary: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --text-dark: #2d3748;
            --text-light: #718096;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #8B5CF6 0%, #A855F7 50%, #EC4899 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Elementos decorativos flotantes */
        body::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: var(--gradient-secondary);
            border-radius: 50%;
            opacity: 0.6;
            animation: float 6s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            top: 60%;
            right: 15%;
            width: 80px;
            height: 80px;
            background: var(--gradient-tertiary);
            border-radius: 50%;
            opacity: 0.5;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.3;
            animation: float 10s ease-in-out infinite;
        }

        .shape-1 {
            top: 20%;
            right: 20%;
            width: 60px;
            height: 60px;
            background: var(--pastel-lavender);
            animation-delay: -2s;
        }

        .shape-2 {
            bottom: 30%;
            left: 20%;
            width: 40px;
            height: 40px;
            background: var(--pastel-mint);
            animation-delay: -4s;
        }

        .container {
            position: relative;
            z-index: 10;
            max-width: 500px;
            padding: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow-light);
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px 0 rgba(31, 38, 135, 0.5);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }

        .card-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .card-header h2 {
            color: #1a202c;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 1px 2px rgba(255,255,255,0.3);
        }

        .card-header p {
            color: #2d3748;
            font-weight: 400;
            font-size: 1rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 15px;
            color: #1a202c;
            font-size: 1rem;
            font-weight: 500;
            height: 60px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.4);
            border-color: rgba(139, 92, 246, 0.6);
            box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.2);
            color: #1a202c;
        }

        .form-control::placeholder {
            color: #4a5568;
            font-weight: 400;
        }

        .form-floating > label {
            color: #4a5568;
            font-weight: 500;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #1a202c;
            font-weight: 600;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        .btn-container {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-modern {
            flex: 1;
            min-width: 120px;
            height: 50px;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-primary-modern {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary-modern {
            background: rgba(255, 255, 255, 0.3);
            color: #1a202c;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .btn-secondary-modern:hover {
            background: rgba(255, 255, 255, 0.4);
            color: #1a202c;
            transform: translateY(-2px);
        }

        .error-message {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 12px;
            color: #ff6b6b;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #4a5568;
            z-index: 5;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .container {
                padding: 1rem;
            }
            
            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }
            
            .card-header h2 {
                font-size: 1.75rem;
            }
            
            .btn-container {
                flex-direction: column;
            }
            
            .btn-modern {
                width: 100%;
                min-width: unset;
            }
        }

        /* Animación de carga */
        .login-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Efecto de cristal adicional */
        .glass-effect {
            position: relative;
        }

        .glass-effect::after {
            content: '';
            position: absolute;
            top: 1px;
            left: 1px;
            right: 1px;
            height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            border-radius: 24px 24px 0 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    
    <div class="container">
        <div class="login-card glass-effect">
            <div class="card-header">
                <h2><i class="bi bi-shield-lock"></i> Bienvenido</h2>
                <p>Inicia sesión en tu cuenta</p>
            </div>
            
            <form method="POST" action="">
                <div class="form-floating">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario" required>
                    <label for="username">Nombre de usuario</label>
                    <i class="bi bi-person input-icon"></i>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    <label for="password">Contraseña</label>
                    <i class="bi bi-lock input-icon"></i>
                </div>
                
                <div class="btn-container">
                    <a href="../" class="btn-modern btn-secondary-modern">
                        <i class="bi bi-arrow-left"></i>
                        Regresar
                    </a>
                    <button type="submit" class="btn-modern btn-primary-modern">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Iniciar Sesión
                    </button>
                </div>
            </form>
            
            <?php if (isset($error_message)) { ?>
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo $error_message; ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efecto de enfoque automático
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                    this.parentElement.style.transition = 'transform 0.2s ease';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
            
            // Animación del botón de submit
            const submitBtn = document.querySelector('.btn-primary-modern');
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Iniciando...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>
</html>