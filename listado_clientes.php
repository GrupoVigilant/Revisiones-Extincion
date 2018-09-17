<?php
require_once('sesion.php');
require_once('conexion.php');

// Añadimos el título de la página
$tituloPag = 'Listado de clientes';

// Añadimos el encabezado web
include('formato/encabezado.php');

if(isset($_POST['busqueda'])){
	$query = 'SELECT id, nombre_cliente, CIF, direccion, emplazamiento, tecnico FROM Clientes WHERE nombre_cliente LIKE "%'.$_POST['busqueda'].'%" OR CIF LIKE "%'.$_POST['busqueda'].'%" 
		OR direccion LIKE "%'.$_POST['busqueda'].'%" OR emplazamiento LIKE "%'.$_POST['busqueda'].'%"';
} else {
	$query = 'SELECT id, nombre_cliente, CIF, direccion, emplazamiento, tecnico FROM Clientes';
}
	 
echo '<div data-role="page" class="page_list">		
	<div data-role="header">
		<h1>Revisiones Extinción</h1>
	</div>	
	<div data-role="header">
		<h1>Usuario '.$usuario.'</h1>
	</div>
	<div data-role="header">
		<h1>'.$tituloPag.'</h1>
		<form action="listado_clientes.php" id="login" method="post" name="buscar" target="_self">
		<div id="busqueda"><p>Buscar: <input type="text" name="busqueda"></div>
		</form>
	</div>

	<div id="content" data-role="content">
        <div>
			<ul data-role="listview" data-theme="a">';


$result = mysqli_query($conexion,$query);

if ($row = mysqli_fetch_array($result)){
do{
	echo '	
			<li>
			<form action="ficha_cliente.php" id="login" method="get" name="abrir'.$row['id'].'" target="_self">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$row['id'].'"/>
			<input type="hidden" id="editar" name="editar" value="0"/>
				<a class="ui-link-inherit" href="#" onclick="document.forms[`abrir'.$row['id'].'`].submit();">
					<h1>'.$row['nombre_cliente'].'</h1>
					<p>'.$row['CIF'].'</p>
					<p>'.$row['direccion'].'</p>
					<p>'.$row['emplazamiento'].'</p>
					<p><b>Técnico Asignado: </b>'.$row['tecnico'].'</p>
				</a>
			</form>
			</li>';
}
while ($row = mysqli_fetch_array($result));
} else {
}
mysqli_close($conexion);

echo '
	<li>
		<input name="crear_cliente" type="submit" onclick="window.location.href=`registro_cliente.php`" value="Crear Cliente" />
	</li>
	<li>
		<input name="crear_usuario" type="submit" onclick="window.location.href=`registro.php`" value="Crear Usuario" />
	</li>
		</ul>	
        </div>
    </div>     
</div>
</body>
</html>';
?>
