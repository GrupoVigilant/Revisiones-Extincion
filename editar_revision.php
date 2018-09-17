<?php
// Añadir documentos de sesión y conexión a BBDD
require_once('sesion.php');
require_once('conexion.php');

// Añadimos el título de la página
$tituloPag = 'Revisi&oacute;n Actualizada';

// Añadimos el encabezado web
include('formato/encabezado.php');

// Recibimos los parámetros POST
$id_revision = $_GET['id_revision'];
$n_revision = $_GET['n_revision'];
$f_creacion = $_GET['f_creacion'];
$f_finalizacion = $_GET['f_finalizacion'];
$tecnico = $_GET['tecnico'];
$id_cliente = $_GET['id_cliente'];
$tecnico = $_GET['tecnico'];

// Parseamos las fechas al estilo dia-mes-año
$f_creacion = strtotime($f_creacion);
$f_creacion = date('Y-m-d',$f_creacion); 	 
$f_finalizacion = strtotime($f_finalizacion);
$f_finalizacion = date('Y-m-d',$f_finalizacion);	 

$query = 'UPDATE revisiones SET n_revision="'.$n_revision.'", f_creacion="'.$f_creacion.'", f_finalizacion="'.$f_finalizacion.'", tecnico="'.$tecnico.'", id_cliente="'.$id_cliente.'"
	WHERE id='.$id_revision;
if ($conexion->query($query) === TRUE) {
	echo '<br /> Revisi&oacute;n Actualizada</h2>
		<form action="ficha_cliente.php" id="login" method="get" name="registrar" target="_self">
		<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
		<input type="hidden" id="editar" name="editar" value="0">
		<input name="entrar" type="submit" value="Volver" />
		</form>';
}
else {
	echo 'Error al guardar la revisi&oacute;n.' . $query . '<br>' . $conexion->error;
}
	
mysqli_close($conexion);
?>