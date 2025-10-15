<?php
// Verificar conexión de base de datos para notificaciones
echo "<h2>🔍 Verificando Base de Datos para Notificaciones</h2>";

try {
    include 'model/conexion.php';
    echo "<div style='color: green; background: #e6ffe6; padding: 10px; margin: 10px 0;'>";
    echo "✅ Conexión a base de datos exitosa";
    echo "</div>";
    
    // Probar consulta de reservas
    $consulta = $db->prepare("SELECT * FROM reservas LIMIT 1");
    $consulta->execute();
    $reserva = $consulta->fetch(PDO::FETCH_OBJ);
    
    if ($reserva) {
        echo "<h3>📋 Datos de prueba encontrados:</h3>";
        echo "<p><strong>ID:</strong> " . $reserva->ID . "</p>";
        echo "<p><strong>Nombre:</strong> " . $reserva->Nombre . "</p>";
        echo "<p><strong>Email:</strong> " . $reserva->Correo . "</p>";
        echo "<p><strong>Estado:</strong> " . $reserva->Estado . "</p>";
        
        echo "<div style='color: green; background: #e6ffe6; padding: 10px; margin: 10px 0;'>";
        echo "✅ Tabla 'reservas' accesible y con datos";
        echo "</div>";
    } else {
        echo "<div style='color: orange; background: #fff3cd; padding: 10px; margin: 10px 0;'>";
        echo "⚠️ Tabla 'reservas' existe pero está vacía";
        echo "</div>";
    }
    
    // Probar actualización de estado (simulada)
    echo "<h3>🔄 Probando actualización de estado...</h3>";
    
    if ($reserva) {
        $test_update = $db->prepare("UPDATE reservas SET Estado = ? WHERE ID = ?");
        $resultado = $test_update->execute([$reserva->Estado, $reserva->ID]); // Mismo estado para no cambiar nada
        
        if ($resultado) {
            echo "<div style='color: green; background: #e6ffe6; padding: 10px; margin: 10px 0;'>";
            echo "✅ Actualización de estado funciona correctamente";
            echo "</div>";
        } else {
            echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 10px 0;'>";
            echo "❌ Error en actualización de estado";
            echo "</div>";
        }
    }
    
} catch (Exception $e) {
    echo "<div style='color: red; background: #ffe6e6; padding: 15px; margin: 10px 0;'>";
    echo "❌ <strong>ERROR DE BASE DE DATOS:</strong><br>";
    echo $e->getMessage();
    echo "</div>";
    
    echo "<h3>🔧 Posibles soluciones:</h3>";
    echo "<ul>";
    echo "<li>Verificar que MySQL esté ejecutándose en XAMPP</li>";
    echo "<li>Verificar que la base de datos 'citas' exista</li>";
    echo "<li>Verificar que la tabla 'reservas' exista</li>";
    echo "<li>Revisar credenciales en model/conexion.php</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<h3>📝 Conclusión:</h3>";
echo "<p>Si ves errores arriba, ese es el problema de las notificaciones.</p>";
echo "<p>Las notificaciones <strong>SÍ necesitan</strong> la base de datos para funcionar.</p>";
?>
