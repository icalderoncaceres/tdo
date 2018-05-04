$(document).ready(function(){
    $("li.menu").removeClass("active");
    $("li#menuforos").addClass("active");
    $("#recomendar-evento").data("tipo",2);
    $("div#ajaxContainer").on("click","div.vinculos-areas",function(){
	var area=$(this).data("area");
	$.ajax({
        	url:"paginas/foros/p_temas.php",
		data:{area:area},
		type:"POST",
		dataType:"html",
		success:function(data){
                    $("div#ajaxContainer").html(data);
//                    $('div#editorTema').trumbowyg({
//                    lang : 'es'
//                    });

		}
	});
    });
    $("div#ajaxContainer").on("click",".vinculos-temas",function(){
	var tema=$(this).data("tema");
	$.ajax({
		url:"paginas/foros/p_detalle.php",
		data:{tema:tema},
		type:"POST",
		dataType:"html",
		success:function(data){
                    $("div#ajaxContainer").html(data);
                    $('div#editor').trumbowyg({
                    lang : 'es'
                    });
		}
	});
    });
    $("div#ajaxContainer").on("click","button.cmdVolver",function(){
	$("div#ajaxContainer").load($(this).data("pagina"));
    });
    $("button#btnAgregar").click(function(e){
		e.preventDefault();
		var id=$("button#btnNuevo").data("id");
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
						$("div#ajaxContainer").html(data);
					}
                });
                $("div#reg-aporte").modal('hide');
			}
		});
    });
    $("button#btnAgregarTema").click(function(e){
		e.preventDefault();
		var id=$("button#btnNuevoTema").data("id");
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
						$("div#ajaxContainer").html(data);
					}
				});
				$("div#reg-tema").modal('hide');
			}
		});
    });
    $("div#ajaxContainer").on("click","button#btnBuscar",function(){
	if($("input#txtBusqueda").val()!=""){
		var valor=$("input#txtBusqueda").val().toUpperCase();
		var c=0;
		$("section.aportes").each(function(e){
			var contenido=$(this).data("contenido").toUpperCase();
			if(contenido.indexOf(valor)==-1) {
				$(this).css("display","none");
			}else{
				c++;
				$(this).css("display","block");
			}
		});
		$("#filtradopor").text("Filtrado por " + $("input#txtBusqueda").val());
	}else{
		$("section.aportes").css("display","block");
		$("#filtradopor").text("");
	}
    });
    $("div#ajaxContainer").on("click","button#btnBuscarTema",function(){
	if($("input#txtBusquedaTema").val()!=""){
		var valor=$("input#txtBusquedaTema").val().toUpperCase();
		var c=0;
		$("section.temas").each(function(e){
			var titulo=$(this).data("titulo").toUpperCase();				
			if(titulo.indexOf(valor)==-1) {
                		$(this).css("display","none");
			}else{
				c++;
				$(this).css("display","block");
			}
		});
		$("#filtradoporTema").text("Filtrado por " + $("input#txtBusquedaTema").val());
	}else{
		$("section.temas").css("display","block");
		$("#filtradoporTema").text("");
	}
    });
    $("div#ajaxContainer").on('click','a.botonPagina',function(){
	var pagina=$(this).data("pagina");
	var id=$("div#filas").data("id");
	var actual=$(this).parent();
	$.ajax({
		url:"paginas/foros/fcn/f_foros.php",
		data:{metodo:"cambiarPagina",pagina:pagina,id:id},
		type:"POST",
		dataType:"html",
		success:function(data){
			$("div#filas").html(data);
			$('ul.pagination li').removeClass("active");
			actual.addClass("active");
			if(pagina==1){
				$('ul.pagination li').first().addClass("hidden");
			}else{
				$('ul.pagination li').first().removeClass("hidden");
			}
			if(pagina==$("#filas").data("totalpaginas")){
				$('ul.pagination li').last().addClass("hidden");
			}else{
				$('ul.pagination li').last().removeClass("hidden");
			}
			$("div#filas").data("actualpagina",pagina);
		}
	});
    });
    $("div#ajaxContainer").on('click','li#anterior',function(){
	var pagina=$("div#filas").data("actualpagina") - 1;
	var id=$("div#filas").data("id");
	var actual=$('ul.pagination li a[data-pagina=' + pagina + ']').parent();
	$.ajax({
		url:"paginas/foros/fcn/f_foros.php",
		data:{metodo:"cambiarPagina",pagina:pagina,id:id},
		type:"POST",
		dataType:"html",
		success:function(data){
			$("div#filas").html(data);
			$('ul.pagination li').removeClass("active");
			actual.addClass("active");
			if(pagina==1){
				$('ul.pagination li').first().addClass("hidden");
			}else{
				$('ul.pagination li').first().removeClass("hidden");
			}
			$('ul.pagination li').last().removeClass("hidden");
			$("div#filas").data("actualpagina",pagina);
		}
	});		
    });
    $("div#ajaxContainer").on('click','li#siguiente',function(){
	var pagina=$("div#filas").data("actualpagina") + 1;
	var id=$("div#filas").data("id");
	var actual=$('ul.pagination li a[data-pagina=' + pagina + ']').parent();
	$.ajax({
		url:"paginas/foros/fcn/f_foros.php",
		data:{metodo:"cambiarPagina",pagina:pagina,id:id},
		type:"POST",
		dataType:"html",
		success:function(data){
			$("#filas").html(data);
			$('ul.pagination li').removeClass("active");
			actual.addClass("active");
			if(pagina==$("div#filas").data("totalpaginas")){
				$('ul.pagination li').last().addClass("hidden");
			}else{
				$('ul.pagination li').last().removeClass("hidden");
			}
			$('ul.pagination li').first().removeClass("hidden");
			$("div#filas").data("actualpagina",pagina);
		}
	});
    });
    $("div#ajaxContainer").on('click','i.calificacion',function(){
	if($("#filas").data("disponible")=="No"){
		swal({
			title: "INICIA SESION",
			text: "Inicia sesion para poder calificar este aporte, adelante es GRATIS",
			imageUrl: "galeria/img/logos/bill-ok.png",
			showConfirmButton: true
		});
		return false;
	}
	var objeto=$(this);
	var id=objeto.data("id");
	if(objeto.hasClass("red")){
		objeto.removeClass("red");			
		var accion="quitar";
	}else{
		$("div#calificaciones" + id + " .calificacion").removeClass("red");
		objeto.addClass("red");
		var accion="poner";
	}
	var calificacion=objeto.data("calificacion");
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
    $("div#ajaxContainer").on("click",".recomendacionxx",function(){
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