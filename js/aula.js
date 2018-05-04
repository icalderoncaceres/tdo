$(document).ready(function(){
    $(".menu").removeClass("active");
    $(".menu#menuaulaonline").addClass("active");    
    $("#menuaula").on("click",".menu-aula",function(){
        loadingAjax(true);
	$("section#centroaula").load($(this).data("vinculo"),function(){ loadingAjax(false); });
	$("section#menuaula").find("li").removeClass("active");
	$(this).parent().addClass("active");
    });
    $("section#centroaula").on("click","input#chkSinLimite",function(){
        if($(this).data("marcado")==0){
            $(this).data("marcado",1);
        }else{
            $(this).data("marcado",0);
        }
    });
    $("section#centroaula").on("click","button#btn-guardar",function(e){
	e.preventDefault();
	if(document.getElementById("cmbdescripcion").value==1){
            enviarMensaje("Seleccione","Es necesario indicar la descripcion de su grupo");
  	    return false;            
	}
	if(document.getElementById("txtnombre").value==""){
            enviarMensaje("Dato requerido","galeria/img/logos/bill-ok.png");
   	    return false;
	}
        if($("input#chkSinLimite").data("marcado")==1){
            var marcado=1;
        }else{
	    if(document.getElementById("txtFecha").value==""){
                enviarMensaje("Dato requerido","Por favor indique la fecha limite nuevo grupo");
 		return false;
            }
            var marcado=0;
        }
	var form=$("#frm-new-grupo").serialize() + "&metodo=guardarGrupo&marcado=" + marcado;
        loadingAjax(true);
	$.ajax({
	    url:"paginas/aula/fcn/f_aula.php",
	    data:form,
	    type:"POST",
	    dataType:"html",
            success:function(data){
		console.log(data);
                loadingAjax(false);
                enviarMensaje("FELICIDADES","Se creo el grupo sin problemas");
                $("section#centroaula").load("paginas/aula/p_principal.php");
        	$("#menuaula").find("li").removeClass("active");
                $("#menuaula").find("li").first().addClass("active");
            },
            error:function(){
                loadingAjax(false);
            }
	});
    });
    $("section#centroaula").on("click","button#btn-add-grupo",function(){
	 if(document.getElementById("txtCodigo").value==""){
           enviarMensaje("Dato requerido","Ingrese el código del grupo");
           $("#txtCodigo").focus();
           return false;
       }
    });
    function enviarMensaje(title,text){
        swal({
            title: title,
	    text: text,
	    imageUrl: "galeria/img/logos/bill-ok.png",
	    showConfirmButton: true
        });        
    }
    $("section#centroaula").on("click","button#btn-find-grupo",function(){
	if(document.getElementById("txtCodigo").value==""){
            enviarMensaje("Dato requerido","Ingrese el codigo a buscar");
            return false;
        }
        var form=$("#frm-find-grupo").serialize() + "&metodo=buscarGrupo";
        loadingAjax(true);
        $.ajax({
           url:"paginas/aula/fcn/f_aula.php",
           data:form,
           type:"POST",
           dataType:"json",
           success:function(data){
               loadingAjax(false);
               if(data.result=="Si"){
                   $("section#confirmacion").removeClass("hidden");
                   $("section#confirmacion span").first().text("Nombre del grupo:" + data.nombre);
                   $("#admin").text("Administrador:" + data.administrador);
		   $("section#confirmacion").data("id",data.id);
               }else if(data.result=="Adm"){
		   enviarMensaje("Administrador","tu eres el administrador del grupo, no necesitas agregarte");
	       }else if(data.result=="Usu"){
		   enviarMensaje("Ya te agregastes","Ya perteneces a este grupo, no necesitas volverte a registrar");                   
	       }else{
                   enviarMensaje("Por favor verifica","No se encontro este grupo");
               }  
           }
        });
    });
    $("section#centroaula").on("click","button#btn-cancelar",function(){
       $("section#confirmacion").addClass("hidden");
       $("input#txtCodigo").val("");
       $("input#txtCodigo").focus();
    });
    $("section#centroaula").on("click","button#btn-confirmar",function(){
       var form=$("#frm-find-grupo").serialize() + "&metodo=agregarGrupo&id=" + $("#confirmacion").data("id");
       loadingAjax(true);
       $.ajax({
          url:"paginas/aula/fcn/f_aula.php",
          data:form,
          type:"POST",
          dataType:"html",
          success:function(data){
              console.log(data);
              loadingAjax(false);              
              enviarMensaje("Bienvenido a su nuevo grupo","Se agrego al grupo recuerda notificarle al administrador");
              $("button#btn-cancelar").click();
          },
          error:function(xhr){
              loadingAjax(false);
          }
       });
    });
    $("section#centroaula").on("click","button#btn-generar",function(){
       loadingAjax(true);
       $.ajax({
          url:"paginas/aula/fcn/f_aula.php",
          data:{metodo:"generarCodigo"},
          type:"POST",
          dataType:"html",
          success:function(data){
	      if(data!="error"){
	          $("span#txt-codigo").text(data);
                  $("section#codigo").removeClass("hidden");
	          $("section#generar").addClass("hidden");
	          loadingAjax(false);
	      }else{
	          loadingAjax(false);
		  enviarMensaje("Error desconocido","Error desconocido, se reiniciara el sitio");
		  document.location.reload();
	      }
          }
       });
    });
    $("section#centroaula").on("click","button#btn-aceptar-rep",function(){
	var codigo=$("#txtCodigo").val();
	if(codigo==""){
		return false;
	}
        $.ajax({
		url:"paginas/aula/fcn/f_aula.php",
		data:{metodo:"vincularRep",codigo:codigo},
		type:"POST",
		dataType:"html",
		success:function(data){
			if(data=="Ok"){
				enviarMensaje("Correcto","Se pedira que su representado confirme antes de poder hacer seguimiento a sus experiencias educativas");
                                document.location.reload();
			}else if(data=="Igual"){
				enviarMensaje("Error","No puedes ser tu mismo representante");
			}else{
                        	enviarMensaje("Error","Verifique el valor introducido");
                        }
		}
        });
    });
    $("section#centro").on("click","a#publicar",function(e){
       e.preventDefault();
       if($("#txt-muro").val()=="" && $("img#1").attr("src")==undefined){
            swal({
		title: "VACIO",
		text: "Ingrese un texto o una imágen",
		imageUrl: "galeria/img/logos/bill-ok.png",
                timer:1500,
		showConfirmButton: true
            });
            return false;
       }else{
           var mensaje=$("textarea#txt-muro").val();
           var imagen;
           var grupos_id=$("div#principal").data("id");
           if(grupos_id===undefined){
               grupos_id="";
           }else{
               grupos_id="&grupos_id=" + grupos_id;
           }
           if($("img#1").attr("src")===undefined){
               imagen="";
           }else{
               imagen="&imagen=" + $('.image-editor').cropit('export');
           }
           var form="metodo=publicar&mensaje=" + mensaje + grupos_id + imagen;
           loadingAjax(true);
           $.ajax({
              url:"paginas/grupo/fcn/f_grupo.php",
              data:form,
              type:"POST",
              dataType:"json",
              success:function(data){
                  console.log(data);
                  if(data.result=="ok"){
                        nuevoMensaje="<div>" + data.titulo;
                        if(imagen!=""){
                            nuevoMensaje+="<div class='col-xs-12'><br></div>";
                            nuevoMensaje+="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
                            nuevoMensaje+="<img class='imagenes-muro' src='" + $('.image-editor').cropit('export') + "' align='left'/>";
                            nuevoMensaje+="<span class='text-justify t30'>" + mensaje + "</span>";
                            nuevoMensaje+="</div><div class='col-xs-12'><hr></div>";                            
                        }else{
                            nuevoMensaje+="<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
                            nuevoMensaje+="<span class='text-justify t30'>" + mensaje + "</span>";
                            nuevoMensaje+="</div><div class='col-xs-12'><hr></div>";                            
                        }
                        nuevoMensaje+="</div>"
                        $("div#lista-eventos").prepend(nuevoMensaje);
                  }
                  $("textarea#txt-muro").val("");
                  $("img#1").removeAttr("src");
                  loadingAjax(false);
              }
           });
       }
    });
   $(".subir-img-active").click(function(e){
        if($(e.target).is('i')){
            $(this).children("img").removeAttr('src');
            $(this).children("img").removeAttr("id");
            $(this).children("i").addClass('hidden');
            $(this).css("background","");
        }else{
            $(".cropit-image-input").click();
            tipo = $("#img-perfil").data("foto");
        }
   });
   $(document).on("change", ".cropit-image-input", function() {
	var file = this.files[0];
	var imageType = "image";
	if (file.type.substring(0,5) == imageType) {
		var reader = new FileReader();
		reader.onload = function(e) {
			// Create a new image.
			var img = new Image();
			// Set the img src property using the data URL.
			img.src = reader.result;
			// Add the image to the page.			
			$(".cropit-image-input").val("");
			$('#cropper').modal("show");
			if(tipo=="por"){		
				$('#usr-reg-title').html("Edita tu foto de portada");
				$("#save-foto").addClass("save-portada");
				$(".cropit-image-preview").addClass("preview-portada");
				$('.image-editor').cropit('previewSize',{width:1130,height:300});	
				$(".modal-dialog").css("width","1350px");						
			}else{
				$('#usr-reg-title').html("Edita tu foto de perfil");
				$("cropit-image-preview").removeClass("preview-portada");
				$(".modal-dialog").css("width","600px");
				$('#save-foto').addClass("save-perfil");
				$('.image-editor').cropit('previewSize',{width:400,height:400 });
			}
		};
		reader.readAsDataURL(file);
	} else {
		SweetError("Archivo no soportado.");
	}		
    });    
    $("section#centro").on("click","a.publicar-comentario",function(){
        var elObjeto=$(this);
        var mensaje=elObjeto.parent().parent().find("textarea").first().val();
        var eventos_id=elObjeto.data("id");
        if(mensaje!=""){
            loadingAjax(true);
            $.ajax({
               url:"paginas/grupo/fcn/f_grupo.php",
               data:{metodo:"publicarComentario",mensaje:mensaje,eventos_id:eventos_id},
               type:"POST",
               dataType:"json",
               success:function(data){
                   console.log(data);
                   if(data.result=="ok"){
                        nuevoMensaje="<div class='col-xs-12'><a href='perfil.php?id=" + data.id + "'><img class='imagenes-usuario' src='" + data.foto + "' />";
                        nuevoMensaje+=" " + data.nombre + "</a> " + mensaje + "</div>";
                        $("div#comentarios-" + eventos_id).prepend(nuevoMensaje);
                   }
                   elObjeto.parent().parent().find("textarea").first().val("");
                   loadingAjax(false);
               },
               error:function(){
                   loadingAjax(false);
               }
            });
        }
    });
    $("section#centro").on("click","a#ver-mas-eventos",function(e){
       e.preventDefault();
       var pagina=parseInt($(this).attr("data-pagina"));
       var total=$(this).data("total");
       loadingAjax(true);
       $.ajax({
          url:"paginas/grupo/fcn/f_grupo.php",
          data:{metodo:"vermaseventos",pagina:pagina},
          type:"POST",
          dataType:"html",
          success:function(data){
              console.log(data);
              $("div#lista-eventos").append(data);
              if((pagina*20)>=total){                  
                  $("a#ver-mas-eventos").parent().css("display","none");
              }else{
                  $("a#ver-mas-eventos").attr("data-pagina",(pagina + 1));
              }
              loadingAjax(false);
          },
          error:function(){
              loadingAjax(false);
          }
       });
    });
    $("section#centro").on("click","a.ver-mas-comentarios",function(e){
       e.preventDefault();
       var actual=$(this);
       var pagina=parseInt(actual.attr("data-pagina"));
       var id=actual.parent().prev().attr("id").substr(12);
       var total=actual.parent().prev().data("total");
       $.ajax({
          url:"paginas/grupo/fcn/f_grupo.php",
          data:{metodo:"vermascomentarios",id:id,pagina:pagina},
          type:"POST",
          dataType:"html",
          success:function(data){
              console.log(data);
              $("div#comentarios-" + id).append(data);
              if((pagina*13)>=total){                  
                  actual.parent().css("display","none");
              }else{
                  actual.attr("data-pagina",(pagina + 1));
              }
          }
       });
    });
    $("section#centro").on("click","i.calificar-evento",function(data){
       var actual=$(this);
       var calificacion=0;
       var accion="";
       if(actual.hasClass("red")){
           actual.removeClass("red");
           accion="quitar";
       }else{
           actual.parent().find("i.calificar-evento").removeClass("red");
           actual.addClass("red");
           accion="poner";
       }
       if(actual.hasClass("fa-thumbs-up")){
           calificacion=1;
       }else{
           calificacion=-1;
       }
       var nuevo=actual.parent().data("nuevo");
       var id=actual.parent().data("id");
       $.ajax({
           url:"paginas/grupo/fcn/f_grupo.php",
           data:{metodo:"calificarevento",calificacion:calificacion,nuevo:nuevo,id:id,accion:accion},
           type:"POST",
           dataType:"html",
           success:function(data){
               console.log(data);
           }
       });
    });    
});