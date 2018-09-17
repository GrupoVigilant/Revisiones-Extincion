<?php
ini_set("session.cookie_lifetime","10800");
ini_set("session.gc_maxlifetime","10800");
session_start();

require_once('conexion.php');
// Añadimos el título de la página
$tituloPag = 'Login';

// Añadimos el encabezado web
include('formato/encabezado.php');
$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);

if ($conexion->connect_error) {
	die("La conexion falló: " . $conexion->connect_error);
}
$username = $_POST['usuario'];
$password = $_POST['contrasena'];

if ($username == 'tecnico' && $password == 'Vigilant765'){
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['start'] = time();
	$_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
	header ("Location: listado_clientes.php");
}

if ($username == 'id' && $password == 'Vigilant765'){
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['start'] = time();
	$_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
	header ("Location: listado_clientes.php");
}

$sql = "SELECT * FROM Usuarios WHERE nombre = '$username'";
$result = $conexion->query($sql);
if ($result->num_rows > 0) {    
}
$row = $result->fetch_array(MYSQLI_ASSOC);
if ($password == $row['password']) {
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['start'] = time();
	$_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
	header ("Location: revisiones.php");
} else {
	echo "Username o Password estan incorrectos.";
	echo "<br><a href='index.php'>Volver a Intentarlo</a>";
}
mysqli_close($conexion);
?>