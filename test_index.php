<?php
// Script de prueba para verificar qué página se está cargando
echo "<h1>TEST - Verificando página por defecto</h1>";
echo "<p>Esta página se está ejecutando desde: <strong>" . $_SERVER['PHP_SELF'] . "</strong></p>";
echo "<p>URL actual: <strong>" . $_SERVER['REQUEST_URI'] . "</strong></p>";
echo "<p>Directorio actual: <strong>" . __DIR__ . "</strong></p>";

// Verificar si existe index.php
if (file_exists('index.php')) {
    echo "<p style='color:green;'>✅ index.php existe en esta carpeta</p>";
} else {
    echo "<p style='color:red;'>❌ index.php NO existe en esta carpeta</p>";
}

// Listar archivos en el directorio
echo "<h3>Archivos en el directorio:</h3>";
$files = scandir('.');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "<li>$file</li>";
    }
}

echo "<hr>";
echo "<p><a href='index.php'>Ir a index.php</a></p>";
echo "<p><a href='/citas/'>Ir a /citas/</a></p>";
?>
