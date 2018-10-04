<?php
// Establecemos el tiempo máximo de ejecución de scripts
set_time_limit(60);

function write_log($cadena,$tipo)
{
	$usuario = $_SESSION['username'];
	$arch = fopen("./logs/milog_".date("Y-m-d").".txt", "a+"); 

	fwrite($arch, "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." - $usuario - $tipo ] ".$cadena."\n");
	fclose($arch);
}
// Añadir documentos de sesión, conexión a BBDD y composer MSWord
require_once('sesion.php');
require_once('conexion.php');
require_once('PHPWord.php'); 
require_once ('PHPWord-develop/bootstrap.php');


$tituloPag = 'Enviar Revisión';

// Incluimos los documentos de envío por email
include('class.phpmailer.php');
include('class.smtp.php');

// Recibimos los valores POST
$id_cliente = $_POST['id_cliente'];
$id_revision = $_POST['id_revision'];
$tipo_revision = $_POST['tipo_revision'];
$email = $_POST['email'];
$nombre_firma = $_POST['nombre_firma'];
$obs_extintor = $_POST['obs_extintor'];
$obs_bie = $_POST['obs_bie'];
$obs_deteccion = $_POST['obs_deteccion'];
$obs_extincion = $_POST['obs_extincion'];
$obs_bateria = $_POST['obs_bateria'];
$certificado = $_POST['certificado'];

write_log('Página Enviar Revisión - GET - id_cliente='.$id_cliente.' - id_revision='.$id_revision.' - tipo_revision='.$tipo_revision.' - email='.$email.' - nombre_firma='.$nombre_firma.' 
- obs_extintor='.$obs_extintor.' - obs_bie='.$obs_bie.' - obs_deteccion='.$obs_deteccion.' - obs_extincion='.$obs_extincion.' - obs_bateria='.$obs_bateria,'Info');

// Calculamos la fecha máxima de equipo sin retimbrar
$fechaHoy = date('Y-m-d');
$fechaMenos = strtotime('-5 year', strtotime($fechaHoy));
$fechaHoy = date('Y-m-d', $fechaMenos);
$fechaMax = strtotime('+30 day', strtotime($fechaHoy));
$fechaMax = date('Y-m-d',$fechaMax);

$queryMail = 'UPDATE clientes SET email="'.$email.'", nombre_firma="'.$nombre_firma.'" WHERE id='.$id_cliente;
$resultMail = mysqli_query($conexion,$queryMail);

if ($conexion->query($queryMail) === TRUE) {
	write_log('Página Enviar Revisión - Guardar Mail - id_cliente='.$id_cliente.' - email='.$email.' - nombre_firma='.$nombre_firma,'Info');
} else {
	write_log('Página Enviar Revisión - Guardar Mail - id_cliente='.$id_cliente.' - email='.$email.' - nombre_firma='.$nombre_firma.' - Error='.$conexion->error,'Error');
}

$PHPWord = new PHPWord();
$query = 'SELECT nombre_cliente, CIF, direccion, emplazamiento, tecnico FROM Clientes WHERE id = '.$id_cliente;
$result = mysqli_query($conexion,$query);
$queryRevision = 'SELECT n_revision FROM revisiones WHERE id = '.$id_revision;
$resultRev = mysqli_query($conexion,$queryRevision);

$ultimoId=0;
$subtipo = $tipo_revision;	
$i=0;
$pag = 1;

$mail = new PHPMailer();
$mail->SMTPDebug = 0;
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->AuthType='LOGIN';
$mail->Host = 'smtp.grupovigilant.com';
$mail->Port = 25; 
$mail->Username = 'soporte@grupovigilant.com';
$mail->Password = 'Mezmerize2';

$mail->From = 'soporte@grupovigilant.com';
$mail->FromName = prepara_texto('Dpto. Técnico');
$mail->Body = prepara_texto('Se adjuntan los archivos con el acta de revisión.');

// Acciones a realizar si la revisión es de Extintores, BIEs o Baterías de Extinción
if ($subtipo == 1 || $subtipo == 2 || $subtipo == 5){
	
	// Consulta para saber el número de páginas que tendrá el documento
	$queryPags = 'SELECT id FROM dispositivos WHERE id_cliente = '.$id_cliente.' AND subtipo = '.$subtipo.' AND id > '.$ultimoId.' ORDER BY numero ASC';
	$resultPags = mysqli_query($conexion,$queryPags);
	
	// Calculamos el número de páginas que tendrá el informe
	if ($rowPags = mysqli_fetch_array($resultPags)){
		write_log('Página '.$tituloPag.' - Ejecutando='.$queryPags,'Info');
		$pagTotales = ceil(mysqli_num_rows($resultPags)/19);
		write_log('Página '.$tituloPag.' - pagTotales='.$pagTotales,'Info');
	}
	if ($row = mysqli_fetch_array($result)){
		// Escribimos los datos del cliente
		do{
			write_log('Página '.$tituloPag.' - Ejecutando='.$query,'Info');
			$nombre_cliente = $row['nombre_cliente'];
			$cif = $row['CIF'];
			$direccion = $row['direccion'];
			$emplazamiento = $row['emplazamiento'];
			$tecnico = $row['tecnico'];
			write_log('Página '.$tituloPag.' - id_cliente='.$id_cliente.' - nombre_cliente='.$nombre_cliente.' - CIF='.$cif.' - direccion='.$direccion.'
			- emplazamiento='.$emplazamiento.' - tecnico='.$tecnico,'Info');				
		}
		while ($row = mysqli_fetch_array($result));
	} else {
		write_log('Página '.$tituloPag.' - id_cliente='.$id_cliente.' - nombre_cliente='.$nombre_cliente.' - CIF='.$cif.' - direccion='.$direccion.'
			- emplazamiento='.$emplazamiento.' - tecnico='.$tecnico.' - Error='.$conexion->error,'Error');
	}

	if ($rowRev = mysqli_fetch_array($resultRev)){
		do{
			write_log('Página '.$tituloPag.' - Ejecutando='.$queryRevision,'Info');
			$n_revision = $rowRev['n_revision'];
			write_log('Página '.$tituloPag.' - n_revision='.$n_revision,'Info');
		}
		while ($row = mysqli_fetch_array($resultRev));
	} else {
		write_log('Página '.$tituloPag.' - n_revision='.$n_revision.' - Error='.$conexion->error,'Error');
	}
	$queryDisp1 = 'SELECT id, tipo_dispositivo, n_timbre, f_fabricacion, retimbrado, ubicacion, intervencion, estado, numero FROM dispositivos WHERE 
		id_cliente = '.$id_cliente.' AND subtipo = '.$subtipo.' AND id > '.$ultimoId.' ORDER BY numero ASC LIMIT 19';
	$resultDisp1 = mysqli_query($conexion,$queryDisp1);

	if ($rowDisp1 = mysqli_fetch_array($resultDisp1)){
		write_log('Página '.$tituloPag.' - Ejecutando='.$queryDisp1,'Info');
		do{
			$queryDisp = 'SELECT id, tipo_dispositivo, n_timbre, f_fabricacion, retimbrado, ubicacion, intervencion, estado, numero FROM dispositivos WHERE 
				id_cliente = '.$id_cliente.' AND subtipo = '.$subtipo.' AND numero >= '.$ultimoId.' ORDER BY numero ASC LIMIT 19';
			$resultDisp = mysqli_query($conexion,$queryDisp);

			if ($rowDisp = mysqli_fetch_array($resultDisp)){
				write_log('Página '.$tituloPag.' - Ejecutando='.$queryDisp,'Info');
				if($i%19==0){
					$documento = $PHPWord->loadTemplate('modelo_acta.docx');
					$documento->setValue('nombre_titular', prepara_texto($nombre_cliente));
					$documento->setValue('direccion', prepara_texto($direccion));
					$documento->setValue('emplazamiento', prepara_texto($emplazamiento));
					$documento->setValue('tecnico', prepara_texto($tecnico));
					write_log('Página '.$tituloPag.' - Documento - nombre_titular='.$nombre_cliente.' - direccion='.$direccion.' - emplazamiento='.$emplazamiento.' - tecnico='.$tecnico,'Info');

					if($subtipo==1){
						$tRevision = 'Extintor';
						$documento->setValue('observaciones', prepara_texto($obs_extintor));
						write_log('Página '.$tituloPag.' - Documento - obs_extintor='.$obs_extintor,'Info');
					} else if ($subtipo==2){
						$tRevision = 'BIE';
						$documento->setValue('observaciones', prepara_texto($obs_bie));
						write_log('Página '.$tituloPag.' - Documento - obs_bie='.$obs_bie,'Info');
					} else if ($subtipo==3){
						$tRevision = 'Detección';
						$documento->setValue('observaciones', prepara_texto($obs_deteccion));
						write_log('Página '.$tituloPag.' - Documento - obs_bie='.$obs_bie,'Info');
					} else if ($subtipo==4){
						$tRevision = 'Extinción';
						$documento->setValue('observaciones', prepara_texto($obs_extincion));
						write_log('Página '.$tituloPag.' - Documento - obs_extincion='.$obs_extincion,'Info');
					} else if ($subtipo==5){
						$tRevision = 'Batería Extinción';
						$documento->setValue('observaciones', prepara_texto($obs_bateria));
						write_log('Página '.$tituloPag.' - Documento - obs_bateria='.$obs_bateria,'Info');
					} else {
						$tRevision = '';
						$documento->setValue('tipo_revision', prepara_texto($tRevision));
						write_log('Página '.$tituloPag.' - Documento - Tipo Revisión Incorrecto','Warn');
					}
					do{
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Escribiendo Valores','Info');
						$numero = $rowDisp['numero'];
						$i++;
						$ultimoId = $numero;
						$documento->setValue('campo'.$i.'1', prepara_texto($numero)); 
						$tipo_disp = $rowDisp['tipo_dispositivo'];
						$documento->setValue('campo'.$i.'2', prepara_texto($tipo_disp));
						$n_timbre = $rowDisp['n_timbre'];
						$documento->setValue('campo'.$i.'3', prepara_texto($n_timbre));
						$f_fabricacion = $rowDisp['f_fabricacion'];
						if ($f_fabricacion!='0000-00-00'){
							$documento->setValue('campo'.$i.'4', prepara_texto(date('d/m/Y',strtotime($f_fabricacion))));
						} else {
							$documento->setValue('campo'.$i.'4', prepara_texto(''));
						}
						$retimbrado = $rowDisp['retimbrado'];
						if ($f_fabricacion > $fechaMax || $retimbrado=='0000-00-00') {
							$retimbrado = '';
							$documento->setValue('campo'.$i.'5', '');
						} else {
							$documento->setValue('campo'.$i.'5', prepara_texto(date('d/m/Y',strtotime($retimbrado))));
						}
						$ubicacion = $rowDisp['ubicacion'];
						$documento->setValue('campo'.$i.'6', prepara_texto($ubicacion));
						$intervencion = $rowDisp['intervencion'];
						$documento->setValue('campo'.$i.'7', prepara_texto($intervencion));
						$estado = $rowDisp['estado'];
						$documento->setValue('campo'.$i.'8', prepara_texto($estado));
						if ($i == mysqli_num_rows($resultDisp)){
							do {
								write_log('Página '.$tituloPag.' - Documento '.$pag.' - Escribiendo Campos en Blanco','Info');
								$i++;
								$documento->setValue('campo'.$i.'1', '');
								$documento->setValue('campo'.$i.'2', '');
								$documento->setValue('campo'.$i.'3', '');
								$documento->setValue('campo'.$i.'4', '');
								$documento->setValue('campo'.$i.'5', '');
								$documento->setValue('campo'.$i.'6', '');
								$documento->setValue('campo'.$i.'7', '');
								$documento->setValue('campo'.$i.'8', '');
							}
							while ($i < 19);
						}
					}
					while ($rowDisp = mysqli_fetch_array($resultDisp));

					$documento->setValue('tipo_revision', prepara_texto($tRevision));
					$documento->setValue('pag', prepara_texto($pag)); 
					$documento->setValue('fecha', date('d/m/y')); 
					$documento->setValue('nombre_firma', prepara_texto($nombre_firma));

					//Almacenamos el archivo
					if (mysqli_num_rows($resultDisp)>0){
						$nombreFichero = './partes/' . $n_revision . '-'.$tRevision.'-'.$pag.'.docx';
						$documento->save($nombreFichero);
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Documento Guardado','Info');
					}

					// Se sustituye la firma en el documento
					$package = new ZipArchive();

					if (!$package->open($nombreFichero)) {
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Error al abrir documento','Error');
						exit();
					}

					// Generamos la imagen de la base de datos
					$queryFirmaCliente = 'SELECT firma_cliente FROM revisiones WHERE id='.$id_revision;
					$resultFirmaCliente = mysqli_query($conexion,$queryFirmaCliente);
					if ($rowFirmaCliente = mysqli_fetch_array($resultFirmaCliente)){
						$firmaCliente = $rowFirmaCliente['firma_cliente'];
					}
					$imgDataCliente = base64_decode(substr($firmaCliente,22));

					// Path en donde se va a guardar la imagen
					$fileCliente = 'firma_cliente.png';

					// borrar primero la imagen si existía previamente
					if (file_exists($fileCliente)) { unlink($fileCliente); }

					// guarda en el fichero la imagen contenida en $imgData
					$fpCliente = fopen($fileCliente, 'w');
					fwrite($fpCliente, $imgDataCliente);
					fclose($fpCliente);

					// Generamos la imagen de la base de datos
					$queryFirmaTecnico = 'SELECT firma_tecnico FROM revisiones WHERE id='.$id_revision;
					$resultFirmaTecnico = mysqli_query($conexion,$queryFirmaTecnico);
					if ($rowFirmaTecnico = mysqli_fetch_array($resultFirmaTecnico)){
						$firmaTecnico = $rowFirmaTecnico['firma_tecnico'];
					}
					$imgDataTecnico = base64_decode(substr($firmaTecnico,22));

					// Path en donde se va a guardar la imagen
					$fileTecnico = 'firma_tecnico.png';

					// borrar primero la imagen si existía previamente
					if (file_exists($fileTecnico)) { unlink($fileTecnico); }

					// guarda en el fichero la imagen contenida en $imgData
					$fpTecnico = fopen($fileTecnico, 'w');
					fwrite($fpTecnico, $imgDataTecnico);
					fclose($fpTecnico);

					// Se sustituye la firma en la plantilla por la firma capturada
					// (comprobar que esa es la ruta de la firma cada vez que se modifique la plantilla)
					$package->deleteIndex($package->locateName('word/media/image4.png'));
					if(!$package->addFile('./firma_cliente.png', 'word/media/image4.png')){
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Error al guardar la firma del cliente','Error');
						exit();
					}
					$package->deleteIndex($package->locateName('word/media/image3.png'));
					if(!$package->addFile('./firma_tecnico.png', 'word/media/image3.png')){
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Error al guardar la firma del técnico','Error');
						exit();
					}
					$package->close();
				}
				$ultimoId++;
				$pag++;
				$i=0;

				$queryDoc = 'INSERT INTO documentos (id_revision, ruta, tipo)
				VALUES ("'.$id_revision.'", "'.$nombreFichero.'", "'.$tRevision.'")';
				write_log('Página '.$tituloPag.' - Ejecutando='.$queryDoc,'Info');
				if ($conexion->query($queryDoc) === TRUE) {
					write_log('Página '.$tituloPag.' - Guardando documento '.$nombreFichero,'Info');
				}
				else {
					write_log('Página '.$tituloPag.' - Error al guardar el documento '.$nombreFichero.' - Error='.$conexion->error,'Error');
				}				

				$mail->AddAttachment($nombreFichero);
			}
		}
		while($pag<=$pagTotales);		
	}
	//$subtipo++;
	$ultimoId=0;
	$pag=1;
} else if ($subtipo == 3 || $subtipo == 4){
	$queryPags = 'SELECT id FROM dispositivos_cont WHERE id_cliente = '.$id_cliente.' AND subtipo = '.$subtipo.' AND id > '.$ultimoId.' ORDER BY id ASC';
	$resultPags = mysqli_query($conexion,$queryPags);	

	if ($rowPags = mysqli_fetch_array($resultPags)){
		write_log('Página '.$tituloPag.' - Ejecutando='.$queryPags,'Info');
		$pagTotales = ceil(mysqli_num_rows($resultPags)/19);
		write_log('Página '.$tituloPag.' - pagTotales='.$pagTotales,'Info');
	}
	if ($row = mysqli_fetch_array($result)){
		do{
			write_log('Página '.$tituloPag.' - Ejecutando='.$query,'Info');
			$nombre_cliente = $row['nombre_cliente'];
			$cif = $row['CIF'];
			$direccion = $row['direccion'];
			$emplazamiento = $row['emplazamiento'];
			$tecnico = $row['tecnico'];
			write_log('Página '.$tituloPag.' - id_cliente='.$id_cliente.' - nombre_cliente='.$nombre_cliente.' - CIF='.$cif.' - direccion='.$direccion.'
			- emplazamiento='.$emplazamiento.' - tecnico='.$tecnico,'Info');		
		}
		while ($row = mysqli_fetch_array($result));
	} else {
		write_log('Página '.$tituloPag.' - id_cliente='.$id_cliente.' - nombre_cliente='.$nombre_cliente.' - CIF='.$cif.' - direccion='.$direccion.'
			- emplazamiento='.$emplazamiento.' - tecnico='.$tecnico.' - Error='.$conexion->error,'Error');
	}

	if ($rowRev = mysqli_fetch_array($resultRev)){
		do{
			write_log('Página '.$tituloPag.' - Ejecutando='.$queryRevision,'Info');
			$n_revision = $rowRev['n_revision'];
			write_log('Página '.$tituloPag.' - n_revision='.$n_revision,'Info');
		}
		while ($row = mysqli_fetch_array($resultRev));
	} else {
		write_log('Página '.$tituloPag.' - n_revision='.$n_revision.' - Error='.$conexion->error,'Error');
	}
	$queryDisp1 = 'SELECT id, nombre, cantidad, estado FROM dispositivos_cont WHERE 
		id_cliente = '.$id_cliente.' AND subtipo = '.$subtipo.' AND id > '.$ultimoId.' ORDER BY id ASC LIMIT 19';
	$resultDisp1 = mysqli_query($conexion,$queryDisp1);

	if ($rowDisp1 = mysqli_fetch_array($resultDisp1)){
		do{
			$queryDisp = 'SELECT id, nombre, cantidad, estado FROM dispositivos_cont WHERE 
				id_cliente = '.$id_cliente.' AND subtipo = '.$subtipo.' AND id >= '.$ultimoId.' ORDER BY id ASC LIMIT 19';
			$resultDisp = mysqli_query($conexion,$queryDisp);

			if ($rowDisp = mysqli_fetch_array($resultDisp)){
				write_log('Página '.$tituloPag.' - Ejecutando='.$queryDisp,'Info');
				if($i%19==0){
					$documento = $PHPWord->loadTemplate('modelo_acta_cont.docx');
					$documento->setValue('nombre_titular', prepara_texto($nombre_cliente));
					$documento->setValue('direccion', prepara_texto($direccion));
					$documento->setValue('emplazamiento', prepara_texto($emplazamiento));
					$documento->setValue('tecnico', prepara_texto($tecnico));
					write_log('Página '.$tituloPag.' - Documento - nombre_titular='.$nombre_cliente.' - direccion='.$direccion.' - emplazamiento='.$emplazamiento.' - tecnico='.$tecnico,'Info');

					if($subtipo==1){
						$tRevision = 'Extintor';
						$documento->setValue('observaciones', prepara_texto($obs_extintor));
						write_log('Página '.$tituloPag.' - Documento - obs_extintor='.$obs_extintor,'Info');
					} else if ($subtipo==2){
						$tRevision = 'BIE';
						$documento->setValue('observaciones', prepara_texto($obs_bie));
						write_log('Página '.$tituloPag.' - Documento - obs_bie='.$obs_bie,'Info');
					} else if ($subtipo==3){
						$tRevision = 'Detección';
						$documento->setValue('observaciones', prepara_texto($obs_deteccion));
						write_log('Página '.$tituloPag.' - Documento - obs_bie='.$obs_bie,'Info');
					} else if ($subtipo==4){
						$tRevision = 'Extinción';
						$documento->setValue('observaciones', prepara_texto($obs_extincion));
						write_log('Página '.$tituloPag.' - Documento - obs_extincion='.$obs_extincion,'Info');
					} else if ($subtipo==5){
						$tRevision = 'Batería Extinción';
						$documento->setValue('observaciones', prepara_texto($obs_bateria));
						write_log('Página '.$tituloPag.' - Documento - obs_bateria='.$obs_bateria,'Info');
					} else {
						$tRevision = '';
						$documento->setValue('tipo_revision', prepara_texto($tRevision));
						write_log('Página '.$tituloPag.' - Documento - Tipo Revisión Incorrecto','Warn');
					}
					do{
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Escribiendo Valores','Info');
						$nombre = $rowDisp['nombre'];
						$i++;
						$ultimoId = $rowDisp['id'];
						$documento->setValue('campo'.$i.'1', prepara_texto($nombre)); 
						$cantidad = $rowDisp['cantidad'];
						$documento->setValue('campo'.$i.'2', prepara_texto($cantidad));
						$estado = $rowDisp['estado'];
						$documento->setValue('campo'.$i.'3', prepara_texto($estado));

						if ($i == mysqli_num_rows($resultDisp)){
							do {
								write_log('Página '.$tituloPag.' - Documento '.$pag.' - Escribiendo Campos en Blanco','Info');
								$i++;
								$documento->setValue('campo'.$i.'1', '');
								$documento->setValue('campo'.$i.'2', '');
								$documento->setValue('campo'.$i.'3', '');
							}
							while ($i < 19);
						}
					}
					while ($rowDisp = mysqli_fetch_array($resultDisp));

					$documento->setValue('tipo_revision', prepara_texto($tRevision));
					$documento->setValue('pag', prepara_texto($pag)); 
					$documento->setValue('fecha', date('d/m/y')); 
					$documento->setValue('nombre_firma', prepara_texto($nombre_firma));

					//Almacenamos el archivo
					if (mysqli_num_rows($resultDisp)>0){
						$nombreFichero = './partes/' . $n_revision . '-'.$tRevision.'-'.$pag.'.docx';
						$documento->save($nombreFichero);
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Documento Guardado','Info');
					}

					// Se sustituye la firma en el documento
					$package = new ZipArchive();

					if (!$package->open($nombreFichero)) {
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Error al abrir documento','Error');
						exit();
					}

					// Se sustituye la firma en la plantilla por la firma capturada
					// (comprobar que esa es la ruta de la firma cada vez que se modifique la plantilla)
					$package->deleteIndex($package->locateName('word/media/image4.png'));
					if(!$package->addFile('./firma_cliente.png', 'word/media/image4.png')){
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Error al guardar la firma del cliente','Error');
						exit();
					}
					$package->deleteIndex($package->locateName('word/media/image3.png'));
					if(!$package->addFile('./firma_tecnico.png', 'word/media/image3.png')){
						write_log('Página '.$tituloPag.' - Documento '.$pag.' - Error al guardar la firma del técnico','Error');
						exit();
					}
					$package->close();
				}
				$ultimoId++;
				$pag++;
				$i=0;

				$queryDoc = 'INSERT INTO documentos (id_revision, ruta, tipo)
				VALUES ("'.$id_revision.'", "'.$nombreFichero.'", "'.$tRevision.'")';
				if ($conexion->query($queryDoc) === TRUE) {
					write_log('Página '.$tituloPag.' - Guardando documento '.$nombreFichero,'Info');
				} else {
					write_log('Página '.$tituloPag.' - Error al guardar el documento '.$nombreFichero.' - Error='.$conexion->error,'Error');
				}				

				$mail->AddAttachment($nombreFichero);
			}
		}
		while($pag<=$pagTotales);		
	}
	//$subtipo++;
	$ultimoId=0;
	$pag=1;
}

$mail->Subject = prepara_texto('Revisión '.$n_revision);
$mail->AddAddress($email, prepara_texto($nombre_firma));
if ($certificado==1){
	write_log('Página '.$tituloPag.' - Requiere Certificado','Info');
	$mail->AddAddress('ingenieria@grupovigilant.com', prepara_texto('Jesús López'));
}
$mail->AddAddress('soporte@grupovigilant.com', prepara_texto('Dpto. Técnico'));
if(!$mail->Send()) {
	write_log('Página '.$tituloPag.' - Error al enviar Email '.$nombreFichero.' - Error='.$mail->error,'Error');
} else {	
	write_log('Página '.$tituloPag.' - Email Enviado '.$nombreFichero,'Info');
} 

$queryFin = 'UPDATE revisiones SET f_finalizacion = "'.date('Y-m-d').'", finalizado = 1 WHERE id = '.$id_revision;
if ($conexion->query($queryFin) === TRUE) {
	write_log('Página '.$tituloPag.' - Revisión Finalizada - id_revision='.$id_revision.' - n_revision='.$n_revision,'Info');
}
else {
	write_log('Página '.$tituloPag.' - Revisión Finalizada - id_revision='.$id_revision.' - n_revision='.$n_revision.' - Error='.$mail->error,'Error');
}
if ($usuario == 'tecnico'){	
	sleep(5);
	header('Location: listado_clientes.php');
} else {
	sleep(5);
	header('Location: revisiones.php');
}
?>

