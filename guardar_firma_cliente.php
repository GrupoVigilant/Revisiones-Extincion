<?php
require_once('sesion.php');
require_once('conexion.php');

$ruta_firma = $_POST['ruta_firma'];
$n_revision = $_POST['n_revision'];
$id_cliente = $_POST['id_cliente'];
$id_revision = $_POST['id_revision'];

// Añadimos el título de la página
$tituloPag = 'Firma Enviada';

// Añadimos el encabezado web
include('formato/encabezado.php');
 
// convierte la imagen recibida en base64
// Eliminamos los 22 primeros caracteres, que
// contienen el substring "data:image/png;base64,"
// $imgData = base64_decode(substr($ruta_firma,22));

// Path en donde se va a guardar la imagen
// $file = 'firma_cliente.png';

// borrar primero la imagen si existía previamente
// if (file_exists($file)) { unlink($file); }

// guarda en el fichero la imagen contenida en $imgData
// $fp = fopen($file, 'w');
// fwrite($fp, $imgData);
// fclose($fp);

$query = "UPDATE revisiones SET firma_cliente='".$ruta_firma."' WHERE id='".$id_revision."'";
if ($conexion->query($query) === TRUE) {
	header('Location: finalizar_revision.php?n_revision='.$n_revision.'&id_cliente='.$id_cliente.'&id_revision='.$id_revision);		
}
else {
	echo "Error al enviar firma";
}

?>