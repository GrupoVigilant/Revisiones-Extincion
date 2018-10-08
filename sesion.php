<?php
session_start();
// Añadimos el título de la página
$tituloPag = 'Error de inicio de sesi&oacute;n';

// Añadimos el encabezado web

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
	include('formato/encabezado.php');
	header ("Location: index.php");
	exit;
}

$date = new DateTime();
$date->modify('-4 hours');
$date = strtotime($date->format('d-m-Y H:i:s'));
$usuario = $_SESSION['username'];
if($date > $_SESSION['expire']) {
	session_destroy();
	include('formato/encabezado.php');
	header ("Location: index.php");
}
?>