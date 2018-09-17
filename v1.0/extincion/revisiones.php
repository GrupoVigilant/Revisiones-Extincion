<?php
require_once('sesion.php');
require_once('conexion.php');

// Añadimos el título de la página
$tituloPag = 'Listado de clientes';

// Añadimos el encabezado web
include('formato/encabezado.php');
	 
echo '<div data-role="page" class="page_list">		
	<div data-role="header">
		<h1>Revisiones Extinción</h1>
	</div>	
	<div data-role="header">
		<h1>Usuario '.$usuario.'</h1>
	</div>
	<div data-role="header">
		<h1>'.$tituloPag.'</h1>
	</div>

	<div id="content" data-role="content">
        <div>
			<ul data-role="listview" data-theme="a">';

$query = "SELECT id, nombre_cliente, CIF, direccion, emplazamiento FROM Clientes WHERE tecnico =".$usuario;
$result = mysqli_query($conexion,$query);

if ($row = mysqli_fetch_array($result)){
do{
	echo '	
			<li>
			<form action="ficha_tecnica.php" id="login" method="get" name="abrir'.$row['id'].'" target="_self">
			<input type="hidden" id="id_cliente" name="id_cliente" value="'.$row['id'].'"/>
				<a class="ui-link-inherit" href="#" onclick="document.forms[`abrir'.$row['id'].'`].submit();">
					<h4>'.$row['nombre_cliente'].'</h4>
					<p>'.$row['CIF'].'</p>
					<p>'.$row['direccion'].'</p>
					<p>'.$row['emplazamiento'].'</p>
				</a>
			</form>
			</li>';
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