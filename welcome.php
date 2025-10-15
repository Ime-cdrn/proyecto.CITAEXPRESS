<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Sistema de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/modern-style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .welcome-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(187, 115, 171, 0.1);
            padding: 3rem;
            margin: 2rem auto;
            max-width: 600px;
        }
        .welcome-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .welcome-header i {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 2px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="welcome-container">
            <div class="welcome-header">
                <i class="bi bi-calendar-check"></i>
                <h1 class="fw-bold">Sistema de Reservas Profesional</h1>
                <p class="lead text-muted">Gestiona tus citas de manera eficiente y profesional</p>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="feature-card">
                        <h5><i class="bi bi-shield-check text-primary me-2"></i>Seguro</h5>
                        <p class="mb-0">Sistema protegido con autenticación avanzada</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <h5><i class="bi bi-lightning text-warning me-2"></i>Rápido</h5>
                        <p class="mb-0">Proceso de reserva simplificado y eficiente</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <h5><i class="bi bi-calendar-plus text-success me-2"></i>Organizado</h5>
                        <p class="mb-0">Gestión completa de tus citas y reservas</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <h5><i class="bi bi-headset text-info me-2"></i>Soporte</h5>
                        <p class="mb-0">Asistencia disponible cuando la necesites</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <h4 class="mb-3">¿Listo para comenzar?</h4>
                <p class="mb-4">Inicia sesión para acceder a todas las funcionalidades del sistema</p>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="clientes/login.php" class="btn-custom me-md-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                    </a>
                    <a href="clientes/register.php" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Registrarse
                    </a>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Para acceder al sistema completo, necesitas una cuenta registrada
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
