<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/config_email.php';

$settingsPath = __DIR__ . '/email_settings.json';
$message = '';
$type = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize basic inputs
    $SMTP_HOST = trim($_POST['SMTP_HOST'] ?? '');
    $SMTP_PORT = (int)($_POST['SMTP_PORT'] ?? 587);
    $SMTP_USERNAME = trim($_POST['SMTP_USERNAME'] ?? '');
    $SMTP_PASSWORD = trim($_POST['SMTP_PASSWORD'] ?? '');
    $SMTP_FROM_EMAIL = trim($_POST['SMTP_FROM_EMAIL'] ?? '');
    $SMTP_FROM_NAME = trim($_POST['SMTP_FROM_NAME'] ?? '');

    $data = [
        'SMTP_HOST' => $SMTP_HOST ?: 'smtp.gmail.com',
        'SMTP_PORT' => $SMTP_PORT ?: 587,
        'SMTP_USERNAME' => $SMTP_USERNAME,
        'SMTP_PASSWORD' => $SMTP_PASSWORD,
        'SMTP_FROM_EMAIL' => $SMTP_FROM_EMAIL,
        'SMTP_FROM_NAME' => $SMTP_FROM_NAME ?: 'Sistema de Reservas'
    ];

    // Crear directorio si no existe
    $dir = dirname($settingsPath);
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }

    $written = @file_put_contents($settingsPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    if ($written !== false) {
        $message = 'Configuración SMTP guardada correctamente.';
        $type = 'success';
        
        // Opcional: Actualizar config_email.php con nuevos valores
        updateConfigFile($data);
    } else {
        $message = 'No se pudo guardar el archivo de configuración. Verifica permisos de escritura en la carpeta admin/.';
        $type = 'danger';
    }
}

// Cargar valores actuales (de constantes ya definidas por config_email.php)
$current = [
    'SMTP_HOST' => defined('SMTP_HOST') ? SMTP_HOST : 'smtp.gmail.com',
    'SMTP_PORT' => defined('SMTP_PORT') ? SMTP_PORT : 587,
    'SMTP_USERNAME' => defined('SMTP_USERNAME') ? SMTP_USERNAME : '',
    'SMTP_PASSWORD' => '', // por seguridad, no mostramos el valor actual
    'SMTP_FROM_EMAIL' => defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : '',
    'SMTP_FROM_NAME' => defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'Sistema de Reservas'
];

function updateConfigFile($data) {
    $configPath = __DIR__ . '/config_email.php';
    
    $configContent = '<?php
// Archivo central de configuración de email (admin/config_email.php)

define(\'SMTP_HOST\', \'' . addslashes($data['SMTP_HOST']) . '\');
define(\'SMTP_PORT\', ' . (int)$data['SMTP_PORT'] . ');
define(\'SMTP_USERNAME\', \'' . addslashes($data['SMTP_USERNAME']) . '\');
define(\'SMTP_PASSWORD\', \'' . addslashes($data['SMTP_PASSWORD']) . '\');
define(\'SMTP_FROM_EMAIL\', \'' . addslashes($data['SMTP_FROM_EMAIL']) . '\');
define(\'SMTP_FROM_NAME\', \'' . addslashes($data['SMTP_FROM_NAME']) . '\');

// Cargar motor de envío
require_once __DIR__ . \'/mailer.php\';
?>';

    @file_put_contents($configPath, $configContent);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración SMTP - Sistema de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card-hover {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .form-control {
            border-radius: 15px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
            background: rgba(248, 249, 250, 0.8);
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 15px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            transform: translateY(-2px);
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            backdrop-filter: blur(20px);
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.15);
            color: #4a1d5cff;
            border: 1px solid rgba(167, 40, 161, 0.3);
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.15);
            color: #721c24;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .container {
            max-width: 1000px;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="hero-section">
            <h1 class="mb-2">
                <i class="bi bi-gear me-2"></i>
                Configuración SMTP
            </h1>
            <p class="lead mb-0">Actualiza los datos de correo para notificaciones del sistema</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($type); ?> alert-dismissible fade show" role="alert">
                <i class="bi bi-<?php echo $type === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card card-hover">
            <div class="card-body p-4">
                <form method="post" class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-server me-1"></i>
                            Servidor SMTP
                        </label>
                        <input type="text" class="form-control" name="SMTP_HOST" 
                               value="<?php echo htmlspecialchars($current['SMTP_HOST']); ?>" 
                               placeholder="smtp.gmail.com" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-ethernet me-1"></i>
                            Puerto
                        </label>
                        <input type="number" class="form-control" name="SMTP_PORT" 
                               value="<?php echo (int)$current['SMTP_PORT']; ?>" 
                               placeholder="587" min="1" max="65535" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person me-1"></i>
                            Usuario / Email
                        </label>
                        <input type="email" class="form-control" name="SMTP_USERNAME" 
                               value="<?php echo htmlspecialchars($current['SMTP_USERNAME']); ?>" 
                               placeholder="usuario@gmail.com" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-key me-1"></i>
                            Contraseña (App Password)
                        </label>
                        <input type="password" class="form-control" name="SMTP_PASSWORD" 
                               placeholder="••••••••••••••••">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Usa una contraseña de aplicación de Gmail (no la contraseña normal)
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-envelope me-1"></i>
                            Email Remitente
                        </label>
                        <input type="email" class="form-control" name="SMTP_FROM_EMAIL" 
                               value="<?php echo htmlspecialchars($current['SMTP_FROM_EMAIL']); ?>" 
                               placeholder="sistema@empresa.com" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-tag me-1"></i>
                            Nombre Remitente
                        </label>
                        <input type="text" class="form-control" name="SMTP_FROM_NAME" 
                               value="<?php echo htmlspecialchars($current['SMTP_FROM_NAME']); ?>" 
                               placeholder="Sistema de Reservas" required>
                    </div>
                    
                    <div class="col-12">
                        <hr class="my-4">
                        <div class="d-flex gap-3 justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save me-2"></i>
                                    Guardar Configuración
                                </button>
                            </div>
                            <div>
                                </a>
                                <a href="inicio.php" class="btn btn-outline-primary ms-2">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Volver al Panel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6 class="mb-2">
                        <i class="bi bi-lightbulb me-2"></i>
                        Instrucciones para Gmail:
                    </h6>
                    <ol class="mb-0">
                        <li>Ve a tu cuenta de Google → Seguridad</li>
                        <li>Activa la verificación en 2 pasos</li>
                        <li>Genera una "contraseña de aplicación" específica</li>
                        <li>Usa esa contraseña de 16 caracteres aquí (no tu contraseña normal)</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let hasErrors = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    hasErrors = true;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                alert('Por favor, completa todos los campos requeridos.');
            }
        });
    </script>
</body>
</html>