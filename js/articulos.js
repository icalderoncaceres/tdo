$(document).ready(function(){
        $(".menu").removeClass("active");
        $(".menu#menuarticulos").addClass("active");
	$("#ajaxContainer").on("click",".vistas",function(){		
		if($("#ajaxContainer").data("disponible")=="No"){
			swal({
				title: "INICIA SESION",
				text: "Necesitar iniciar session, adelante es GRATIS",
				imageUrl: "galeria/img/logos/bill-ok.png",
				showConfirmButton: true
			});
			return false;
		}
		window.open($(this).data("ruta"));
		var ruta=$(this).data("ruta");
		id=$(this).data("id");
		metodo=$(this).data("metodo");
		$.ajax({
			url:"paginas/articulos/fcn/f_articulos.php",
			data:{metodo:metodo,id:id},
			type:"POST",
			dataType:"html",
			success:function(data){
				var total=$("#totaVisitas" + id).data("total") + 1;
				$("#totaVisitas" + id).data("total",total);
				$("#totaVisitas" + id).text(total);
//				$("#ajaxContainer").load(ruta);
			}
		});

	});
	$("#ajaxContainer").on("click",".calificacion",function(){
		if($("#ajaxContainer").data("disponible")=="No"){
			swal({
				title: "INICIA SESION",
				text: "Inicia sesion para disfrutar de este articulo, adelante es GRATIS",
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
			accion="quitar";
		}else{
			$(this).parent().find('.calificacion').removeClass("red");
			$(this).addClass("red");
			accion="poner";
		}		
		$.ajax({
			url:"paginas/articulos/fcn/f_articulos.php",
			data:{metodo:metodo,id:id,calificacion:calificacion,accion:accion},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
			}
		});
	});
	$("#ajaxContainer").on("click",".recomendacion",function(){
		if($("#ajaxContainer").data("disponible")=="No"){
			swal({
				title: "INICIA SESION",
				text: "Inicia sesion para poder recomendar este aporte, adelante es GRATIS",
				imageUrl: "galeria/img/logos/bill-ok.png",
				showConfirmButton: true
			});
			return false;
		}
		var id=$(this).data("id");
		$.ajax({
			url:"paginas/articulos/fcn/f_articulos.php",
			data:{metodo:"recomendar",id:id},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				swal({
					title: "EXITO",
					text: "Se ha recomendado con exito este articulo",
					imageUrl: "galeria/img/logos/bill-ok.png",
					showConfirmButton: true
				});
			}
		});
	});
});