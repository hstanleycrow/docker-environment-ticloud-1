<?php
$servername = "mysql_db"; // El nombre del contenedor del servicio MySQL
$username = "us_ticrm";
$password = "ErRiñ3#%3dddsqwe";
$dbname = "db_ticcrm";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
