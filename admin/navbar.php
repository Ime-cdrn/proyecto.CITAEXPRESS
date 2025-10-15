<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .admin-navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .navbar-brand:hover {
            color: #ffd700 !important;
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 0.3rem;
            padding: 0.6rem 1rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            backdrop-filter: blur(15px);
        }
        
        .welcome-text {
            color: #ffd700 !important;
            font-weight: 600;
            background: rgba(255, 215, 0, 0.1);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border: none;
            border-radius: 25px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            color: white;
            margin-left: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
            background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
            color: white;
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .navbar-nav {
                padding-top: 1rem;
                background: rgba(0, 0, 0, 0.1);
                border-radius: 15px;
                margin-top: 1rem;
                padding: 1rem;
            }
            
            .nav-link {
                margin: 0.2rem 0;
            }
            
            .btn-logout {
                margin: 0.5rem 0;
                width: 100%;
            }
            
            .welcome-text {
                margin: 0.3rem 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container">
            <a class="navbar-brand" href="./inicio.php">
                <i class="bi bi-speedometer2 me-2"></i>
                Tablero Administrativo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="./inicio.php">
                            <i class="bi bi-house-door me-1"></i>
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mod_reservas.php">
                            <i class="bi bi-calendar-check me-1"></i>
                            Reservas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendario.php">
                            <i class="bi bi-calendar3 me-1"></i>
                            Calendario
                        </a>
                    </li>
                    
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="smtp_settings.php">
                            <i class="bi bi-gear me-1"></i>
                            SMTP
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="soporte.php">
                            <i class="bi bi-headset me-1"></i>
                            Soporte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cambiarPassword.php">
                            <i class="bi bi-key me-1"></i>
                            Cambiar Contraseña
                        </a>
                </ul>
                
                <div class="navbar-nav">
                    <span class="welcome-text">
                        <i class="bi bi-person-circle me-1"></i>
                        Bienvenido, <?php echo $nombreUsuario; ?>
                    </span>
                    <a class="btn btn-logout" href="metodos/cerrar_sesion.php">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido de ejemplo -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>