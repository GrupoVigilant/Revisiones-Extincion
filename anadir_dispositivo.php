<?php
include('sesion.php');

// Añadimos el título de la página
$tituloPag = 'A&ntilde;adir Dispositivo';

// Añadimos el encabezado web
include('formato/encabezado.php');
?>

<form action="registrar_tipo.php" id="login" method="post" name="registrar" target="_self">
<div style="text-align:center;">
<table style="margin: 0 auto;" border="0" cellpadding="1" cellspacing="1" style="width:500px;">
	<tbody>
		<tr>
			<td>Nombre</td>
			<td><input name="nombre" type="text" /></td>
		</tr>
	</tbody>
</table>

<p style="text-align: center;"><input name="entrar" type="submit" value="Registrar" /></p>
</div>
</form>

<p>&nbsp;</p>
</body>
</html>