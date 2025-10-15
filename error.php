<?php 
include "header.php";
include "navbar.php";
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger shadow glow-animation" role="alert">
                <div class="d-flex">
                    <i class="bi bi-exclamation-triangle-fill display-4 me-3"></i>
                    <div>
                        <h4 class="alert-heading">¡Ya existe una cita programada!</h4>
                        <p>Lo sentimos, ya existe una cita programada para la misma fecha y hora. Por favor, selecciona una fecha u hora diferente.</p>
                        <hr>
                        <a href="index.php" class="btn btn-warning">
                            <i class="bi bi-arrow-left-circle me-1"></i> Regresar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php";?>