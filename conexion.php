<?php
$host_db = "localhost";
$user_db = "root";
$pass_db = "Vigilant765@";
$db_name = "extincion";

$conexion = new mysqli($host_db,$user_db,$pass_db, $db_name);
$conexion->set_charset("utf8");

// Función para preparar el texto a UTF-8
function prepara_texto($texto)
{
	return html_entity_decode(iconv('UTF-8', 'windows-1252',$texto));
}
?>