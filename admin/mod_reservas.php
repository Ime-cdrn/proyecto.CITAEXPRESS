<?php
include("header.php");
include("navbar.php");
# Conexión a DB
include 'model/conexion.php';
# Select
$sentencia = $db->query("SELECT * FROM reservas;");
$dato = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container"><!-- Comienza Container -->
    <br><br>
    <div class="row"><!-- Comienza Row -->
        <div class="container">
            <br><br>
            <div class="text-center">
                <h3>Lista de registros</h3>
                <a href="./inicio.php" class="btn btn-success"><i class="fas fa-home"></i> Regresar al inicio</a>
                <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Ingresar Nuevo Registro</a>
            </div><br>

            <table class="table table-striped" id="tablaReservas">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>APELLIDOS</th>
                        <th>EMAIL</th>
                        <th>SERVICIO</th>
                        <th>FECHA</th>
                        <th>HORA</th>
                        <th>MENSAJE</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dato as $registro) { ?>
                        <tr>
                            <td><?php echo $registro->Nombre; ?></td>
                            <td><?php echo $registro->Apellidos; ?></td>
                            <td><?php echo $registro->Correo; ?></td>
                            <td><?php echo $registro->Servicio; ?></td>
                            <td><?php echo $registro->Fecha; ?></td>
                            <td><?php echo $registro->Hora; ?></td>
                            <td><?php echo $registro->MensajeAdicional; ?></td>
                            <td>
                                <?php
                                $estado = $registro->Estado;
                                $clase_color = '';
                                switch ($estado) {
                                    case 'Pendiente':
                                        $clase_color = 'text-warning';
                                        break;
                                    case 'Cancelado':
                                        $clase_color = 'text-danger';
                                        break;
                                    case 'Confirmado':
                                        $clase_color = 'text-success';
                                        break;
                                    default:
                                        $clase_color = '';
                                        break;
                                }
                                ?>
                                <b class="<?php echo $clase_color; ?>"><?php echo $estado; ?></b>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap">
                                    <?php if ($registro->Estado == 'Pendiente') { ?>
                                        <button class="btn btn-sm btn-success mr-1 mb-1" onclick="cambiarEstado(this, <?php echo $registro->ID; ?>, 'Confirmado')">
                                            <i class="fas fa-check"></i> Confirmar
                                        </button>
                                        <button class="btn btn-sm btn-warning mr-1 mb-1" onclick="cambiarEstado(this, <?php echo $registro->ID; ?>, 'Cancelado')">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                    <?php } ?>
                                    <a href="update/form_update.php?id=<?php echo $registro->ID; ?>" class="btn btn-sm btn-info mr-1 mb-1">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <!-- ✅ Botón Eliminar con data-id -->
                                    <a href="#" class="btn btn-sm btn-danger mr-1 mb-1" data-toggle="modal" data-target="#confirmDelete" data-id="<?php echo $registro->ID; ?>">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!-- Finaliza Row -->
</div><!-- Finaliza Container -->

<?php
include("modal_eliminar.php");
include("../footer.php");
?>

<!-- ✅ Modal Script (jQuery + Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
// ✅ Pasar ID al modal
$('#confirmDelete').on('show.bs.modal', function (e) {
    var id = $(e.relatedTarget).data('id');
    $(this).find('.modal-footer a').attr('href', 'delete/delete.php?id=' + id);
});

// ✅ DataTable
$(document).ready(function() {
    $('#tablaReservas').DataTable({
        "scrollX": true,
        "scrollCollapse": true,
    });
});

// ✅ Cambiar estado con email
function cambiarEstado(btn, idReserva, nuevoEstado) {
    if (!confirm('¿Estás seguro de cambiar el estado a "' + nuevoEstado + '"? Se enviará un email automático al cliente.')) {
        return;
    }

    const textoOriginal = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    btn.disabled = true;
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'enviar_notificacion.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            try {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('✅ Estado actualizado correctamente.\n' + 
                              (response.email_enviado ? '📧 Email enviado al cliente.' : '⚠️ Estado actualizado pero el email no se pudo enviar.'));
                        location.reload();
                    } else {
                        alert('❌ Error: ' + response.message);
                    }
                } else {
                    alert('❌ Error HTTP: ' + xhr.status);
                }
            } catch (e) {
                alert('❌ Error al procesar respuesta: ' + xhr.responseText);
            }
            btn.innerHTML = textoOriginal;
            btn.disabled = false;
        }
    };
    
    var data = 'action=cambiar_estado&id_reserva=' + encodeURIComponent(idReserva) + '&nuevo_estado=' + encodeURIComponent(nuevoEstado);
    xhr.send(data);
}
</script>