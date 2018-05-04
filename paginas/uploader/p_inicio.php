<?php
include_once 'clases/bd.php';
$bd=new bd();
$formatos=$bd->doFullSelect("formatos");
?>
<div>
    <h2><center>Envianos un comentario o comparte un recurso</center></h2>
</div>
<div class="contenedor">
    <div class="row">
        <form role="form" id="frm-recurso" name="frm-recurso" enctype="multipart/form-data">
            <div class="form-group pad20 t18">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span>Mensaje</span></div>
                <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                    <textarea id="txt-mensaje" name="txt-mensaje" class="form-textarea" rows="2" placeholder="Comentarios,sugerencias,reclamos,dudas,etc."></textarea>
                </div>
                <div class="col-xs-12 hidden-sm"><br></div>
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span class="t18">Tipo </span></div>
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><input type="radio" id="objetivo" name="objetivo" value="1" checked> Solo comentario</input></div>
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><input type="radio" id="objetivo" name="objetivo" value="2"> Compartir un recurso</input></div>
                <div class="col-xs-12 hidden-sm"><br></div>
                <section class="t18 hidden" id="subir-recurso">
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span>Titulo</span></div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <input type="text" id="txt-titulo" name="txt-titulo" class="form-input" placeholder="Titulo del recurso educativo"></input>
                    </div>
                    <div class="col-xs-12 hidden-sm"><br></div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span>Descripci&oacute;n</span></div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <textarea class="form-textarea" id="txtdescripcion" name=txtdescripcion" rows="2" placeholder="Una clara introducci&oacute;n del recurso"></textarea>
                    </div>
                    <div class="col-xs-12 hidden-sm"><br></div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span>Dirigido a</span></div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <input type="text" id="txt-scope" name="txt-scope" class="form-input" placeholder="El p&uacute;blico a quien esta dirigido el recurso"></input>
                    </div>
                    <div class="col-xs-12 hidden-sm"><br></div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span>Formato</span></div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <select class="" id="cmb-formato" name="cmb-formato">
                            <option value="-1">Seleccione</option>
                            <?php
                                foreach($formatos as $valor):?>
                                    <option value="<?php echo $valor["id"];?>"><?php echo $valor["nombre"] . " (" . $valor["extensiones"] . ")"; ?></option>
                                <?php endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-12 hidden-sm"><br></div>                    
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span>Vinculo</span></div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><input type="text" id="txt-vinculo" name="txt-vinculo" class="form-input" placeholder="Opcional"></input></div>
                    <div class="col-xs-12 hidden-sm"><br></div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><span>Archivo</span></div>
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10"><input id="txt-file" name="txt-file" type="file"></input><span class="opacity t8">M&aacute;ximo 10 MB. Preferiblemente .zip o .rar</span></div>
                    <div class="col-xs-12"><br></div>
                </section>
                <section class="text-center">
                    <button type="submit" id="enviar" data-dismiss="modal" aria-label="Close" class="btn btn-primary2">Enviar</button>                    
                    <button class="btn btn-default" type="reset" id="limpiar" name="limpiar">Limpiar</button>
                </section>
                <div class="col-xs-12 hidden-sm"><hr></div>
		<div class="center-block text-center hidden-sm t14" style="width: 80%">
                    Red social desarrollada y administrada por
                    Sistema Calderon, V-149423580 T&aacute;chira - Venezuela <br>
                    Telefonos: (0416) 179.39.65 / (0276) 651.81.67 Email:
                    contacto@educacionenlinea.com.ve / admin@sistemacalderon.com.ve
		</div>                
            </div>
        </form>
        <div class="col-xs-12"><br></div>
    </div>
</div>