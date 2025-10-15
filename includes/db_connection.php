<?php
// Archivo de conexión a la base de datos MySQL para el proyecto.
// Expone la variable $conn (mysqli) para su reutilización mediante include/require.
// En caso de error de conexión, se detiene la ejecución con un mensaje claro.
// Nota: Para entornos de producción, externaliza las credenciales (p. ej., variables de entorno).

// Configuración de la base de datos
$servername = "localhost";
$username = "root";       
$password = "";  // <-- Contraseña vacía para XAMPP por defecto
$dbname = "citas";        

// Crea la conexión (instancia de mysqli) con las credenciales definidas arriba
// @var mysqli $conn
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión y falla rápido para evitar operaciones sobre una conexión inválida
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>