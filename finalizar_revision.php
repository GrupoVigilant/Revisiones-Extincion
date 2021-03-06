<?php
require_once('PHPWord.php');
require_once('conexion.php');

$id_cliente = $_GET['id_cliente'];
$id_revision = $_GET['id_revision'];
$n_revision = $_GET['n_revision'];
$tipo_revision = $_GET['tipo_revision'];

// Añadimos el título de la página
$tituloPag = 'Finalizar Revisi&oacute;n';

// Variables globales
$firmaClienteOk=0;
$firmaTecnicoOk=0;

$queryEmail = 'SELECT email, nombre_firma FROM clientes WHERE id='.$id_cliente;
$resultEmail = mysqli_query($conexion, $queryEmail);

// Añadimos el encabezado web
include('formato/encabezado.php');

echo '<div data-role="page" class="page_list">		
	<div data-role="header">
		<h1>Revisiones Extinción</h1>
	</div>
	<div data-role="header">
		<h1>'.$tituloPag.'</h1>
	</div>
	<div data-role="header">
		<h1>Revisión '.$n_revision.'</h1>
	</div>
	<div id="content" data-role="content">
        <div>
			<ul data-role="listview" data-theme="a">
				<li>
			';
			$query = 'SELECT firma_cliente FROM revisiones WHERE id = '.$id_revision;
			$result = mysqli_query($conexion,$query);
			echo '
			<form action="firma_cliente.php" id="login" method="get" name="registrarcli" target="_self">
				<input type="hidden" id="n_revision" name="n_revision" value='.$n_revision.'>
				<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
				<input type="hidden" id="id_revision" name="id_revision" value='.$id_revision.'>
				<a class="ui-link-inherit" href="#" onclick="document.forms[`registrarcli`].submit();">';
			if ($row = mysqli_fetch_array($result)){
				do{
					if($row['firma_cliente']!=""){
						$firmaClienteOk=1;
						echo '<p><b>Firma Cliente: </b>OK</p>';
					}else{
						$firmaClienteOk=0;
						echo "<p><b>Firma Cliente: </b>Pendiente</p>";
					}
				}
				while ($row = mysqli_fetch_array($result));
			}
			echo '
				</a>
			</form>
			</li>
			<li>
			';
			$query = 'SELECT firma_tecnico FROM revisiones WHERE id = '.$id_revision;
			$result = mysqli_query($conexion,$query);

			echo '
			<form action="firma_tecnico.php" id="login" method="get" name="registrartec" target="_self">
				<input type="hidden" id="n_revision" name="n_revision" value='.$n_revision.'>
				<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
				<input type="hidden" id="id_revision" name="id_revision" value='.$id_revision.'>
				<a class="ui-link-inherit" href="#" onclick="document.forms[`registrartec`].submit();">';
			
			if ($row = mysqli_fetch_array($result)){
				do{
					if($row['firma_tecnico']!=""){
						$firmaTecnicoOk=1;
						echo '<p><b>Firma Técnico: </b>OK</p>';
					}else{
						$firmaTecnicoOk=0;
						echo '<p><b>Firma Técnico: </b>Pendiente</p>';
					}
				}
				while ($row = mysqli_fetch_array($result));
			}
			echo '
				</a>
			</form>
			</li>
			<form action="enviar_revision.php" id="login" method="post" name="registrar" target="_self">
			<input type="hidden" id="id_revision" name="id_revision" value='.$id_revision.'>
			<input type="hidden" id="id_cliente" name="id_cliente" value='.$id_cliente.'>
			<input type="hidden" id="tipo_revision" name="tipo_revision" value='.$tipo_revision.'>
			<li>
			<p>&nbsp;</p>
			<p><b>¿Requiere Certificado?</b></p>
			<select name="certificado">
				<option value="0">No</option>
				<option value="1">Sí</option>
			</select>
			<p>&nbsp;</p>
				';
				if ($rowEmail = mysqli_fetch_array($resultEmail)){
					do{
						echo '<p><b>Email: </b><input name="email" type="text" value="'.$rowEmail['email'].'" /></p>
						<p><b>Nombre Responsable: </b><input name="nombre_firma" type="text" value="'.$rowEmail['nombre_firma'].'" />';
					}
					while ($rowEmail = mysqli_fetch_array($result));
				} else {
					echo '<p><b>Email: </b><input name="email" type="text" value="" /></p>
					<p><b>Nombre Responsable: </b><input name="nombre_firma" type="text" value="" />';
				}
				echo '
				<p><b>Observaciones Extintores: </b><textarea rows="3" cols="30" wrap="soft" name="obs_extintor"></textarea></p>
				<p><b>Observaciones BIEs: </b><textarea rows="3" cols="30" wrap="soft" name="obs_bie"></textarea></p>
				<p><b>Observaciones Detección: </b><textarea rows="3" cols="30" wrap="soft" name="obs_deteccion"></textarea></p>
				<p><b>Observaciones Extinción: </b><textarea rows="3" cols="30" wrap="soft" name="obs_extincion"></textarea></p>
				<p><b>Observaciones Batería: </b><textarea rows="3" cols="30" wrap="soft" name="obs_bateria"></textarea></p>';
				if ($firmaClienteOk==1 && $firmaTecnicoOk==1){
					echo '<p><input name="entrar" type="submit" value="Guardar y Enviar" /></p>';
				}
			echo '</a></li>
			</form>
		</ul>
		</div>
	</div>
</div>
</body>
</html>';
mysqli_close($conexion);
?>





