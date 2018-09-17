<?php
// Añadir documentos de sesión
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
$id_cliente = $_GET['id_cliente'];
$nombre_cliente = $_GET['nombre_cliente'];

// Añadimos el título de la página
$tituloPag = 'Registrar Revisión';
write_log('Página '.$tituloPag.' - GET - id_cliente='.$id_cliente.' - nombre_cliente='.$nombre_cliente,'Info');

// Añadimos el encabezado web
include('formato/encabezado.php');

$query = 'SELECT nombre_cliente FROM Clientes WHERE id = '.$id_cliente;
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

echo '
<div data-role="page" class="page_list">		
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
		<ul data-role="listview" data-theme="a">
			<li>
				<form action="registro_revision.php" id="login" method="get" name="registrar" target="_self">
				<p><b>Nº Revisión: </b><input name="n_revision" type="text" /></p>
				<p><b>Fecha Creación: </b><input name="f_creacion" type="date" value="'.date('d/m/y').'" /></p>
				<p><b>Tipo: </b>
				<select name="subtipo">
					<option value="1">Extintor</option>
					<option value="2">BIE</option>
					<option value="3">Detecci&oacute;n</option>
					<option value="4">Extinci&oacute;n</option>
					<option value="5">Bater&iacute;a</option>
			</select></p>
				<input type="hidden" name="id_cliente" value="'.$id_cliente.'" />
				<input name="f_finalizacion" type="hidden" value=""/>
				<input name="entrar" type="submit" value="Registrar" />
			</li>
		</ul>
	</div>
</div>
</form>
</body>
</html>';
?>