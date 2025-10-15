<?php
session_start();
if (!isset($_SESSION['id_cliente'])) {
    header("Location: /citas/index.php");
    exit();
}
include "header.php";
include "navbar.php";
include "admin/model/conexion.php";

// Realiza una consulta SQL para seleccionar todos los registros de la tabla "Contacto"
$query = "SELECT * FROM Contacto";
$result = $db->query($query);

?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow card-hover">
        <div class="card-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
          <h3 class="card-title mb-0 text-white">
            <i class="bi bi-telephone me-2"></i>Medios de Contacto
          </h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th><i class="bi bi-info-circle me-1"></i> Información de Contacto</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Itera a través de los resultados y muestra cada registro en una fila de la tabla
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>";
                  echo "<td><i class='bi bi-record-circle me-2 text-gradient'></i>" . $row['Descripcion'] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>