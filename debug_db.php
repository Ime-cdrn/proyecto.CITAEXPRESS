<?php
// Script de diagnóstico completo
echo "<h2>🔍 Diagnóstico del Sistema</h2>";

// 1. Verificar conexión MySQL
echo "<h3>1. Probando conexión MySQL...</h3>";
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    echo "<p style='color:red;'>❌ MySQL no está funcionando: " . $conn->connect_error . "</p>";
    echo "<p><strong>Solución:</strong> Inicia MySQL en XAMPP Control Panel</p>";
    exit;
} else {
    echo "<p style='color:green;'>✅ MySQL funcionando</p>";
}

// 2. Verificar/crear base de datos
echo "<h3>2. Verificando base de datos 'citas'...</h3>";
$result = $conn->query("SHOW DATABASES LIKE 'citas'");
if ($result->num_rows == 0) {
    echo "<p style='color:orange;'>⚠️ Base de datos 'citas' no existe. Creándola...</p>";
    if ($conn->query("CREATE DATABASE citas")) {
        echo "<p style='color:green;'>✅ Base de datos 'citas' creada</p>";
    } else {
        echo "<p style='color:red;'>❌ Error creando base de datos: " . $conn->error . "</p>";
        exit;
    }
} else {
    echo "<p style='color:green;'>✅ Base de datos 'citas' existe</p>";
}

// 3. Conectar a la base de datos específica
$conn->select_db("citas");

// 4. Verificar/crear tabla clientes
echo "<h3>3. Verificando tabla 'clientes'...</h3>";
$result = $conn->query("SHOW TABLES LIKE 'clientes'");
if ($result->num_rows == 0) {
    echo "<p style='color:orange;'>⚠️ Tabla 'clientes' no existe. Creándola...</p>";
    $sql = "CREATE TABLE clientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        apellidos VARCHAR(100) NOT NULL,
        correo VARCHAR(150) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql)) {
        echo "<p style='color:green;'>✅ Tabla 'clientes' creada exitosamente</p>";
    } else {
        echo "<p style='color:red;'>❌ Error creando tabla: " . $conn->error . "</p>";
        exit;
    }
} else {
    echo "<p style='color:green;'>✅ Tabla 'clientes' existe</p>";
}

// 5. Mostrar estructura de la tabla
echo "<h3>4. Estructura de la tabla 'clientes':</h3>";
$result = $conn->query("DESCRIBE clientes");
echo "<table border='1' style='border-collapse:collapse;'>";
echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['Field'] . "</td>";
    echo "<td>" . $row['Type'] . "</td>";
    echo "<td>" . $row['Null'] . "</td>";
    echo "<td>" . $row['Key'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// 6. Contar registros existentes
$result = $conn->query("SELECT COUNT(*) as total FROM clientes");
$row = $result->fetch_assoc();
echo "<h3>5. Registros en la tabla:</h3>";
echo "<p>Total de usuarios registrados: <strong>" . $row['total'] . "</strong></p>";

echo "<h3>✅ Sistema listo para usar</h3>";
echo "<p>Ahora puedes registrarte e iniciar sesión normalmente.</p>";

$conn->close();
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
h2 { color: #2c3e50; }
h3 { color: #34495e; margin-top: 20px; }
table { margin: 10px 0; }
th { background: #3498db; color: white; padding: 8px; }
td { padding: 8px; background: white; }
</style>
