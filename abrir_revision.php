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

// Recibimos los parámetros POST
$id_revision = $_GET['id_revision'];
$id_cliente = $_GET['id_cliente'];

// Añadimos el título de la página
$tituloPag = 'Listado Documentos Revisión';
write_log('Página '.$tituloPag.'- GET - id_revision='.$id_revision.' - id_cliente='.$id_cliente,'Info');

// Añadimos el encabezado web
include('formato/encabezado.php');

$query = "SELECT nombre_cliente FROM Clientes WHERE id = ".$id_cliente;
$result = mysqli_query($conexion,$query);
write_log('Página '.$tituloPag.' - Ejecutando='.$query,'Info');

if ($row = mysqli_fetch_array($result)){
	do{
		$nombre_cliente = $row['nombre_cliente'];
		write_log('Página '.$tituloPag.' - nombre_cliente='.$nombre_cliente,'Info');
	}
	while ($row = mysqli_fetch_array($result));
} else {
	write_log('Página '.$tituloPag.' - nombre_cliente='.$nombre_cliente.' - Error='.$conexion->error,'Error');
} 

echo '<div data-role="page" class="page_list">		
	<div data-role="header">
		<h1>Revisiones Extinción</h1>
	</div>
	<div data-role="header">
		<h1>'.$tituloPag.'</h1>
	</div>
	<div data-role="header">
		<h1>'.$nombre_cliente.'</h1>
	</div>
	<div id="content" data-role="content">
        <div>
			<ul data-role="listview" data-theme="a">';


// Consulta de listado de documentos de la revisión
$query = 'SELECT ruta, tipo FROM documentos WHERE id_revision = '.$id_revision;
$result = mysqli_query($conexion,$query);
write_log('Página '.$tituloPag.' - Ejecutando='.$query,'Info');

if ($row = mysqli_fetch_array($result)){
	do{
		$ruta = $row['ruta'];
		$nombreDoc = substr($ruta,9);
		echo '
		<li>
			<form action="'.$ruta.'" id="login" method="get" name="abrir'.$nombreDoc.'" target="_self">
				<a class="ui-link-inherit" href="#" onclick="document.forms[`abrir'.$nombreDoc.'`].submit();">
					<h4>'.$row['tipo'].'</h4>
					<p>'.$nombreDoc.'</p>
				</a>
			</form>
		</li>
		';
		write_log('Página '.$tituloPag.' - ruta='.$ruta.' - nombreDoc='.$nombreDoc.'tipo='.$row['tipo'],'Info');
	}
	while ($row = mysqli_fetch_array($result));
} else {
	write_log('Página '.$tituloPag.' - ruta='.$ruta.' - nombreDoc='.$nombreDoc.'tipo='.$row['tipo'].' - Error='.$conexion->error,'Error');
}
mysqli_close($conexion);

echo '		</ul>	
        </div>
    </div>     
</div>
</body>
</html>';
?>