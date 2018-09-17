<?php
require_once('sesion.php');
require_once('conexion.php');

$id_cliente = $_POST['id_cliente'];
$form_nombre = $_POST['nombre'];
$form_cif = $_POST['cif'];
$form_direccion = $_POST['direccion'];
$form_emplazamiento = $_POST['emplazamiento'];
$form_tecnico = $_POST['tecnico'];


$query = 'UPDATE Clientes SET nombre_cliente="'.prepara_texto($form_nombre).'", CIF="'.prepara_texto($form_cif).'", direccion="'.prepara_texto($form_direccion).'", 
	emplazamiento="'.prepara_texto($form_emplazamiento).'", tecnico="'.prepara_texto($form_tecnico).'" WHERE id = '.$id_cliente;
if ($conexion->query($query) === TRUE) {
	header ("Location: listado_clientes.php");
}
else {
echo "Error al crear el cliente." . $query . "<br>" . $conexion->error;
}
	
mysqli_close($conexion);
?>