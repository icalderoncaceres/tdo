<?php
include_once "../clases/bd.php";
$bd=new bd();
$areas=$bd->doFullSelect("areas");
$tipos=$bd->doFullSelect("recursos_tipos");
?>
<script>
$(document).ready(function(){
	$("button#btn-aprobar").click(function(){
        areas_id=$("select#select-area").val();
		tipos_id=$("select#select-tipo").val();
		titulo=$("input#titulo").val();
		descripcion=$("input#descripcion").val();
		id=$("input#id").val();
		ruta=$("input#ruta").val();
		vinculo=$("input#vinculo").val();		
		if(areas_id=="-1"){
			alert("Es necesario que seleccione el area");
			return false;
		}
		if(tipos_id=="-1"){
			alert("Es necesario que seleccione el tipo");
			return false;
		}
		if(titulo===""){
			alert("Es necesario el titulo");
			return false;
		}
		if(descripcion===""){
			alert("Es necesaria la descripcion");
			return false;
		}
		if(ruta==="" && vinculo===""){
			alert("Es necesaria la ruta o el vinculo");
			return false;
		}
		$.ajax({
			url:"controladores/c_principal.php",
			data:{metodo:"checkRecurso",areas_id:areas_id,tipos_id:tipos_id,titulo:titulo,descripcion:descripcion,id:id,ruta:ruta,vinculo:vinculo},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				if(data==="ok"){
					alert("Exito");
				}else{
					alert("Error desconocido");
				}
				$("div#verificar-recurso").modal("hide");
			}
		});
	});
});
</script>
<div class="modal fade bs-example-modal-lg modal-conf" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" id="verificar-recurso">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " >
					<img src="galeria/mascota.png" width="50" height="51"><span id="usr-reg-title"
						class="marL15">Verificar un recurso educativo</span>
				</h3>
			</div>
			<form id="form-verificar-recurso" class="form-inline">
				<div class="modal-body marL20 marR20 ">
					<select class="form-select" id="select-area" name="select-area">
						<option value="-1" >Seleccione el &aacute;rea</option>
						<?php
							foreach($areas as $a):
								?>
								<option value="<?php echo $a["id"];?>"><?php echo $a["nombre"];?></option>
								<?php
							endforeach;
						?>
					</select>
				</div>
				<div class="modal-body marL20 marR20 ">
					<select class="form-select" id="select-tipo" name="select-tipo">
						<option value="-1">Seleccione el tipo</option>
						<?php
							foreach($tipos as $t):
								?>
								<option value="<?php echo $t["id"];?>"><?php echo $t["descripcion"];?></option>
								<?php
							endforeach;
						?>
					</select>
				</div>
				<div class="modal-body marL20 marR20 ">
					<input class="hidden" id="id" name="id" class="form-input"/>
					<input id="titulo" name="titulo" class="form-input" placeholder="Titulo del recurso" />
				</div>
				<div class="modal-body marL20 marR20 ">
					<input id="descripcion" name="descripcion" class="form-input" placeholder="Descripcion del recurso" />
				</div>
				<div class="modal-body marL20 marR20 ">
					<input id="ruta" name="ruta" class="form-input" placeholder="Ruta del recurso" />
				</div>
				<div class="modal-body marL20 marR20 ">
					<input id="vinculo" name="vinculo" class="form-input" placeholder="Vinculo del recurso" />
				</div>				
				<div class="modal-footer">
					<button class="btn btn-primary2 btn-usr-act" id="btn-aprobar">Aprobar recurso</button>
				</div>
			</form>			
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->