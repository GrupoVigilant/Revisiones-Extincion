<?php
require_once('sesion.php');

// Añadimos el título de la página
$tituloPag = 'Registrar Usuario';

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
			<form action="registrar.php" id="login" method="post" name="registrar" target="_self">
			<p><b>Usuario: </b><input name="usuario" type="text" /></p>
			<p><b>Contraseña: </b><input name="contrasena" type="password" /></p>
			<p><input name="entrar" type="submit" value="Registrar" /></p>
			</form>
		</li>
	</ul>
	</div>
</body>
</html>';
?>