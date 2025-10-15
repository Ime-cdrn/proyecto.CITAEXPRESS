<?php 
include "header.php";
include "navbar.php";
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success shadow glow-animation" role="alert">
                <div class="d-flex">
                    <i class="bi bi-check-circle-fill display-4 me-3"></i>
                    <div>
                        <h4 class="alert-heading">¡Reservación Exitosa!</h4>
                        <p>Gracias por enviar tu formulario de reservación. Hemos recibido tu solicitud y estamos procesándola. Por favor, espera nuestra confirmación.</p>
                        <hr>
                        <p class="mb-3">Tu reserva está en proceso. ¡Gracias por elegirnos!</p>
                        <div class="d-flex align-items-center">
                            <div class="spinner-border spinner-border-sm text-success me-2" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mb-0">Redirigiendo en <span id="countdown" class="fw-bold">10</span> segundos...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/redireccionExito.js"></script>
<?php include "footer.php";?>