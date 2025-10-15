<?php
require_once __DIR__ . "/header.php";
// Incluir archivo de configuración de la base de datos
include(__DIR__ . "/model/conexion.php");

$citas = [];

try {
    // Verificar si existe la conexión a la base de datos
    if (isset($db)) {
        // Intentar con la tabla moderna 'reservas'
        $sql = "SELECT id, CONCAT(nombre, ' ', apellidos) AS title, fecha AS start, hora AS time, servicio, estado FROM reservas ORDER BY fecha, hora";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    // Fallback a posible esquema anterior 'Reservas'
    try {
        $sql = "SELECT ID AS id, Nombre AS title, Fecha AS start, Hora AS time FROM Reservas ORDER BY Fecha, Hora";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e2) {
        // Si ambos fallan, mantener array vacío
        $citas = [];
        error_log("Error en calendario: " . $e2->getMessage());
    }
}

// Procesar las citas para el calendario
$eventos_calendario = [];
foreach ($citas as $cita) {
    $color = '#3498db'; // Azul por defecto
    
    // Colores según el estado si existe
    if (isset($cita['estado'])) {
        switch (strtolower($cita['estado'])) {
            case 'confirmado':
                $color = '#1fd67bff'; // Verde
                break;
            case 'pendiente':
                $color = '#d8972fff'; // Naranja
                break;
            case 'cancelado':
                $color = '#ad3d31ff'; // Rojo
                break;
        }
    }
    
    $eventos_calendario[] = [
        'id' => $cita['id'],
        'title' => $cita['title'],
        'start' => $cita['start'],
        'time' => $cita['time'],
        'color' => $color,
        'servicio' => isset($cita['servicio']) ? $cita['servicio'] : '',
        'estado' => isset($cita['estado']) ? $cita['estado'] : 'confirmado'
    ];
}

// Convierte las citas a formato JSON
$citas_json = json_encode($eventos_calendario, JSON_UNESCAPED_UNICODE);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Reservas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(52, 152, 219, 0.3);
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Estilos personalizados para FullCalendar */
        .fc-event {
            border-radius: 8px;
            border: none;
            padding: 2px 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .fc-daygrid-event {
            margin: 1px 2px;
        }
        
        .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .fc-button-primary {
            background-color: #3498db;
            border-color: #3498db;
            border-radius: 8px;
        }
        
        .fc-button-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .fc-today-button {
            background-color: #27ae60 !important;
            border-color: #27ae60 !important;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="hero-section">
            <h1 class="mb-2">
                <i class="bi bi-calendar3 me-2"></i>
                Calendario de Reservas
            </h1>
            <p class="lead mb-0">Visualiza y gestiona todas las reservas del sistema</p>
        </div>
        
        <div class="card card-hover">
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
        
        <!-- Leyenda de colores -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6 class="mb-2">Leyenda de Colores:</h6>
                    <span class="badge" style="background-color: #297c4cff; margin-right: 10px;">Confirmado</span>
                    <span class="badge" style="background-color: #c09042ff; margin-right: 10px;">Pendiente</span>
                    <span class="badge" style="background-color: #af564cff; margin-right: 10px;">Cancelado</span>
                    <span class="badge" style="background-color: #4e7d9cff; margin-right: 10px;">Sin estado</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/es.global.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        if (!calendarEl) {
            console.error('Elemento calendar no encontrado');
            return;
        }
        
        try {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                height: 'auto',
                nowIndicator: true,
                navLinks: true,
                editable: false,
                dayMaxEvents: 3,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: <?php echo $citas_json; ?>,
                eventDidMount: function(info) {
                    // Agregar tooltip con información adicional
                    var tooltip = 'Cliente: ' + info.event.title;
                    if (info.event.extendedProps.time) {
                        tooltip += '\nHora: ' + info.event.extendedProps.time.substring(0,5);
                    }
                    if (info.event.extendedProps.servicio) {
                        tooltip += '\nServicio: ' + info.event.extendedProps.servicio;
                    }
                    if (info.event.extendedProps.estado) {
                        tooltip += '\nEstado: ' + info.event.extendedProps.estado;
                    }
                    
                    info.el.setAttribute('title', tooltip);
                },
                eventContent: function(arg) {
                    var time = arg.event.extendedProps.time ? arg.event.extendedProps.time.substring(0,5) : '';
                    var title = arg.event.title || 'Sin nombre';
                    var servicio = arg.event.extendedProps.servicio || '';
                    
                    var html = '<div style="padding: 2px;">';
                    if (time) {
                        html += '<strong>' + time + '</strong><br>';
                    }
                    html += '<span>' + title + '</span>';
                    if (servicio) {
                        html += '<br><small>' + servicio + '</small>';
                    }
                    html += '</div>';
                    
                    return { html: html };
                },
                eventClick: function(info) {
                    // Mostrar información detallada del evento
                    var mensaje = 'Detalles de la Reserva:\n\n';
                    mensaje += 'Cliente: ' + info.event.title + '\n';
                    mensaje += 'Fecha: ' + info.event.start.toLocaleDateString('es-ES') + '\n';
                    if (info.event.extendedProps.time) {
                        mensaje += 'Hora: ' + info.event.extendedProps.time + '\n';
                    }
                    if (info.event.extendedProps.servicio) {
                        mensaje += 'Servicio: ' + info.event.extendedProps.servicio + '\n';
                    }
                    if (info.event.extendedProps.estado) {
                        mensaje += 'Estado: ' + info.event.extendedProps.estado + '\n';
                    }
                    
                    alert(mensaje);
                }
            });
            
            calendar.render();
            
        } catch (error) {
            console.error('Error al inicializar el calendario:', error);
            document.getElementById('calendar').innerHTML = 
                '<div class="alert alert-danger">Error al cargar el calendario. Por favor, recarga la página.</div>';
        }
    });
    </script>
</body>
</html>

<?php
if (isset($footer_file) && file_exists($footer_file)) {
    include $footer_file;
} else {
    // Footer básico si no existe el archivo
    echo '</body></html>';
}
?>