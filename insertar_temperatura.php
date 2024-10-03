<?php
include 'conexion.php';

if(isset($_POST["temperature"]) && isset($_POST["distance"])) { 
    $temperature = $_POST["temperature"]; 
    $distance = $_POST["distance"]; 

    // Agrega comillas simples alrededor de los valores numéricos
    $sql = "INSERT INTO temperaturas (temperatura, distancia) VALUES ('$temperature', '$distance')"; 

    if (mysqli_query($conn, $sql)) { 
        echo "\nNew record created successfully"; 
    } else { 
        echo "Error: " . $sql . "<br>" . mysqli_error($conn); 
    }
}
?>
