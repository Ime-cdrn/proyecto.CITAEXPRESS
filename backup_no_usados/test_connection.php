<?php
// Script para probar la conexión a la base de datos
echo "<h2>Prueba de Conexión a la Base de Datos</h2>";

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "citas";

echo "<p><strong>Configuración:</strong></p>";
echo "<ul>";
echo "<li>Servidor: $servername</li>";
echo "<li>Usuario: $username</li>";
echo "<li>Base de datos: $dbname</li>";
echo "</ul>";

// Intentar conectar sin especificar base de datos primero
echo "<h3>1. Probando conexión al servidor MySQL...</h3>";
$conn_test = new mysqli($servername, $username, $password);

if ($conn_test->connect_error) {
    echo "<p style='color:red;'>❌ Error de conexión al servidor MySQL: " . $conn_test->connect_error . "</p>";
    echo "<h3>Posibles soluciones:</h3>";
    echo "<ol>";
    echo "<li><strong>Iniciar XAMPP:</strong> Abre el Panel de Control de XAMPP</li>";
    echo "<li><strong>Iniciar MySQL:</strong> Haz clic en 'Start' junto a MySQL</li>";
    echo "<li><strong>Verificar puerto:</strong> MySQL debe estar en el puerto 3306</li>";
    echo "<li><strong>Verificar servicios:</strong> MySQL debe aparecer como 'Running'</li>";
    echo "</ol>";
} else {
    echo "<p style='color:green;'>✅ Conexión al servidor MySQL exitosa</p>";
    
    // Ahora probar la base de datos específica
    echo "<h3>2. Probando conexión a la base de datos '$dbname'...</h3>";
    $conn_db = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn_db->connect_error) {
        echo "<p style='color:orange;'>⚠️ La base de datos '$dbname' no existe</p>";
        echo "<h3>Crear base de datos:</h3>";
        echo "<p>Ejecuta este comando en phpMyAdmin o en la consola MySQL:</p>";
        echo "<code style='background:#f4f4f4;padding:10px;display:block;'>CREATE DATABASE citas;</code>";
        
        // Intentar crear la base de datos
        if ($conn_test->query("CREATE DATABASE IF NOT EXISTS citas")) {
            echo "<p style='color:green;'>✅ Base de datos 'citas' creada exitosamente</p>";
        } else {
            echo "<p style='color:red;'>❌ Error al crear la base de datos: " . $conn_test->error . "</p>";
        }
    } else {
        echo "<p style='color:green;'>✅ Conexión a la base de datos '$dbname' exitosa</p>";
        
        // Verificar si existe la tabla clientes
        echo "<h3>3. Verificando tabla 'clientes'...</h3>";
        $result = $conn_db->query("SHOW TABLES LIKE 'clientes'");
        
        if ($result->num_rows > 0) {
            echo "<p style='color:green;'>✅ Tabla 'clientes' existe</p>";
        } else {
            echo "<p style='color:orange;'>⚠️ Tabla 'clientes' no existe</p>";
            echo "<p>Necesitas crear la tabla 'clientes' con la estructura correcta.</p>";
        }
        
        $conn_db->close();
    }
    $conn_test->close();
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
code { background: #f4f4f4; padding: 5px; border-radius: 3px; }
h2 { color: #333; }
h3 { color: #666; }
</style>
