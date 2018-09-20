<?php
// Añadir documentos de sesión y conexión a BBDD
require_once('sesion.php');
require_once('conexion.php');

// Añadimos el título de la página
$tituloPag = 'Ficha de cliente';

function write_log($cadena,$tipo)
{
	$usuario = $_SESSION['username'];
	$arch = fopen("./logs/milog_".date("Y-m-d").".txt", "a+"); 

	fwrite($arch, "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." - $usuario - $tipo ] ".$cadena."\n");
	fclose($arch);
}

// Recibimos los parámetros POST
$id_cliente = $_GET['id_cliente'];
$esEditar = $_GET['editar'];
write_log('Página '.$tituloPag.'- GET - id_cliente='.$id_cliente.' - esEditar='.$esEditar,'Info');

// Añadimos el encabezado web
include('formato/encabezado.php');

// Comprobamos si se ha pulsado Editar
if($esEditar==1){
	$editar=1;
	$id_editar=$_GET['id_revision'];
	write_log('Página '.$tituloPag.'- GET - id_editar='.$id_editar,'Info');
} else { 
	$editar=0;
}

// Datos del cliente

$query = 'SELECT nombre_cliente, cif, direccion, emplazamiento FROM Clientes WHERE id = '.$id_cliente;
$result = mysqli_query($conexion,$query);

if ($row = mysqli_fetch_array($result)){
	do{
		$nombre_cliente = $row['nombre_cliente'];
		$cif = $row['cif'];
		$direccion = $row['direccion'];
		$emplazamiento = $row['emplazamiento'];
	}
	while ($row = mysqli_fetch_array($result));
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
		<h4>'.$cif.'</h4>
		<h4>'.$direccion.'</h4>
		<h4>'.$emplazamiento.'</h4>
		<form action="editar_cliente.php" id="login" method="get" name="abrir" target="_self">
			<input type="hidden" name="id_cliente" value="'.$id_cliente.'"/>
			<input name="entrar" type="submit" value="Editar Datos" />
		</form>
	</div>
	<div id="content" data-role="content">
        <div>

			<ul data-role="listview" data-theme="a">';
		
$query = 'SELECT id, n_revision, f_creacion, f_finalizacion, tecnico, finalizado, tipo FROM revisiones WHERE id_cliente = '.$id_cliente;
$result = mysqli_query($conexion,$query);
	
if ($row = mysqli_fetch_array($result)){
	do{
		$id_revision = $row['id'];
		$n_revision = $row['n_revision'];
		$fc_creacion = $row['f_creacion'];
		$fc_creacion = strtotime($fc_creacion);
		$fc_creacion = date('d-m-Y',$fc_creacion);
		$fc_finalizacion = $row['f_finalizacion'];
		$fc_finalizacion = strtotime($fc_finalizacion);
		$fc_finalizacion = date('d-m-Y',$fc_finalizacion);
		$finalizado = $row['finalizado'];
		$tipo_revision = $row['tipo'];
		switch ($tipo_revision) {
			case 1:
				$txtTipoRev = 'Extintor';
				break;
			case 2:
				$txtTipoRev = 'BIEs';
				break;
			case 3:
				$txtTipoRev = 'Detección';
				break;
			case 4:
				$txtTipoRev = 'Extinción';
				break;
			case 5:
				$txtTipoRev = 'Batería';
				break;
		}
		echo '
		<li>
			<form action="iniciar_revision.php" id="login" method="get" name="iniciar'.$id_revision.'" target="_self">
				<input type="hidden" id="id_revision" name="id_revision" value='.$id_revision.'>
				<input type="hidden" id="n_revision" name="n_revision" value='.$n_revision.'>
				<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
				<input type="hidden" id="tipo_revision" name="tipo_revision" value='.$tipo_revision.'>
				<input type="hidden" id="editar" name="editar" value="0">
			</form>
			<form action="abrir_revision.php" id="login" method="get" name="abrir'.$id_revision.'" target="_self">
				<input type="hidden" id="id_revision" name="id_revision" value='.$id_revision.'>
				<input type="hidden" id="n_revision" name="n_revision" value='.$n_revision.'>
				<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
				<input type="hidden" id="editar" name="editar" value="0">
			</form>
			<form action="ficha_cliente.php" id="login" method="get" name="editar'.$id_revision.'" target="_self">
				<input type="hidden" id="id_revision" name="id_revision" value='.$id_revision.'>
				<input type="hidden" id="n_revision" name="n_revision" value='.$n_revision.'>
				<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
				<input type="hidden" id="editar" name="editar" value="1">';
				if ($finalizado==1){
					echo '<a class="ui-link-inherit" href="#" onclick="document.forms[`abrir'.$id_revision.'`].submit();">';
				} else {
					echo '<a class="ui-link-inherit" href="#" onclick="document.forms[`iniciar'.$id_revision.'`].submit();">';
				}
				echo '<p><b>Nº Revisión: </b>'.$row['n_revision'].'<b style="padding-left: 15px;">Tipo: </b>'.$txtTipoRev.'</p>
				<p><b>Fecha Creación: </b>'.$fc_creacion.'</p>';
				if($finalizado!=0){
					echo '<p><b>Fecha Finalización: </b>'.$fc_finalizacion.'</p>';
				}
				 
				echo '
			
			</a>
			</form>
		</li>';
		if($finalizado!=0){
			echo '
			<li>
			<form action="reabrir_revision.php" id="reabrir" method="get" name="reabrir" target="_self">
				<input type="hidden" name="id_cliente" value="'.$id_cliente.'">
				<input type="hidden" name="id_revision" value="'.$id_revision.'">
				<input type="submit" value="Reabrir Revisión">
			</form>	
			</li>
			';
		}
	}
	while ($row = mysqli_fetch_array($result));
} else {
	
}

mysqli_close($conexion);

echo '
<li>
		<form action="crear_revision.php" id="login" method="get" name="abrir" target="_self">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
			<input type="hidden" id="nombre_cliente" name="nombre_cliente" value="'.$nombre_cliente.'">
			<input name="entrar" type="submit" value="Crear Revisi&oacute;n"/>
		</form>
</li>
</ul>
</div>
</div>
</div>
</body>
</html>';
?>