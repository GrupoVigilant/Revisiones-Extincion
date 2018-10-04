<?php
// Incluimos los datos de sesión y conexión
require_once('sesion.php');
require_once('conexion.php');
$tituloPag = 'Revisión de elementos';

// Obtenemos los parámetros GET
$id_cliente = $_GET['id_cliente'];
$id_revision = $_GET['id_revision'];
$tipo_revision = $_GET['tipo_revision'];
$n_revision = $_GET['n_revision'];

// Funciones para detectar que acción realizar
if($_GET['editar']=='1'){
	$editar=true;
	$id_editar=$_GET['id_elemento']; 
} else {
	$editar=false;
}
if (isset($_GET['guardar'])){
	if($_GET['guardar']=='1'){
		$guardar=true;
	} else {
		$guardar=false;
	}
} else {
	$guardar=false;
}
if (isset($_GET['actualizar'])){
	if($_GET['actualizar']=='1'){
		$actualizar=true;
	} else {
		$actualizar=false;
	}
} else {
	$actualizar=false;
}
if (isset($_GET['nuevo'])){
	if($_GET['nuevo']=='1'){
		$nuevo=true;
	} else {
		$nuevo=false;
	}
} else {
	$nuevo=false;
}
if (isset($_GET['borrar'])){
	if ($tipo_revision == 1 || $tipo_revision == 2 || $tipo_revision == 5){
		$queryBorrar='DELETE FROM dispositivos WHERE id='.$_GET['id_elemento'];
		if ($conexion->query($queryBorrar) === TRUE) {
			
		} else {
			
		}
	} else if ($tipo_revision == 3 || $tipo_revision == 4) {
		$queryBorrar='DELETE FROM dispositivos_cont WHERE id='.$_GET['id_elemento'];
		if ($conexion->query($queryBorrar) === TRUE) {
			
		} else {
			
		}
	}
}

// Acción a realizar para Guardar un dispositivo nuevo
if($guardar){
	if ($tipo_revision == 1 || $tipo_revision == 2 || $tipo_revision == 5){
		$f_fabricacion = $_GET['f_fabricacion'];
		$retimbrado = $_GET['retimbrado'];
		
		$fechaHoy = date('Y-m-d');
		$fechaMenos = strtotime('-5 year', strtotime($fechaHoy));
		$fechaHoy = date('Y-m-d', $fechaMenos);
		$fechaMax = strtotime('+30 day', strtotime($fechaHoy));
		$fechaMax = date('Y-m-d',$fechaMax);
		
		if ($f_fabricacion > $fechaMax) {
			$retimbrado = '';
		}
		
		$nulo = 0;
		$fecha_nulo = null;
		
		if($_GET['estado']=='DOT'){
			$estado = 'Dotación';
		}
		if($_GET['estado']=='OK'){
			$estado='Revisión';
		}
		if($_GET['estado']=='RTRC'){
			$estado='Retimbrado+Recarga';
		}
		if($_GET['estado']=='RC'){
			$estado='Recarga';
		}
		if($_GET['estado']=='NL'){
			$estado='No Localizado';
		}
		if($_GET['estado']=='NULO'){
			$estado='Nulo';
			$nulo = 1;
			$fecha_nulo = date('Y-m-d');
		} 

		$query = "INSERT INTO dispositivos (tipo_dispositivo, n_timbre, f_fabricacion, retimbrado, ubicacion, intervencion, estado, id_cliente, numero, nulo, subtipo, fecha_nulo)
		VALUES ('".$_GET['tipo_disp']."', '".$_GET['n_timbre']."', '".$f_fabricacion."', '".$retimbrado."', '".$_GET['ubicacion']."', '".$estado."',
		'".$_GET['estado']."', '".$_GET['id_cliente']."', '".$_GET['numero']."', 0, '".$_GET['subtipo']."', '".$fecha_nulo."')";
		if ($conexion->query($query) === TRUE) {
			echo 'dispositivo guardado';
		}
		else {
			echo "Error al crear el dispositivo." . $query . "<br>" . $conexion->error;
		}
	} else if ($tipo_revision == 3 || $tipo_revision == 4) {
		$query = 'INSERT INTO dispositivos_cont (nombre, cantidad, estado, subtipo, id_cliente)
		VALUES ("'.$_GET['nombre'].'", "'.$_GET['cantidad'].'", "'.$_GET['estado'].'", "'.$_GET['subtipo'].'", "'.$id_cliente.'")';
		if ($conexion->query($query) === TRUE) {
			
		}
		else {
			echo "Error al crear el dispositivo." . $query . "<br>" . $conexion->error;
		}
	}
}

// Acción a realizar para Guardar un dispositivo editado
if($actualizar){
	if ($tipo_revision == 1 || $tipo_revision == 2 || $tipo_revision == 5){
	
		$f_fabricacion = $_GET['f_fabricacion'];
		$retimbrado = $_GET['retimbrado'];

		$fechaHoy = date('Y-m-d');
		$fechaMenos = strtotime('-5 year', strtotime($fechaHoy));
		$fechaHoy = date('Y-m-d', $fechaMenos);
		$fechaMax = strtotime('+30 day', strtotime($fechaHoy));
		$fechaMax = date('Y-m-d',$fechaMax);	

		$nulo = 0;
		$fecha_nulo = null;

		if ($f_fabricacion > $fechaMax) {
			$retimbrado = '';
		}
		if($_GET['estado']=='OK'){
			$estado='Revisión';
		}
		if($_GET['estado']=='RTRC'){
			$estado='Retimbrado+Recarga';
		}
		if($_GET['estado']=='RC'){
			$estado='Recarga';
		}
		if($_GET['estado']=='NL'){
			$estado='No Localizado';
		}
		if($_GET['estado']=='NULO'){
			$estado='Nulo';
			$nulo = 1;
			$fecha_nulo = date('Y-m-d');
		} 
		$query = "UPDATE dispositivos SET tipo_dispositivo='".$_GET['tipo_disp']."', n_timbre='".$_GET['n_timbre']."', f_fabricacion='".$f_fabricacion."',
			retimbrado='".$retimbrado."', ubicacion='".$_GET['ubicacion']."', intervencion='".$estado."', estado='".$_GET['estado']."', 
			id_cliente='".$_GET['id_cliente']."', numero='".$_GET['numero']."', nulo='".$nulo."', fecha_nulo='".$fecha_nulo."' WHERE id='".$_GET['id_elemento']."'";
		if ($conexion->query($query) === TRUE) {
			
		}
		else {
			
		}
	} else if ($tipo_revision == 3 || $tipo_revision == 4) {
		$query = "UPDATE dispositivos_cont SET nombre='".$_GET['nombre']."', cantidad='".$_GET['cantidad']."', estado='".$_GET['estado']."', subtipo='".$_GET['tipo_revision']."', id_cliente='".$_GET['id_cliente']."' WHERE id='".$_GET['id_elemento']."'";
		if ($conexion->query($query) === TRUE) {
			
		}
		else { 
			
		}
	}
}

// Incluimos el encabezado de página
include('formato/encabezado.php');

// Sentencia SQL para obtener el nombre del cliente
$query = 'SELECT nombre_cliente FROM Clientes WHERE id = '.$id_cliente;
$result = mysqli_query($conexion,$query);

// Obtenemos el nombre del cliente
if ($row = mysqli_fetch_array($result)){
	do{
		$nombre_cliente = $row['nombre_cliente'];
	}
	while ($row = mysqli_fetch_array($result));
} 

// Incluimos el título de página y el nombre del cliente en el encabezado
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
	<div data-role="header">
';

// Redireccionamos a la página que le corresponde dependiendo del usuario
if($usuario=='tecnico'){
			echo '<button onclick="window.location.href=`ficha_cliente.php?id_cliente='.$id_cliente.'&editar=0`">Volver</button>';
		} else {
			echo '<button onclick="window.location.href=`ficha_tecnica.php?id_cliente='.$id_cliente.'&editar=0`">Volver</button>';
		}

echo '
	</div>
	<div id="content" data-role="content">
    <div>
	<ul data-role="listview" data-theme="a">
';

// Si la revisión es de Extintores, BIEs o Baterías de Extinción
if ($tipo_revision == 1 || $tipo_revision == 2 || $tipo_revision == 5){
	// Sentencia SQL para obtener el listado de dispositivos del cliente
	$query = 'SELECT id, tipo_dispositivo, n_timbre, f_fabricacion, retimbrado, ubicacion, intervencion, estado, numero FROM dispositivos WHERE id_cliente = '.$id_cliente.' AND subtipo = '.$tipo_revision.'  ORDER BY numero ASC'; // AND id NOT IN (SELECT id FROM dispositivos WHERE fecha_nulo < curdate())
	$result = mysqli_query($conexion,$query);	
	
	// Obtenemos los datos de los dispositivos
	if ($row = mysqli_fetch_array($result)){
		do{
			$id_dispositivo = $row['id'];
			$tipo_dispositivo = $row['tipo_dispositivo'];
			$n_timbre = $row['n_timbre'];
			$f_fabricacion = $row['f_fabricacion'];
			$fc_fabricacion = strtotime($f_fabricacion);
			$fc_fabricacion = date('d-m-Y',$fc_fabricacion);
			$retimbrado = $row['retimbrado'];
			$fretimbrado = $retimbrado;
			$retimbrado = strtotime($retimbrado);
			$retimbrado = date('d-m-Y',$retimbrado); 
			$ubicacion = $row['ubicacion'];
			$intervencion = $row['intervencion'];
			$estado = $row['estado'];
			$numero = $row['numero'];
			
			// Acción a realizar si el parámetro $editar==$true
			if($editar){
				// Acción a realizar si es el dispositivo a editar
				if($id_dispositivo==$_GET['id_elemento']){
					// Acción a realizar en caso de que sea un usuario autorizado y puede editar cualquier campo del dispositivo y eliminarlo
					if($usuario=='tecnico' || $usuario=='603' || $usuario=='602' || $usuario=='606'){
						echo '
							<li>
								<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
								<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
								<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
								<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
								<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
								<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
								<input type="hidden" id="editar" name="editar" value="0">
								<input type="hidden" id="nuevo" name="nuevo" value="0">
								<input type="hidden" id="ubicacion" name="ubicacion" value="'.$ubicacion.'">
								<input type="hidden" id="guardar" name="guardar" value="0">
								<input type="hidden" id="actualizar" name="actualizar" value="1">
									<a class="ui-link-inherit">
										<p><b>Nº: </b><input name="numero" type="text" autofocus value="'.$numero.'"></p>
										<p><b>Tipo: </b><input type="text" id="tipo_disp" name="tipo_disp" value="'.$tipo_dispositivo.'"></p>
										<p><b>Nº Timbre: </b><input type="text" id="n_timbre" name="n_timbre" value="'.$n_timbre.'"></p>
										<p><b>Fecha Fabricación: </b><input type="date" id="f_fabricacion" name="f_fabricacion" value="'.$f_fabricacion.'"></p>
										<p><b>Fecha Retimbrado: </b><input name="retimbrado" type="date" value="'.$fretimbrado.'" /></p>
										<p><b>Ubicación: </b><input name="ubicacion" type="text" value="'.$ubicacion.'" /></p>
										<p><b>Intervención: </b>
											<select name="intervencion" onChange="estado.value=this.value">
												<option value="OK">Revisi&oacute;n</option>
												<option value="RTRC">Retimbrado+Recarga</option>
												<option value="RC">Recarga</option>
												<option value="NULO">Nulo</option>
												<option value="NL">No Localizado</option>
											</select>
										</p>
										<p><input name="estado" type="text" value="OK" /></p>
										<p><input name="entrar" type="submit" value="Guardar" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();" /></p>
									</a>
								</form>
							</li>
								<form action="iniciar_revision.php" id="login" method="get" name="borrar" target="_self">
									<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
									<input type="hidden" name="borrar" value="1">
									<input type="hidden" id="editar" name="editar" value="0">
									<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
									<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
									<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
									<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
									<li><p><input type="button" onclick="document.forms[`borrar`].submit();" value="Borrar Elemento"></p></li>
								</form>
						';
					// Si no es un usuario autorizado solamente puede editar fecha de retimbrado, intervención y estado
					} else {
						echo '
						<li>
							<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
							<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
							<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
							<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
							<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
							<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
							<input type="hidden" id="editar" name="editar" value="0">
							<input type="hidden" id="nuevo" name="nuevo" value="0">
							<input type="hidden" id="numero" name="numero" value="'.$numero.'">
							<input type="hidden" id="tipo_disp" name="tipo_disp" value="'.$tipo_dispositivo.'">
							<input type="hidden" id="n_timbre" name="n_timbre" value="'.$n_timbre.'">
							<input type="hidden" id="f_fabricacion" name="f_fabricacion" value="'.$f_fabricacion.'">
							<input type="hidden" id="ubicacion" name="ubicacion" value="'.$ubicacion.'">
							<input type="hidden" id="guardar" name="guardar" value="0">
							<input type="hidden" id="actualizar" name="actualizar" value="1">
								<a class="ui-link-inherit">
									<p><b>Nº: </b>'.$numero.'
									<b style="padding-left: 15px;">Tipo: </b>'.$tipo_dispositivo.'</p>
									<p><b>Nº Timbre: </b>'.$n_timbre;
									// Si la fecha de fabricación está vacía aparece como 01-01-1970, por lo que omitimos la fecha de fabricación
									if ($fc_fabricacion!='01-01-1970'){
										echo '<b style="padding-left: 15px;">Fecha Fabricación: </b>'.$fc_fabricacion.'</p>';
									}
									echo '<p><b>Ubicación: </b>'.$ubicacion.'</p>
									<p><b>Fecha Retimbrado: </b><input name="retimbrado" autofocus type="date" value="'.date('Y-m-d').'" /></p>
									<p><b>Intervención: </b>
										<select name="intervencion" onChange="estado.value=this.value">
											<option value="OK">Revisi&oacute;n</option>
											<option value="RTRC">Retimbrado+Recarga</option>
											<option value="RC">Recarga</option>
											<option value="NULO">Nulo</option>
											<option value="NL">No Localizado</option>
										</select>
									<b style="padding-left: 15px;">Estado: </b><input name="estado" type="text" value="OK" /></p>
									<p><input name="entrar" type="submit" value="Guardar" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();" /></p>
								</a>
							</form>
						</li>';
					}
				// Acción a realizar si NO es el dispositivo a editar
				} else {
					echo '
					<li>
						<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
						<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
						<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
						<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
						<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
						<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
						<input type="hidden" id="numero" name="numero" value="'.$numero.'">
						<input type="hidden" id="tipo_disp" name="tipo_dispositivo" value="'.$tipo_dispositivo.'">
						<input type="hidden" id="n_timbre" name="n_timbre" value="'.$n_timbre.'">
						<input type="hidden" id="f_fabricacion" name="f_fabricacion" value="'.$f_fabricacion.'">
						<input type="hidden" id="ubicacion" name="ubicacion" value="'.$ubicacion.'">
						<input type="hidden" id="editar" name="editar" value="1">
						<input type="hidden" id="nuevo" name="nuevo" value="0">
						<input type="hidden" id="guardar" name="guardar" value="0">
						<input type="hidden" id="actualizar" name="actualizar" value="0">
					';
					// Permitimos la edición sólamente en el caso de que no sea NULO		
					if($estado!='NULO'){
						echo '<a class="ui-link-inherit" href="#" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();">';
					} else {
						echo '<a class="ui-link-inherit">';
					}
					
					echo '
						<p><b>Nº: </b>'.$numero.'
						<b style="padding-left: 15px;">Tipo: </b>'.$tipo_dispositivo.'</p>
						<p><b>Nº Timbre: </b>'.$n_timbre;
					// Si la fecha de fabricación está vacía aparece como 01-01-1970, por lo que omitimos la fecha de fabricación
					if ($fc_fabricacion!='01-01-1970'){
						echo '<b style="padding-left: 15px;">Fecha Fabricación: </b>'.$fc_fabricacion.'</p>';
					}
					echo '
						<p><b>Ubicación: </b>'.$ubicacion.'</p>
					';
					
					// Calculamos la fecha de retimbrado para saber si la fecha de fabricación es superior a 4 años y 11 meses
					$fechaHoy = date('Y-m-d');
					$fechaMenos = strtotime('-5 year', strtotime($fechaHoy));
					$fechaHoy = date('Y-m-d', $fechaMenos);
					$fechaMax = strtotime('+30 day', strtotime($fechaHoy));
					$fechaMax = date('Y-m-d',$fechaMax);
					
					// Si supera el rango de años y la fecha no es errónea, la mostramos
					if ($f_fabricacion < $fechaMax && $retimbrado!='01-01-1970'){
						echo '<p><b>Fecha Retimbrado: </b>'.$retimbrado.'</p>';
					} 
					
					echo '
						<p><b>Intervención: </b>'.$intervencion.'
						<b style="padding-left: 15px;">Estado: </b>'.$estado.'</p>
						</a>
						</form>
						</li>
					';
				}
			// Acción a realizar si el parámetro $editar==$false
			} else {
				echo '
					<li>
					<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
					<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
					<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
					<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
					<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
					<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
					<input type="hidden" id="numero" name="numero" value="'.$numero.'">
					<input type="hidden" id="tipo_disp" name="tipo_dispositivo" value="'.$tipo_dispositivo.'">
					<input type="hidden" id="n_timbre" name="n_timbre" value="'.$n_timbre.'">
					<input type="hidden" id="f_fabricacion" name="f_fabricacion" value="'.$f_fabricacion.'">
					<input type="hidden" id="ubicacion" name="ubicacion" value="'.$ubicacion.'">
					<input type="hidden" id="editar" name="editar" value="1">
					<input type="hidden" id="nuevo" name="nuevo" value="0">
					<input type="hidden" id="guardar" name="guardar" value="0">
					<input type="hidden" id="actualizar" name="actualizar" value="0">
				';
				// Permitimos la edición sólamente en el caso de que no sea NULO	
				if($estado!='NULO'){
					echo '<a class="ui-link-inherit" href="#" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();">';
				} else {
					echo '<a class="ui-link-inherit">';
				}
				
				echo '
					<p><b>Nº: </b>'.$numero.'
					<b style="padding-left: 15px;">Tipo: </b>'.$tipo_dispositivo.'</p>
					<p><b>Nº Timbre: </b>'.$n_timbre;
				
				// Si la fecha de fabricación está vacía aparece como 01-01-1970, por lo que omitimos la fecha de fabricación
				if ($fc_fabricacion!='01-01-1970'){
					echo '<b style="padding-left: 15px;">Fecha Fabricación: </b>'.$fc_fabricacion.'</p>';
				}
				echo '<p><b>Ubicación: </b>'.$ubicacion.'</p>';
				
				// Calculamos la fecha de retimbrado para saber si la fecha de fabricación es superior a 4 años y 11 meses
				$fechaHoy = date('Y-m-d');
				$fechaMenos = strtotime('-5 year', strtotime($fechaHoy));
				$fechaHoy = date('Y-m-d', $fechaMenos);
				$fechaMax = strtotime('+30 day', strtotime($fechaHoy));
				$fechaMax = date('Y-m-d',$fechaMax);
				
				// Si supera el rango de años y la fecha no es errónea, la mostramos
				if ($f_fabricacion < $fechaMax && $retimbrado!='01-01-1970'){
					echo '<p><b>Fecha Retimbrado: </b>'.$retimbrado.'</p>';
				} 
				
				echo '
					<p><b>Intervención: </b>'.$intervencion.'
					<b style="padding-left: 15px;">Estado: </b>'.$estado.'</p>
					</a>
					</form>
					</li>
				';
			}
		}
		while ($row = mysqli_fetch_array($result));
		mysqli_close($conexion);
	}
	
	// Acción a realizar si es un dispositivo nuevo
	if($nuevo) {
		echo '
		<li>
			<form action="iniciar_revision.php" id="login" method="get" name="anadir" target="_self">
			<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
			<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
			<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
			<input type="hidden" id="editar" name="editar" value="0">
			<input type="hidden" id="nuevo" name="nuevo" value="0">
			<input type="hidden" id="guardar" name="guardar" value="1">
			<input type="hidden" id="actualizar" name="actualizar" value="0">
			<input type="hidden" name="subtipo" value="'.$tipo_revision.'">
			<a class="ui-link-inherit">
				<p><b>Nº: </b><input name="numero" autofocus id="numero" type="text" value="" /></p>
				<p><b>Tipo: </b><input type="text" id="tipo_disp" name="tipo_disp">
				<p><b>Nº Timbre: </b><input name="n_timbre" type="text" value="" /></p>
				<p><b>Fecha Fabricación: </b><input name="f_fabricacion" type="date" value="'.date('Y-m-d').'" /></p>
				<p><b>Ubicación: </b><input name="ubicacion" type="text" value="" /></p>
				<p><b>Fecha Retimbrado: </b><input name="retimbrado" type="date" value="'.date('Y-m-d').'" /></p>
				<p><b>Intervención: </b><select name="intervencion" onChange="estado.value=this.value">
					<option value="DOT">Dotación</option>
					<option value="OK">Revisi&oacute;n</option>
					<option value="RTRC">Retimbrado+Recarga</option>
					<option value="RC">Recarga</option>
					<option value="NULO">Nulo</option>
					<option value="NL">No Localizado</option>
				</select></p>
				<p><b>Estado: </b><input name="estado" type="text" value="DOT" /></p>
				<p><input name="entrar" type="submit" value="Guardar" onclick="document.forms[`anadir`].submit();" /></p>

			</a>
			</form>
		</li>';
	// Acción a realizar si no es ni editar ni nuevo
	} else {
		echo '
		<li>
			<form action="iniciar_revision.php" id="login" method="get" name="anadir'.$id_cliente.'" target="_self">
			<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
			<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
			<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
			<input type="hidden" id="editar" name="editar" value="0">
			<input type="hidden" id="nuevo" name="nuevo" value="1">
			<input type="hidden" id="tipo" name="tipo" value="0">
			<input type="hidden" id="guardar" name="guardar" value="0">
			<input type="hidden" id="actualizar" name="actualizar" value="0">
			<input name="entrar" type="submit" autofocus value="A&ntilde;adir" />
			</form>	
		</li>
		<li>
			<form action="finalizar_revision.php" id="login" method="get" name="fin'.$id_cliente.'" target="_self">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
			<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
			<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
			<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
			<input name="entrar" type="submit" value="Finalizar" />
			</form>
		</li>';
	}

// Si la revisión es de Detección o Extinción
} else if ($tipo_revision == 3 || $tipo_revision == 4) {
	// Sentencia SQL para obtener el listado de dispositivos del cliente
	$query = 'SELECT id, nombre, cantidad, estado FROM dispositivos_cont WHERE id_cliente = '.$id_cliente.' AND subtipo = '.$tipo_revision.' ORDER BY id ASC';
	$result = mysqli_query($conexion,$query);	
	
	// Obtenemos los datos de los dispositivos
	if ($row = mysqli_fetch_array($result)){
		do{
			$id_dispositivo = $row['id'];
			$nombre = $row['nombre'];
			$cantidad = $row['cantidad'];
			$estado = $row['estado'];
			
			// Acción a realizar si el parámetro $editar==$true
			if($editar){
				// Acción a realizar si es el dispositivo a editar
				if($id_dispositivo==$_GET['id_elemento']){
					// Acción a realizar en caso de que sea un usuario autorizado y puede editar cualquier campo del dispositivo y eliminarlo
					if($usuario=='tecnico' || $usuario=='602' || $usuario='603' || $usuario='606'){
						echo '
							<li>
								<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
								<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
								<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
								<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
								<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
								<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
								<input type="hidden" id="editar" name="editar" value="0">
								<input type="hidden" id="nuevo" name="nuevo" value="0">
								<input type="hidden" id="guardar" name="guardar" value="0">
								<input type="hidden" id="actualizar" name="actualizar" value="1">
									<a class="ui-link-inherit">
										<p><b>Elemento: </b><input name="nombre" type="text" autofocus value="'.$nombre.'"></p>
										<p><b>Cantidad: </b><input type="text" id="cantidad" name="cantidad" value="'.$cantidad.'"></p>
										<p><b>Estado: </b><input type="text" id="estado" name="estado" value="'.$estado.'"></p>
										<p><input name="entrar" type="submit" value="Guardar" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();" /></p>
									</a>
								</form>
							</li>

								<form action="iniciar_revision.php" id="login" method="get" name="borrar" target="_self">
									<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
									<input type="hidden" name="borrar" value="1">
									<input type="hidden" id="editar" name="editar" value="0">
									<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
									<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
									<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
									<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
									<li><p><input type="button" onclick="document.forms[`borrar`].submit();" value="Borrar Elemento"></p></li>
								</form>
							';
					// Si no es un usuario autorizado solamente puede editar estado
					} else {
						echo '
							<li>
								<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
								<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
								<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
								<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
								<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
								<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
								<input type="hidden" id="editar" name="editar" value="0">
								<input type="hidden" id="nuevo" name="nuevo" value="0">
								<input type="hidden" id="nombre" name="nombre" value="'.$nombre.'">
								<input type="hidden" id="cantidad" name="cantidad" value="'.$cantidad.'">
								<input type="hidden" id="estado" name="estado" value="'.$estado.'">
								<input type="hidden" id="guardar" name="guardar" value="0">
								<input type="hidden" id="actualizar" name="actualizar" value="1">
								<a class="ui-link-inherit">
									<p><b>Elemento: </b>'.$nombre.'</p>
									<p><b style="padding-left: 15px;">Cantidad: </b>'.$cantidad.'</p>
									<p><b style="padding-left: 15px;">Estado: </b><input type="hidden" id="estado" name="estado" value="'.$estado.'"></p>
									<p><input name="entrar" type="submit" value="Guardar" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();" /></p>
								</a>
								</form>
							</li>
						';
					}
				
				// Acción a realizar si NO es el dispositivo a editar
				} else {
					echo '
					<li>
						<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
						<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
						<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
						<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
						<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
						<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
						<input type="hidden" id="nombre" name="nombre" value="'.$nombre.'">
						<input type="hidden" id="cantidad" name="cantidad" value="'.$cantidad.'">
						<input type="hidden" id="estado" name="estado" value="'.$estado.'">
						<input type="hidden" id="editar" name="editar" value="1">
						<input type="hidden" id="nuevo" name="nuevo" value="0">
						<input type="hidden" id="guardar" name="guardar" value="0">
						<input type="hidden" id="actualizar" name="actualizar" value="0">
						<a class="ui-link-inherit" href="#" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();">
							<p><b>Elemento: </b>'.$nombre.'</p>
							<p><b>Cantidad: </b>'.$cantidad.'</p>
							<p><b>Estado: </b>'.$estado.'</p>
						</a>
						</form>
					</li>';
				}
			
			// Acción a realizar si el parámetro $editar==$false
			} else {
				echo '
					<li>
					<form action="iniciar_revision.php" id="login" method="get" name="editar'.$id_dispositivo.'" target="_self">
					<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
					<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
					<input type="hidden" id="id_elemento" name="id_elemento" value="'.$id_dispositivo.'">
					<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
					<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
					<input type="hidden" id="nombre" name="nombre" value="'.$nombre.'">
					<input type="hidden" id="cantidad" name="cantidad" value="'.$cantidad.'">
					<input type="hidden" id="estado" name="estado" value="'.$estado.'">
					<input type="hidden" id="editar" name="editar" value="1">
					<input type="hidden" id="nuevo" name="nuevo" value="0">
					<input type="hidden" id="guardar" name="guardar" value="0">
					<input type="hidden" id="actualizar" name="actualizar" value="0">
					<a class="ui-link-inherit" href="#" onclick="document.forms[`editar'.$id_dispositivo.'`].submit();">
						<p><b>Elemento: </b>'.$nombre.'</p>
						<p><b>Cantidad: </b>'.$cantidad.'</p>
						<p><b>Estado: </b>'.$estado.'</p>
					</a>
					</form>
					</li>
				';
			}
		}
		while ($row = mysqli_fetch_array($result));
		mysqli_close($conexion);
	}
	
	// Acción a realizar si es un dispositivo nuevo
	if($nuevo) {
		echo '
		<li>
			<form action="iniciar_revision.php" id="login" method="get" name="anadir" target="_self">
			<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
			<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
			<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
			<input type="hidden" id="editar" name="editar" value="0">
			<input type="hidden" id="nuevo" name="nuevo" value="0">
			<input type="hidden" id="guardar" name="guardar" value="1">
			<input type="hidden" id="actualizar" name="actualizar" value="0">
			<input type="hidden" name="subtipo" value="'.$tipo_revision.'">
			<a class="ui-link-inherit">
				<p><b>Elemento: </b><input name="nombre" autofocus id="nombre" type="text" value="" /></p>
				<p><b>Cantidad: </b><input type="text" id="cantidad" name="cantidad">
				<p><b>Estado: </b><input name="estado" type="text" value="" /></p>
				<p><input name="entrar" type="submit" value="Guardar" onclick="document.forms[`anadir`].submit();" /></p>
			</a>
			</form>
		</li>';
	// Acción a realizar si no es ni editar ni nuevo
	} else {
		echo '
		<li>
			<form action="iniciar_revision.php" id="login" method="get" name="anadir'.$id_cliente.'" target="_self">
			<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
			<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
			<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
			<input type="hidden" id="editar" name="editar" value="0">
			<input type="hidden" id="nuevo" name="nuevo" value="1">
			<input type="hidden" id="tipo" name="tipo" value="0">
			<input type="hidden" id="guardar" name="guardar" value="0">
			<input type="hidden" id="actualizar" name="actualizar" value="0">
			<input name="entrar" type="submit" autofocus value="A&ntilde;adir" />
			</form>	
		</li>
		<li>
			<form action="finalizar_revision.php" id="login" method="get" name="fin'.$id_cliente.'" target="_self">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$id_cliente.'">
			<input type="hidden" id="id_revision" name="id_revision" value="'.$id_revision.'">
			<input type="hidden" id="n_revision" name="n_revision" value="'.$n_revision.'">
			<input type="hidden" id="tipo_revision" name="tipo_revision" value="'.$tipo_revision.'">
			<input name="entrar" type="submit" value="Finalizar" />
			</form>
		</li>';
	}
}
echo '
	</ul>
</div>
</div>
</div>
<script>
	$(window).ready(function(){
		$("html, body").animate({ scrollTop: $(document).height()});    
	});
</script>
</body>
</html>
';
?>
