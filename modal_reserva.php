<!-- Professional Reservation Button -->
<div class="d-flex justify-content-center my-4">
  <div 
    class="reservation-card card-hover shadow border-0 text-center" 
    style="cursor: pointer; max-width: 450px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: var(--border-radius-xl);"
    data-bs-toggle="modal" 
    data-bs-target="#modalReserva"
    role="button"
    tabindex="0"
    onkeypress="if(event.key === 'Enter' || event.key === ' ') this.click();"
  >
    <div class="card-body py-5 px-4 text-white position-relative">
      <div class="reservation-icon mb-4">
        <i class="bi bi-calendar-plus display-3 float-animation"></i>
      </div>
      <h3 class="card-title fw-bold mb-3" style="font-size: 1.75rem;">Agendar Nueva Cita</h3>
      <p class="card-text fs-6 mb-4 opacity-90">Sistema profesional de reservas - Proceso rápido y seguro</p>
      <div class="btn btn-light btn-lg px-4 py-3 shadow-sm" style="font-weight: 600; border-radius: var(--border-radius);">
        <i class="bi bi-calendar-check me-2"></i> Iniciar Reserva
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <h5 class="modal-title text-white" id="modalReservaLabel">
          <i class="bi bi-calendar-plus me-2"></i>Formulario de Reservación
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <?php
          include_once __DIR__ . "/includes/auth.php";
          if (function_exists('estaLogueado') && estaLogueado()) {
              include "metodos/form_insert.php";
          } else {
        ?>
          <div class="text-center py-4">
            <div class="alert alert-info mb-4">
              <i class="bi bi-info-circle me-2"></i>
              Antes de reservar, por favor inicia sesión o crea una cuenta.
            </div>
            <div class="d-flex justify-content-center gap-3">
              <a href="clientes/login.php" class="btn btn-primary"><i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión</a>
              <a href="clientes/register.php" class="btn btn-outline-primary"><i class="bi bi-person-plus me-2"></i>Registrarse</a>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <p class="text-center text-info mb-0 w-100">
          <i class="bi bi-exclamation-circle"></i> 
          <b>Recuerda que una vez enviado el formulario tu información será procesada y no podrás modificarla.</b>
        </p>
      </div>
    </div>
  </div>
</div>