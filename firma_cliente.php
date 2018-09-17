<?php
require_once('sesion.php');

$id_revision = $_GET['id_revision'];
$n_revision = $_GET['n_revision'];
$id_cliente = $_GET['id_cliente'];

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <link rel="stylesheet" href="signature-pad.css">

  <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="css/ie9.css">
  <![endif]-->

  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39365077-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
</head>
<body onselectstart="return false">
<?php
echo "
			<form action='guardar_firma_cliente.php' id='registrar' method='post' name='registrar' target='_self'>
			<input type='hidden' id='ruta_firma' name='ruta_firma' value=''>
			<input type='hidden' id='n_revision' name='n_revision' value=".$n_revision.">
			<input type='hidden' id='id_cliente' name='id_cliente' value=".$id_cliente.">
			<input type='hidden' id='id_revision' name='id_revision' value=".$id_revision.">
		  </form>";
?>
  <div id="signature-pad" class="signature-pad">
    <div class="signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="signature-pad--footer">
      <div class="description">Firme Arriba</div>

      <div class="signature-pad--actions">
        <div>
          <button type="button" class="button clear" data-action="clear">Limpiar</button>
          <button type="button" class="button" data-action="change-color">Cambiar color</button>
          <button type="button" class="button" data-action="undo">Deshacer</button>

        </div>
        <div>
          <button type="button" class="button save" data-action="save-png" >Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="signature_pad.umd.js"></script>
  <script src="app.js"></script>
</body>
</html>
