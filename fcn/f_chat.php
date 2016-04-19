<?php
    if(!isset($_SESSION))
	session_start();
	if(isset($_SESSION["id"])){
            include "chat.php";
	}else{
    ?>
    <br>
    <div class="conte1 pad5">
  	<form id="usr-log-form" name="usr-log-form" action="fcn/f_usuarios.php" method="POST">
            <br><br>
            <hr>
            <center><span style="padding: 12px;">Inicia Sessi&oacute;n &nbsp;<i class="glyphicon glyphicon-user"></i></span></center>
            <hr>
            <div class="form-group">
		<input type="text" placeholder=" Seudonimo / Correo" name="log_usuario" class=" form-input" id="log_usuario">
	    </div>
            <div class="form-group">
		<input type="password" placeholder=" Contrase&#241;a" name="log_password" class=" form-input" id="log_password">
            </div>
            <div class="form-group t12" >
		<input type="checkbox" id="recordar" name="recordar" data-valor="0"> No cerrar sesi&oacute;n</input>
            </div>
            <hr>
            <p class="text-right t10 marR5 vin-blue">
		<a>&#191;Olvidaste la Contrase&#241;a?</a>
            </p>
            <hr>
            <button id="usr-log-submit" type="submit" class="btn2 btn-primary2 btn-group-justified">Ingresar</button>
            <span class="divider"></span>
            <div style="padding: 10px;">
                <p class="t12 text-center">&#191;Eres nuevo en Mundo Educativo?</p>
                <button class="btn2 btn-default btn-group-justified alert-reg">Inscribete</button>
            </div>						
	</form>		
	<br><br>		
    </div>
    <?php
}
?>