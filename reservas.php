<?php 
include "header.php";
include "navbar.php";
?>

<!-- Floating Elements for Dynamic Background -->
<div class="floating-elements">
  <div class="floating-circle"></div>
  <div class="floating-circle"></div>
  <div class="floating-circle"></div>
  <div class="floating-circle"></div>
</div>

<div class="container py-5">
  <div class="hero-section text-center fade-in-up">
    <h1 class="display-4 fw-bold"><i class="bi bi-calendar-plus me-2"></i> Sistema de Reservas</h1>
    <p class="lead">Agenda tu cita de manera rápida </p>
  </div>
  
  <div class="row">
    <div class="col-lg-4 mb-4 slide-in-right">
      <div class="card h-100 card-hover">
        <div class="card-body text-center">
          <div class="feature-icon float-animation">
            <i class="bi bi-calendar-plus"></i>
          </div>
          <h3 class="card-title">CITA EXPRESS </h3>
          <h6 class="text-muted mb-3">Información de la Empresa</h6>
          <img src="img/WhatsApp Image 2025-09-24 at 22.02.36.jpeg" class="img-fluid rounded mb-3 shadow-sm" alt="Logo de la empresa" style="max-height: 120px;">
          <p class="card-text mb-4"><span class="badge bg-info">Gestión Eficiente</span></p>
          
          <h5 class="mt-4 mb-3" style="color: var(--primary-color);">Accesos Rápidos</h5>
          <div class="d-grid gap-2">
            <a href="mediosContacto.php" class="btn btn-outline-primary">
              <i class="bi bi-telephone me-2"></i> Contacto
            </a>
            <a href="https://www.facebook.com/share/164tENatrZ/" class="btn btn-outline-primary" target="_blank">
              <i class="bi bi-info-circle me-2"></i> Información
            </a>
            
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8 fade-in-up">
      <div class="alert alert-info mb-4">
        <h4 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Información del Sistema</h4>
        <p class="mb-2">Utiliza nuestro sistema profesional de reservas para agendar tu cita de manera rápida y eficiente. Recibirás una confirmación inmediata por correo electrónico.</p>
        <p class="mb-0"><strong>Proceso simplificado y seguro para tu comodidad.</strong></p>
      </div>
      
      <?php 
        include "modal_reserva.php";
      ?>

      <div class="alert alert-warning mt-4">
        <h4 class="alert-heading"><i class="bi bi-headset me-2"></i>Soporte y Asistencia</h4>
        <p class="mb-0">¿Necesitas ayuda con tu reserva? ¿Tienes dudas sobre el proceso? Nuestro equipo de soporte está disponible para asistirte.</p>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php";?>