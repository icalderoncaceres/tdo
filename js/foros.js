$(document).ready(function(){
        $(".menu").removeClass("active");
        $(".menu#menuforos").addClass("active");
	$("#ajaxContainer").on("click",".vinculos-areas",function(){
		var area=$(this).data("area");
		$.ajax({
			url:"paginas/foros/p_temas.php",
			data:{area:area},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#ajaxContainer").html(data);
				$('#editorTema').trumbowyg({
					lang : 'es'
				});
			}
		});
	});
	$("#ajaxContainer").on("click",".vinculos-temas",function(){
		var tema=$(this).data("tema");
		$.ajax({
			url:"paginas/foros/p_detalle.php",
			data:{tema:tema},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#ajaxContainer").html(data);
				$('#editor').trumbowyg({
					lang : 'es'
				});
			}
		});
	});
	$("#ajaxContainer").on("click",".cmdVolver",function(){
		$("#ajaxContainer").load($(this).data("pagina"));
	});
	$("#btnAgregar").click(function(e){
		e.preventDefault();
		var id=$("#btnNuevo").data("id");
		form=$("#form-reg-aporte").serialize() + "&metodo=guardarAporte&id=" + id;
		$.ajax({
			url:"paginas/foros/fcn/f_foros.php",
			data:form,
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$.ajax({
					url:"paginas/foros/p_detalle.php",
					data:{tema:id},
					type:"POST",
					dataType:"html",
					success:function(data){
						$("#ajaxContainer").html(data);
					}
				});
				$("#reg-aporte").modal('hide');
			}
		});
	});
	$("#btnAgregarTema").click(function(e){
		e.preventDefault();
		var id=$("#btnNuevoTema").data("id");
		form=$("#form-reg-tema").serialize() + "&metodo=guardarTema&id=" + id;
		$.ajax({
			url:"paginas/foros/fcn/f_foros.php",
			data:form,
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				$.ajax({
					url:"paginas/foros/p_temas.php",
					data:{area:id},
					type:"POST",
					dataType:"html",
					success:function(data){
						$("#ajaxContainer").html(data);
					}
				});
				$("#reg-tema").modal('hide');
			}
		});
	});
	$("#ajaxContainer").on("click","#btnBuscar",function(){
		if($("#txtBusqueda").val()!=""){
			var valor=$("#txtBusqueda").val().toUpperCase();
			var c=0;
			$(".aportes").each(function(e){
				var contenido=$(this).data("contenido").toUpperCase();
				if(contenido.indexOf(valor)==-1) {
					$(this).css("display","none");
				}else{
					c++;
					$(this).css("display","block");
				}
			});
			$("#filtradopor").text("Filtrado por " + $("#txtBusqueda").val());
		}else{
			$(".aportes").css("display","block");
			$("#filtradopor").text("");
		}
	});
	$("#ajaxContainer").on("click","#btnBuscarTema",function(){
		if($("#txtBusquedaTema").val()!=""){
			var valor=$("#txtBusquedaTema").val().toUpperCase();
			var c=0;
			$(".temas").each(function(e){
				var titulo=$(this).data("titulo").toUpperCase();				
				if(titulo.indexOf(valor)==-1) {
					$(this).css("display","none");
				}else{
					c++;
					$(this).css("display","block");
				}
			});
			$("#filtradoporTema").text("Filtrado por " + $("#txtBusquedaTema").val());
		}else{
			$(".temas").css("display","block");
			$("#filtradoporTema").text("");
		}
	});
	$("#ajaxContainer").on('click','.botonPagina',function(){
		var pagina=$(this).data("pagina");
		var id=$("#filas").data("id");
		var actual=$(this).parent();
		$.ajax({
			url:"paginas/foros/fcn/f_foros.php",
			data:{metodo:"cambiarPagina",pagina:pagina,id:id},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#filas").html(data);
				$('.pagination li').removeClass("active");
				actual.addClass("active");
				if(pagina==1){
					$('.pagination li').first().addClass("hidden");
				}else{
					$('.pagination li').first().removeClass("hidden");
				}
				if(pagina==$("#filas").data("totalpaginas")){
					$('.pagination li').last().addClass("hidden");
				}else{
					$('.pagination li').last().removeClass("hidden");
				}
				$("#filas").data("actualpagina",pagina);
			}
		});
	});
	$("#ajaxContainer").on('click','#anterior',function(){
		var pagina=$("#filas").data("actualpagina") - 1;
		var id=$("#filas").data("id");
		var actual=$('.pagination li a[data-pagina=' + pagina + ']').parent();
		$.ajax({
			url:"paginas/foros/fcn/f_foros.php",
			data:{metodo:"cambiarPagina",pagina:pagina,id:id},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#filas").html(data);
				$('.pagination li').removeClass("active");
				actual.addClass("active");
				if(pagina==1){
					$('.pagination li').first().addClass("hidden");
				}else{
					$('.pagination li').first().removeClass("hidden");
				}
				$('.pagination li').last().removeClass("hidden");
				$("#filas").data("actualpagina",pagina);
			}
		});		
	});
	$("#ajaxContainer").on('click','#siguiente',function(){
		var pagina=$("#filas").data("actualpagina") + 1;
		var id=$("#filas").data("id");
		var actual=$('.pagination li a[data-pagina=' + pagina + ']').parent();
		$.ajax({
			url:"paginas/foros/fcn/f_foros.php",
			data:{metodo:"cambiarPagina",pagina:pagina,id:id},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#filas").html(data);
				$('.pagination li').removeClass("active");
				actual.addClass("active");
				if(pagina==$("#filas").data("totalpaginas")){
					$('.pagination li').last().addClass("hidden");
				}else{
					$('.pagination li').last().removeClass("hidden");
				}
				$('.pagination li').first().removeClass("hidden");
				$("#filas").data("actualpagina",pagina);
			}
		});
	});
	$("#ajaxContainer").on('click','.calificacion',function(){
		if($("#filas").data("disponible")=="No"){
			swal({
				title: "INICIA SESION",
				text: "Inicia sesion para poder calificar este aporte, adelante es GRATIS",
				imageUrl: "galeria/img/logos/bill-ok.png",
				showConfirmButton: true
			});
			return false;
		}
		var id=$(this).data("id");
		if($(this).hasClass("red")){
			$(this).removeClass("red");			
			var accion="quitar";
		}else{
			$("#calificaciones" + id + " .calificacion").removeClass("red");
			$(this).addClass("red");
			var accion="poner";
		}
		var calificacion=$(this).data("calificacion");
		$.ajax({
			url:"paginas/foros/fcn/f_foros.php",
			data:{metodo:"calificar",id:id,accion:accion,calificacion:calificacion},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
			}
		});
	});
	$("#ajaxContainer").on("click",".recomendacion",function(){
		if($(this).data("disponible")=="No"){
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
			url:"paginas/foros/fcn/f_foros.php",
			data:{metodo:"recomendar",id:id},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				swal({
					title: "EXITO",
					text: "Se ha recomendado con exito este aporte",
					imageUrl: "galeria/img/logos/bill-ok.png",
					showConfirmButton: true
				});
			}
		});
	});
});