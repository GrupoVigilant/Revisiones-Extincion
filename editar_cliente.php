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

// Añadimos el título de la página
$tituloPag = 'Editar cliente';

// Recibimos los parámetros POST
$id_cliente = $_GET['id_cliente'];
write_log('Página '.$tituloPag.' - GET - id_cliente='.$id_cliente,'Info');

// Añadimos el encabezado web
include('formato/encabezado.php');

echo '<div data-role="page" class="page_list">		
	<div data-role="header">
		<h1>Revisiones Extinción</h1>
	</div>
	<div data-role="header">
		<h1>'.$tituloPag.'</h1>
	</div>
	<ul data-role="listview" data-theme="a">
		<li>
			<form action="guardar_cliente.php" id="login" method="post" name="abrir" target="_self">
';
	
$query = 'SELECT nombre_cliente, CIF, direccion, emplazamiento, tecnico FROM Clientes WHERE id = '.$id_cliente;
$result = mysqli_query($conexion,$query);
write_log('Página '.$tituloPag.' - Ejecutando='.$query,'Info');

if ($row = mysqli_fetch_array($result)){
do{
	echo '
			<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
			<p><b>Nombre: </b><input name="nombre" type="text" value="'.$row['nombre_cliente'].'"/></p>
			<p><b>CIF: </b><input name="cif" type="text" value="'.$row['CIF'].'"/></p>
			<p><b>Dirección: </b><input name="direccion" type="text" value="'.$row['direccion'].'"/></p>
			<p><b>Emplazamiento: </b><input name="emplazamiento" type="text" value="'.$row['emplazamiento'].'"/></p>
			<p><b>Técnico: </b><input name="tecnico" type="text" value="'.$row['tecnico'].'"/></p>
			<input name="entrar" type="submit" value="Guardar" />
			';
			write_log('Página '.$tituloPag.' - id_cliente='.$id_cliente.' - nombre_cliente='.$row['nombre_cliente'].' - CIF='.$row['CIF'].' - direccion='.$row['direccion'].' - emplazamiento='.$row['emplazamiento'].' - tecnico='.$row['tecnico'],'Info');
}
while ($row = mysqli_fetch_array($result));
} else {
	write_log('Página '.$tituloPag.' - id_cliente='.$id_cliente.' - nombre_cliente='.$row['nombre_cliente'].' - CIF='.$row['CIF'].' - direccion='.$row['direccion'].' - emplazamiento='.$row['emplazamiento'].' - tecnico='.$row['tecnico'].' - Error='.$conexion->error,'Error');
}
mysqli_close($conexion);

echo '
			</form>
		</li>
	</ul>
</div>
</body>
</html>';
?>