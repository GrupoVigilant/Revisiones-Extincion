<?php
// Añadimos el título de la página
$tituloPag = 'Acceso';

// Añadimos el encabezado web
include('formato/encabezado.php');
?>

<div data-role="page" class="page_home" id="home" style="max-height: 250px;min-height: 250px;">	
	<div id="content" data-role="content">
		<div class="welcome">
			<h3>Revisiones Extinción</h3>
			<h4><?php echo $tituloPag ?></h4>	
		</div>
        <div class="dialog-wrapper" id="login-dlg" style="display: block;">
			<div class="dialog">
				<div class="dialog-content"> 
					<form name="formul" action="login.php" method="POST" data-ajax="false" >
					<div data-role="fieldcontain" style="width: 100%;display: block;">
						<label for="username" style="width: 100%;display: block;">Usuario</label>
						<input type="text" name="usuario" id="Usuario"  style="width: 100%;display: block;" />
					</div>
					<div data-role="fieldcontain" style="width: 100%;display: block;">
						<label for="password" style="width: 100%;display: block;">Contraseña</label>
						<input type="password" name="contrasena" id="Clave"  style="width: 100%;display: block;"/>
					</div>         
					<div class="buttonset">
						<input type="submit" name="Aceptar" value="Entrar" data-theme="a" data-inline="true" />
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	
</body>
</html>