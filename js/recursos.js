$(document).ready(function(){
        $(".menu").removeClass("active");
        $(".menu#menurecursos").addClass("active");
        $("#recomendar-evento").data("tipo",3);
	$("#ajaxContainer").on("click",".vinculos-areas",function(){
		var area=$(this).data("area");
		$.ajax({
			url:"paginas/recursos/p_tipos.php",
			data:{area:area},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#ajaxContainer").html(data);
				$("#ajaxContainer").data("area",area);
			}
		});
	});
	$("#ajaxContainer").on("click",".tipo",function(){
		var marcado=$(this).data("marcado") * -1;
		$(this).data("marcado",marcado);
	});
	$("#ajaxContainer").on("click","button#btnContinuar",function(){
		var area=$("#ajaxContainer").data("area");
		var filtro="";
		for(var i=0;i<6;i++){
			if($("#recurso" + i).data("marcado")==1){
				filtro+=$("#recurso" + i).attr("value");
				if(i<5)
				filtro+=",";
			}
		}
		if(filtro.charAt(filtro.length - 1)==",")
		filtro=filtro.substr(0,filtro.length-1);
		$.ajax({
			url:"paginas/recursos/p_listado.php",
			data:{area:area,filtro:filtro},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#ajaxContainer").html(data);
			}
		});
	});
	$("#ajaxContainer").on("click",".vistasdescargas",function(){
		if($("#filas").data("disponible")=="No"){
			swal({
				title: "INICIA SESION",
				text: "Inicia sesion para disfrutar de este recurso, adelante es GRATIS",
				imageUrl: "galeria/img/logos/bill-ok.png",
				showConfirmButton: true
			});
			return false;
		}
		var id=$(this).data("id");
		var metodo=$(this).data("metodo");
		var ruta=$(this).data("ruta");
		var vinculo=$(this).data("vinculo");
		$.ajax({
			url:"paginas/recursos/fcn/f_recursos.php",
			data:{metodo:metodo,id:id,ruta:ruta},
			type:"POST",
			dataType:"html",
			success:function(data){
				if(metodo=="ver"){
					var total=$("#totaVisitas" + id).data("total") + 1;
					$("#totaVisitas" + id).data("total",total);
					$("#totaVisitas" + id).text(total);				
				}else{
					var total=$("#totaDescargas" + id).data("total") + 1;
					$("#totaDescargas" + id).data("total",total);
					$("#totaDescargas" + id).text(total);
				}
				if(ruta!=""){
					window.open(ruta,"_blank");
				}else{
					window.open(vinculo,"_blank");	
				}				
			}
		});
	});
	$("#ajaxContainer").on("click",".calificacion",function(){
		if($("#filas").data("disponible")=="No"){
			swal({
				title: "INICIA SESION",
				text: "Inicia sesion para poder calificar este recurso, adelante es GRATIS",
				imageUrl: "galeria/img/logos/bill-ok.png",
				showConfirmButton: true
			});
			return false;
		}
		var id=$(this).data("id");
		var calificacion=$(this).data("calificacion");
		var metodo="calificar";
		if($(this).hasClass("red")){
			$(this).removeClass("red");			
			var accion="quitar";
		}else{
			$(this).parent().find('.calificacion').removeClass("red");
			$(this).addClass("red");
			var accion="poner";
		}		
		$.ajax({
			url:"paginas/recursos/fcn/f_recursos.php",
			data:{metodo:metodo,id:id,calificacion:calificacion,accion:accion},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
			}
		});
	});
	$("#ajaxContainer").on("click",".recomendacionxx",function(){
		if($("#filas").data("disponible")=="No"){
			swal({
				title: "INICIA SESION",
				text: "Inicia sesion para poder recomendar este recurso, adelante es GRATIS",
				imageUrl: "galeria/img/logos/bill-ok.png",
				showConfirmButton: true
			});
			return false;
		}
		var id=$(this).data("id");
		$.ajax({
			url:"paginas/recursos/fcn/f_recursos.php",
			data:{metodo:"recomendar",id:id},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				swal({
					title: "EXITO",
					text: "Se ha recomendado con exito este recurso",
					imageUrl: "galeria/img/logos/bill-ok.png",
					showConfirmButton: true	
				});
			}
		});
	});
});