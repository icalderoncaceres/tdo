$(document).ready(function(){
    $("li.menu").removeClass("active");
    $("li#menuarticulos").addClass("active");
    $("#recomendar-evento").data("tipo",4);
    $("#ajaxContainer").on("click","a.vistas",function(){
    	if($("div#ajaxContainer").data("disponible")=="No"){
        	swal({
			title: "INICIA SESION",
			text: "Necesitar iniciar session, adelante es GRATIS",
			imageUrl: "galeria/img/logos/bill-ok.png",
			showConfirmButton: true
		});
		return false;
	}
	var objeto=$(this);
	window.open(objeto.data("ruta"));
	var ruta=objeto.data("ruta");
	id=objeto.data("id");
	metodo=objeto.data("metodo");
	$.ajax({
		url:"paginas/articulos/fcn/f_articulos.php",
		data:{metodo:metodo,id:id},
		type:"POST",
		dataType:"html",
		success:function(data){
			var total=$("#totaVisitas" + id).data("total") + 1;
			$("#totaVisitas" + id).data("total",total);
			$("#totaVisitas" + id).text(total);
//			$("#ajaxContainer").load(ruta);
		}
	});
    });
    $("#ajaxContainer").on("click","i.calificacion",function(){
	if($("#ajaxContainer").data("disponible")=="No"){
        	swal({
			title: "INICIA SESION",
			text: "Inicia sesion para disfrutar de este articulo, adelante es GRATIS",
			imageUrl: "galeria/img/logos/bill-ok.png",
			showConfirmButton: true
		});
		return false;
	}
	var objeto=$(this);
	var id=objeto.data("id");
	var calificacion=objeto.data("calificacion");
	var metodo="calificar";
	if(objeto.hasClass("red")){
		objeto.removeClass("red");			
		accion="quitar";
	}else{
		objeto.parent().find('.calificacion').removeClass("red");
		objeto.addClass("red");
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
    $("#ajaxContainer").on("click",".recomendacionxx",function(){
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