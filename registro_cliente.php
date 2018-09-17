<?php
require_once('sesion.php');
// Añadimos el título de la página
$tituloPag = 'Registrar Cliente';

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
			<form action="registrar_cliente.php" id="login" method="get" name="registrar" target="_self">
			<p><b>Nombre: </b><input name="nombre" type="text" /></p>
			<p><b>CIF: </b><input name="cif" type="text" /></p>
			<p><b>Dirección: </b><input name="direccion" type="text" /></p>
			<p><b>Emplazamiento: </b><input name="emplazamiento" type="text" /></p>
			<p><input name="entrar" type="submit" value="Registrar" /></p>
			</form>
		</li>
	</ul>
	</div>
</body>
</html>';
?>