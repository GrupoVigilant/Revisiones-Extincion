<?php
require_once('sesion.php');
require_once('conexion.php');

// Añadimos el título de la página
$tituloPag = 'Creaci&oacute;n de usuario';

// Añadimos el encabezado web
include('formato/encabezado.php');

$form_pass = $_POST['contrasena'];
$form_user = $_POST['usuario'];

$buscarUsuario = 'SELECT * FROM usuarios WHERE nombre = "'.$form_user.'"';

$result = $conexion->query($buscarUsuario);

$count = mysqli_num_rows($result);
if ($count == 1) {
echo "<br />". "El Nombre de Usuario ya est&aacute; registrado." . "<br />";
echo "<a href='registro.php'>Por favor escoga otro Nombre</a>";
}
else{
$query = 'INSERT INTO Usuarios (nombre, password)
VALUES ("'.$form_user.'", "'.$form_pass.'")';
if ($conexion->query($query) === TRUE) {
	echo "<br />" . "<h2>" . "Usuario Creado Exitosamente!" . "</h2>";
	echo "<h4>" . "Bienvenido: " . $form_user . "</h4>" . "\n\n";
	echo "<h5>" . "Hacer Login: " . "<a href='index.php'>Login</a>" . "</h5>";
}
else {
	echo "Error al crear el usuario." . $query . "<br>" . $conexion->error;
}
}
mysqli_close($conexion);
?>