<?php
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperatura Actual</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="EstilosMostrarTemperatura.css"> <!-- Enlace al archivo CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="gradient">
        <?php
        // Realizar consulta SQL para obtener la temperatura más reciente
        $query = "SELECT temperatura, distancia FROM temperaturas ORDER BY fecha_temperatura DESC LIMIT 1";
        $result = mysqli_query($conn, $query);

        echo "<h1>Temperatura Actual</h1>";

        if (mysqli_num_rows($result) > 0) {
            // Imprimir el valor de temperatura si hay resultados
            $row = mysqli_fetch_assoc($result);
            // Obtener la temperatura
            $temperatura = $row["temperatura"];
            $distancia = $row["distancia"];

            // Mostrar la temperatura
            if ($temperatura < 10) {
                echo "<p>La temperatura actual es: " . $temperatura . " °C <img id='icon' src='./img/baja-temperatura.png' alt='Hace frío' style='width: 60px'></p>";
            } elseif ($temperatura >= 10 && $temperatura <= 30) {
                echo "<p>La temperatura actual es: " . $temperatura . " °C <img id='icon' src='./img/aire.png' alt='Temperatura normal' style='width: 60px'></p>";
            } else {
                echo "<p>La temperatura actual es: " . $temperatura . " °C <img id='icon' src='./img/temperatura-alta.png' alt='Temperatura normal' style='width: 60px'></p>";
            }

            echo "<h1>Distancia Actual</h1>";
            echo "<p>distancia " . $distancia . "</p>";
        } else {
            echo "<p>No se encontraron registros.</p>";
        }

        // Liberar el resultado de la consulta
        mysqli_free_result($result);

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
        ?>

        <button onclick="toggleHistorial()">Ver Historial</button>

        <div id="historial" style="display:none;">



            <h1>Historial de Temperaturas y Distancias</h1>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Temperatura (°C)</th>
                        <th>Distancia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fechas = array();
                    $temperaturas = array();
                    $distancias = array();
                    // Realizar consulta SQL para obtener el historial limitado a los primeros 10 registros
                    include 'conexion.php'; // Asegurarse de incluir la conexión nuevamente
                    $queryHistorial = "SELECT fecha_temperatura, temperatura, distancia FROM temperaturas ORDER BY fecha_temperatura DESC LIMIT 10";
                    $resultHistorial = mysqli_query($conn, $queryHistorial);

                    if (mysqli_num_rows($resultHistorial) > 0) {
                        // Imprimir todos los registros
                        while ($rowHistorial = mysqli_fetch_assoc($resultHistorial)) {
                            echo "<tr>";
                            echo "<td>" . $rowHistorial["fecha_temperatura"] . "</td>";
                            echo "<td>" . $rowHistorial["temperatura"] . "</td>";
                            echo "<td>" . $rowHistorial["distancia"] . "</td>";
                            echo "</tr>";

                            $fechas[] = $rowHistorial["fecha_temperatura"];
                            $temperaturas[] = $rowHistorial["temperatura"];
                            $distancias[] = $rowHistorial["distancia"];
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron registros.</td></tr>";
                    }

                    // Liberar el resultado de la consulta
                    mysqli_free_result($resultHistorial);

                    // Cerrar la conexión a la base de datos
                    mysqli_close($conn);
                    ?>


                </tbody>
            </table>

            <div class="container">
                <div class="chart-container">
                    <h2>Historial de Temperatura</h2>
                    <canvas id="chartTemperatura" width="400" height="200"></canvas>
                </div>
                <div class="chart-container">
                    <h2>Historial de Distancia</h2>
                    <canvas id="chartDistancia" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
                    
    </div>
    </div>
    </div>

    <script src="funciones.js"></script>
    <script>
        var ctxTemperatura = document.getElementById('chartTemperatura').getContext('2d');
        var ctxDistancia = document.getElementById('chartDistancia').getContext('2d');

        var chartTemperatura = new Chart(ctxTemperatura, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_reverse($fechas)); ?>,
                datasets: [{
                    label: 'Temperatura (°C)',
                    data: <?php echo json_encode(array_reverse($temperaturas)); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' 
                        }
                    }
                }
            }
        });

        var chartDistancia = new Chart(ctxDistancia, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_reverse($fechas)); ?>,
                datasets: [{
                    label: 'Distancia',
                    data: <?php echo json_encode(array_reverse($distancias)); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1

                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' 
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>