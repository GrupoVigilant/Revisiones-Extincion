<?php
require_once('sesion.php');
require_once('conexion.php');

$id_cliente = $_GET['id_cliente'];

// Añadimos el título de la página
$tituloPag = 'Ficha de cliente';

// Añadimos el encabezado web
include('formato/encabezado.php');

$query = 'SELECT nombre_cliente FROM Clientes WHERE id = '.$id_cliente;
$result = mysqli_query($conexion,$query);

if ($row = mysqli_fetch_array($result)){
	do{
		$nombre_cliente = $row['nombre_cliente'];
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
		$fc_creacion = strtotime("$fc_creacion");
		$fc_creacion = date('d-m-Y',$fc_creacion);
		$fc_finalizacion = $row['f_finalizacion'];
		$fc_finalizacion = strtotime("$fc_finalizacion");
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
		if($finalizado == 1){
			echo '
			<li>
				<form action="abrir_revision.php" id="login" method="get" name="abrir'.$id_revision.'" target="_self">
				<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
				<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
				<a class="ui-link-inherit" href="#" onclick="document.forms[`abrir'.$row['id'].'`].submit();">
					<p><b>Nº Revisión: </b>'.$row['n_revision'].'<b style="padding-left: 15px;">Tipo: </b>'.$txtTipoRev.'</p>
					<p><b>Fecha Creación: </b>'.$fc_creacion.'</p>';
					if($finalizado==0){
						echo "<p><b>Fecha Finalización: </b></p>";
					} else {
						echo "<p><b>Fecha Finalización: </b>".$fc_finalizacion."</p>";
					}
					echo '
				</a>
				</form>
			</li>';
		} else {
			echo '
			<li>
				<form action="iniciar_revision.php" id="login" method="get" name="abrir'.$id_revision.'" target="_self">
				<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
				<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
				<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
					<input type="hidden" id="tipo_revision" name="tipo_revision" value='.$tipo_revision.'>
				<input type="hidden" id="nuevo" name="nuevo" value="0">
				<input type="hidden" id="editar" name="editar" value="0"> 
				<input type="hidden" id="tipo" name="tipo" value="0">
				<input type="hidden" id="guardar" name="guardar" value="0">
				<input type="hidden" id="actualizar" name="actualizar" value="0">
					<a class="ui-link-inherit" href="#" onclick="document.forms[`abrir'.$row['id'].'`].submit();">
						<p><b>Nº Revisión: </b>'.$row['n_revision'].'<b style="padding-left: 15px;">Tipo: </b>'.$txtTipoRev.'</p>
						<p><b>Fecha Creación: </b>'.$fc_creacion.'</p>';
							if($finalizado==0){
								echo "<p><b>Fecha Finalización: </b></p>";
							} else {
								echo "<p><b>Fecha Finalización: </b>".$fc_finalizacion."</p>";
							}
						echo '
					</a>
				</form>
			</li>';
		}
	}
	while ($row = mysqli_fetch_array($result));
} else {
}

mysqli_close($conexion);

echo '		</ul>	
        </div>
    </div>     
</div>
</body>
</html>';
?>