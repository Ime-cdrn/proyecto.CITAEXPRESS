<form action="metodos/insert.php" method="post" class="glassmorphism-form light mx-auto my-5 p-4" id="reservationForm">

  <h2 class="mb-4 text-center fw-bold">Reserva tu Servicio</h2>

  <p class="fw-semibold text-center mb-4">Los datos con <span class="fs-5 text-danger">*</span> son obligatorios.</p>

  <!-- Nombre -->
  <div class="mb-3">
    <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
    <div class="input-group">
      <span class="input-group-text bg-primary text-white"><i class="bi bi-person-fill"></i></span>
      <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Escribe tus nombres" required>
    </div>
    <div class="form-text">Si tienes dos nombres, colócalos aquí.</div>
  </div>

  <!-- Apellidos -->
  <div class="mb-3">
    <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
    <div class="input-group">
      <span class="input-group-text bg-primary text-white"><i class="bi bi-person-badge-fill"></i></span>
      <input type="text" class="form-control form-control-lg" id="apellidos" name="apellidos" placeholder="Escribe tus apellidos" required>
    </div>
    <div class="form-text" style="color: rgba(255, 255, 255, 0.6);">Coloca tus apellidos completos.</div>
  </div>

  <!-- Correo -->
  <div class="mb-3">
    <label for="correo" class="form-label fw-semibold">Correo <span class="text-danger">*</span></label>
    <div class="input-group">
      <span class="input-group-text bg-primary text-white"><i class="bi bi-envelope-fill"></i></span>
      <input type="email" class="form-control form-control-lg" id="correo" name="correo" placeholder="correo@gmail.com" required>
    </div>
  </div>

  <!-- Servicio -->
  <div class="mb-3">
    <label for="servicio" class="form-label fw-semibold">Selecciona un servicio <span class="text-danger">*</span></label>
    <select class="form-select form-select-lg" id="servicio" name="servicio" required>
      <option value="" selected>Elige...</option>
      <option value="Entrega de documentos">Entrega de documentos</option>
      <option value="Audiencia">Audiencia</option>
      <option value="Sellado de oficios">Sellado de oficios</option>
    </select>
  </div>

  <!-- Fecha -->
  <div class="mb-3">
    <label for="fecha" class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
    <input type="date" class="form-control form-control-lg" id="fecha" name="fecha" required>
    <div id="mensaje-error" class="form-text" style="color: #ff6b6b;"></div>
  </div>

  <!-- Hora -->
  <div class="mb-3">
    <label for="hora" class="form-label fw-semibold">Hora <span class="text-danger">*</span></label>
    <select class="form-select form-select-lg" id="hora" name="hora" required>
      <option value="" selected>Elige la hora</option>
      <option value="09:00">09:00 AM</option>
      <option value="10:00">10:00 AM</option>
      <option value="11:00">11:00 AM</option>
      <option value="14:00">02:00 PM</option>
      <option value="15:00">03:00 PM</option>
      <option value="16:00">04:00 PM</option>
    </select>
  </div>

  <!-- Mensaje adicional -->
  <div class="mb-4">
    <label for="mensaje" class="form-label fw-semibold">Mensaje adicional</label>
    <textarea class="form-control" id="mensaje" name="mensaje" rows="3" placeholder="Escribe algún comentario adicional (opcional)"></textarea>
  </div>

  <input type="hidden" name="estado" value="Pendiente">
  <input type="hidden" name="oculto" value="1">

  <div class="d-flex gap-3 justify-content-center">
    <button type="reset" class="btn btn-outline-warning btn-lg flex-fill">Limpiar</button>
    <button type="submit" class="btn btn-primary btn-lg flex-fill">Enviar</button>
  </div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
  function esFechaValida(fecha) {
    return fecha instanceof Date && !isNaN(fecha);
  }

  function validarFecha() {
    var fechaInput = document.getElementById("fecha");
    var partesFecha = fechaInput.value.split('-');
    var fechaSeleccionada = new Date(Date.UTC(partesFecha[0], partesFecha[1] - 1, partesFecha[2]));
    var mensajeError = document.getElementById("mensaje-error");

    if (!esFechaValida(fechaSeleccionada)) {
      mensajeError.textContent = "Por favor, introduce una fecha válida.";
      fechaInput.value = "";
      return;
    }

    var diaSemana = fechaSeleccionada.getUTCDay();

    if (diaSemana < 1 || diaSemana > 5) {
      fechaInput.value = "";
      mensajeError.textContent = "Este día no se cuenta con servicio, selecciona uno distinto.";
    } else {
      mensajeError.textContent = "";
    }
  }

  document.getElementById("fecha").addEventListener("change", validarFecha);
});
</script>

<!-- Bootstrap 5 JS Bundle (Popper + Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
