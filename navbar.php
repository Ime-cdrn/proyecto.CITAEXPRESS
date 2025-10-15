<?php
include_once "includes/auth.php";
$usuario = obtenerDatosUsuario();
?>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold text-gradient" href="reservas.php">
        <i class="bi bi-calendar-check me-2"></i>Sistema de Reservas
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="reservas.php">
            <i class="bi bi-house me-1"></i> Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="reservas.php">
            <i class="bi bi-calendar-plus me-1"></i> Reservas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://www.facebook.com/share/164tENatrZ/" target="_blank">
            <i class="bi bi-facebook me-1"></i> Fuente Web
          </a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="admin/">
            <i class="bi bi-gear me-1"></i> Administrativo
          </a>
        </li>
        <?php if ($usuario): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i> <?php echo htmlspecialchars($usuario['nombre'] ?? $usuario['correo']); ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="clientes/dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Panel de Control</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="clientes/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
          </ul>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="clientes/login.php">
            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="clientes/register.php">
            <i class="bi bi-person-plus me-1"></i> Registrarse
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>  
  </div>
</nav>