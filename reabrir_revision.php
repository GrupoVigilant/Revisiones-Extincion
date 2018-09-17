<?php
// Añadir documentos de sesión y conexión a BBDD
require_once('sesion.php');
require_once('conexion.php');

function write_log($cadena,$tipo)
{
	$usuario = $_SESSION['username'];
	$arch = fopen("./logs/milog_".date("Y-m-d").".txt", "a+"); 

	fwrite($arch, "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." - $usuario - $tipo ] ".$cadena."\n");
	fclose($arch);
}
$tituloPag = 'Reabrir Revisión';

// Recibimos parámetros GET
$id_revision = $_GET['id_revision'];
$id_cliente = $_GET['id_cliente'];

$queryReabrir = 'UPDATE revisiones SET finalizado=0 where id='.$id_revision;

if ($conexion->query($queryReabrir) === TRUE) {
	write_log('Página '.$tituloPag.' - GET - id_cliente='.$id_cliente.' - id_revision='.$id_revision,'Info');
}
else {
	write_log('Página '.$tituloPag.' - GET - id_cliente='.$id_cliente.' - id_revision='.$id_revision.' - Error='.$conexion->error,'Error');
}

header('Location: ficha_cliente.php?id_cliente='.$id_cliente.'&editar=0');
?>