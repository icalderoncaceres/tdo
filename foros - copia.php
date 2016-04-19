<!DOCTYPE html>
<html lang="es">
<!-- include adicional (editor) debe ir antes del body -->
<link rel="stylesheet" href="js/htmledit/ui/trumbowyg.css">
<script type="text/javascript" src="js/htmledit/trumbowyg.min.js"></script>
<script type="text/javascript" src="js/htmledit/langs/es.min.js"></script>
<body class="pad-body">		
<div id="ajaxContainer" name="ajaxContainer"><?php include "paginas/foros/p_menu.php"?></div>
<div class="modal-backdrop fade in cargador" style="display:none"></div>
<script src="js/foros.js"></script>
<?php include "modales/m_registrar_aporte.php";?>
<?php include "modales/m_registrar_tema.php";?>
</body>
</html>