<?php
require_once('sesion.php');
require_once('conexion.php');

// Añadimos el título de la página
$tituloPag = 'Revisi&oacute;n Creada';

// Añadimos el encabezado web
include('formato/encabezado.php');

$id_cliente = $_GET['id_cliente'];
$n_revision = $_GET['n_revision'];
$f_creacion = $_GET['f_creacion'];
$f_creacion = strtotime("$f_creacion");
$f_creacion = date('Y-m-d',$f_creacion);
$f_finalizacion = "";	 
$tipo_revision = $_GET['subtipo'];

$query = 'INSERT INTO revisiones (n_revision, f_creacion, f_finalizacion, id_cliente, finalizado, tipo) VALUES ("'.$n_revision.'", "'.$f_creacion.'", "'.$f_finalizacion.'", "'.$id_cliente.'", 0, '.$tipo_revision.')';
if ($conexion->query($query) === TRUE) {
	header('Location: ficha_cliente.php?id_cliente='.$id_cliente.'&editar=0');	
}
else {
	
}
	
mysqli_close($conexion);
?>