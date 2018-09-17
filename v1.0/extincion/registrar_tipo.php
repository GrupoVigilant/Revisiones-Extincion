<?php
require_once('sesion.php');
require_once('conexion.php');
// Añadimos el título de la página
$tituloPag = 'Dispositivo creado';

// Añadimos el encabezado web
include('formato/encabezado.php');
$form_nombre = $_POST['nombre'];

$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
die("La conexion falló: " . $conexion->connect_error);
}

$query = "INSERT INTO tipos_dispositivos (descripcion)
VALUES ('$form_nombre')";
if ($conexion->query($query) === TRUE) {
	echo "<br />" . "<h2>" . "Dispositivo Creado Exitosamente!" . "</h2>";
	
}
else {
	echo "Error al crear el dispositivo." . $query . "<br>" . $conexion->error;
}
	
mysqli_close($conexion);
?>