<?php
require_once('sesion.php');
require_once('conexion.php');

$form_nombre = $_GET['nombre'];
$form_cif = $_GET['cif'];
$form_direccion = $_GET['direccion'];
$form_emplazamiento = $_GET['emplazamiento'];


$query = 'INSERT INTO Clientes (nombre_cliente, CIF, direccion, emplazamiento)
VALUES ("'.prepara_texto($form_nombre).'", "'.prepara_texto($form_cif).'", "'.prepara_texto($form_direccion).'", "'.prepara_texto($form_emplazamiento).'")';
if ($conexion->query($query) === TRUE) {
	header ("Location: listado_clientes.php");
	
}
else {
	echo "Error al crear el cliente." . $query . "<br>" . $conexion->error;
}
	
mysqli_close($conexion);
?>