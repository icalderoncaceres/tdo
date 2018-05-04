$(document).ready(function(){
   $(".menu").removeClass("active");
   $("#menuaulaonline").addClass("active");
   /*
   $('div#editor').trumbowyg({
   lang : 'es'
   });
   */
   $("div#principal").on("click",".pesta",function(e){
      $(".pesta").removeClass("active");
      $(this).addClass("active");
      switch($(this).attr("id")){
          case "pesta1":
              $("div#actividades").removeClass("hidden");
              $("div#muro").addClass("hidden");
              $("div#miembros").addClass("hidden");              
              $("div#entradas").addClass("hidden");
              break;
          case "pesta2":
              $("div#actividades").addClass("hidden");
              $("div#muro").removeClass("hidden");
              $("div#miembros").addClass("hidden");              
              $("div#entradas").addClass("hidden");
              break;
          case "pesta3":
              $("div#actividades").addClass("hidden");
              $("div#muro").addClass("hidden");
              $("div#miembros").removeClass("hidden");              
              $("div#entradas").addClass("hidden");
              break;
          case "pesta4":
              $("div#actividades").addClass("hidden");
              $("div#muro").addClass("hidden");
              $("div#miembros").addClass("hidden");              
              $("div#entradas").removeClass("hidden");
              break;
      } 
   });
   $("button#btn-guardar-entrada").click(function(){
      if($("div#add-entrada").find("input#e_titulo").val()==""){
            swal({
		title: "TITULO REQUERIDO",
		text: "Introduce el titulo",
		imageUrl: "galeria/img/logos/bill-ok.png",
		showConfirmButton: true
            });
            $("input#e_titulo").focus();
            return false;
      }
      if($("div#add-entrada").find("textarea#e_descripcion").val()==""){
            swal({
		title: "DESCRIPCIÓN REQUERIDA",
		text: "Introduce la descripción",
		imageUrl: "galeria/img/logos/bill-ok.png",
		showConfirmButton: true
            });
            $("div#add-entrada").find("textarea#e_descripcion").focus();
            return false;
      }      
      if(archivos.length>0){
            var form_data=new FormData;
            var tmp_file=new Image(10,10);
            tmp_file.src="uploads/items/tmp-tdo.jpg";
            var c=-1;
            for(i=0;i<archivos.length;i++){
                if(archivos[i]!==undefined){
                    c++;
                    form_data.append("file" + c,archivos[i]);                    
                }
            }
      }
      //var capitulos="Titulo pruebaI,.,.FVinculo de pruebaI,.,.FIcono de pruebaF,.,.ITitulo prueba2I,.,.FVinculo de prueba2I,.,.FIcono de prueba2";
      var capitulos="";
      $(".items").each(function(e){
          var actual=$(this);
          capitulos+=actual.find("span").first().text()+"I,.,.F";
          capitulos+=actual.find("i").first().attr("class") + "I,.,.F";
          capitulos+=$(this).attr("data-posicion") + "I,.,.F";
          vinculo_item=actual.find("span").first().next().text();
          vinculo_item=vinculo_item.toLowerCase();
          if(vinculo_item!=""){
                if(vinculo_item.substr(0,4)==="http"){
                    capitulos+=vinculo_item+"I,.,.F";
                }else{
                    capitulos+="http://" + vinculo_item+"I,.,.F";
                }
          }else{
                capitulos+="Sin VinculoI,.,.F";
          }
          capitulos+=$(this).attr("data-bandera") + "I,.,.F";
          capitulos+="F,.,.I";
      });
      if(capitulos!="")
      capitulos=capitulos.substr(0,capitulos.length - 6);
      if($("img#1").attr("src")!=undefined){
          imagen="&imagen=" + $('.image-editor').cropit('export');
      }else{
          imagen="";
      }
      form=$("div#add-entrada").find("#frm-entrada").serialize() + "&metodo=guardarEntrada&id=" + $("div#add-entrada").data("id");
      form+="&e_color=" + $("div#add-entrada").find("input#e_color").val()+"&capitulos=" + capitulos + imagen;
      $("#1").data("pru",$('.image-editor').cropit('export'));
      loadingAjax(true);
      $.ajax({
         url:"paginas/grupo/fcn/f_grupo.php",
         data:form,
         type:"POST",
         dataType:"json",
         success:function(data){
             console.log(data);
             if(data.result==="error"){
                 loadingAjax(false);
                 SweetError("Error");
                 return false;
             }
             if(form_data!==undefined){
                var ids="ids0=" + data.ids[0];
                for(i=1;i<data.ids.length;i++){
                    ids=ids + "&ids" + i + "=" + data.ids[i];
                }       
                $.ajax({
                   url:"paginas/grupo/fcn/f_uploader_files.php?" + ids,
                   cache: false,
                   contentType: false,
                   processData: false,
                   data:form_data,
                   type:"POST",
                   dataType:"html",
                   success:function(data){
                       form_data="";
                       console.log(data);
                       loadingAjax(false);
                       swal({
                          title: "MUY BIEN",
                          text: "Guardada la entrada con éxito",
                          imageUrl: "galeria/img/logos/bill-ok.png",
                          timer:100,
                          showConfirmButton: true
                          },function(){
                              document.location.reload();       
                          });
                   },
                   error:function(xhr){
                       loadingAjax(false);
                       SweetError(xhr);
                   }
                });
             }else{
                loadingAjax(false);
                swal({
                    title: "MUY BIEN",
                    text: "Guardada la entrada con éxito",
                    imageUrl: "galeria/img/logos/bill-ok.png",
                    timer:100,
                    showConfirmButton: true
                },function(){
                        document.location.reload();       
                });                
             }
         }
      });
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
    $("div#principal").on("click","i.arriba",function(e){
        if($(this).attr("data-activo")!="no"){
            var id=$(this).data("id");
            var id_grupo=$("div#principal").data("id");
            var posicion=$(this).attr("data-posicion");
            var actual=$("div#item" + posicion);
            posicion=parseInt(posicion);
            loadingAjax(true);
            $.ajax({
               url:"paginas/grupo/fcn/f_grupo.php",
               data:{metodo:"cambiarPosicion",id:id,id_grupo:id_grupo,posicion:posicion,direccion:"arriba"},
               type:"POST",
               dataType:"html",
               success:function(data){
                    actual.insertBefore($("#item" + (posicion-1)));
                    $("div#item" + (posicion)).find("i").attr("data-posicion",posicion-1);
                    $("div#item" + (posicion-1)).find("i").attr("data-posicion",posicion);
                    if($("div#item" + (posicion-1)).find("i.arriba").first().attr("data-activo")=="no"){
                        $("div#item" + (posicion)).find("i.arriba").first().attr("data-activo","no");
                        $("div#item" + (posicion-1)).find("i.arriba").first().attr("data-activo","");
                    }
                    if($("div#item" + (posicion)).find("i.abajo").first().attr("data-activo")=="no"){
                        $("div#item" + (posicion-1)).find("i.abajo").first().attr("data-activo","no");
                        $("div#item" + (posicion)).find("i.abajo").first().attr("data-activo","");
                    }
                    $("div#item" + posicion).attr("id","itemauxiliar");
                    $("div#item" + (posicion-1)).attr("id","item" + posicion);
                    $("div#itemauxiliar").attr("id","item" + (posicion-1));
                    loadingAjax(false);
               }
            });
        }
    });
    $("div#principal").on("click","i.abajo",function(e){
        if($(this).attr("data-activo")!="no"){
            var id=$(this).data("id");
            var id_grupo=$("div#principal").data("id");
            var posicion=$(this).attr("data-posicion");
            var actual=$("div#item" + posicion);
            posicion=parseInt(posicion);
            loadingAjax(true);
            $.ajax({
               url:"paginas/grupo/fcn/f_grupo.php",
               data:{metodo:"cambiarPosicion",id:id,id_grupo:id_grupo,posicion:posicion,direccion:"abajo"},
               type:"POST",
               dataType:"html",
               success:function(data){
                    actual.insertAfter($("#item" + (posicion+1)));
                    $("div#item" + (posicion)).find("i").attr("data-posicion",posicion+1);
                    $("div#item" + (posicion+1)).find("i").attr("data-posicion",posicion);
                    if($("div#item" + (posicion+1)).find("i.abajo").first().attr("data-activo")=="no"){
                        $("div#item" + (posicion)).find("i.abajo").first().attr("data-activo","no");
                        $("div#item" + (posicion+1)).find("i.abajo").first().attr("data-activo","");
                    }
                    if($("div#item" + (posicion)).find("i.arriba").first().attr("data-activo")=="no"){
                        $("div#item" + (posicion+1)).find("i.arriba").first().attr("data-activo","no");
                        $("div#item" + (posicion)).find("i.arriba").first().attr("data-activo","");
                    }
                    $("div#item" + posicion).attr("id","itemauxiliar");
                    $("div#item" + (posicion+1)).attr("id","item" + posicion);
                    $("div#itemauxiliar").attr("id","item" + (posicion+1));
                    loadingAjax(false);
               }
            });
        }
    });
    $("a#publicar").click(function(e){
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
           if($("img#1").attr("src")==undefined){
               imagen="";
           }else{
               imagen="&imagen=" + $('.image-editor').cropit('export');
           }
           var form="metodo=publicar&mensaje=" + mensaje + "&grupos_id=" + grupos_id + imagen;
           loadingAjax(true);
           $.ajax({
              url:"paginas/grupo/fcn/f_grupo.php",
              data:form,
              type:"POST",
              dataType:"json",
              success:function(data){
                  console.log(data);
                  if(data.result==="ok"){
                        nuevoMensaje="<div>" + data.titulo;
                        if(imagen!==""){
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
    $("div#principal").on("click","a.publicar-comentario",function(){
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
    $("div#principal").on("click","i.activo",function(){
       var operacion=0;
       var id=$(this).data("id");
       if($(this).hasClass("red")){
           $(this).removeClass("red");
           operacion=1;
       }else{
           $(this).addClass("red");
           operacion=2;
       }       
       $.ajax({
          url:"paginas/grupo/fcn/f_grupo.php",
          data:{metodo:"cambiarStatus",operacion:operacion,id:id},
          type:"POST",
          dataType:"html",
          success:function(data){
              console.log(data);
          },
          error : function(xhr, status) {
              SweetError(status);
          }
       });
    });
    $("div#principal").on("click","a.edit-entrada",function(e){
       e.preventDefault();
       var imagen=$(this).data("imagen");
       $("div#edit-entrada").modal('show');
       $("div#edit-entrada").find("input#e_titulo").val($(this).parent().prev().find("span").text());
       $("div#edit-entrada").find("textarea#e_descripcion").val($(this).parent().prev().prev().find("span").text());
       $("div#edit-entrada").find("input#e_color").val($(this).data("color"));
       if(imagen!="")
           $("div#edit-entrada").find("div>img").attr("src",imagen);
       else
           $("div#edit-entrada").find("div>img").removeAttr("src");
       $("div#edit-entrada").attr("data-id",$(this).data("id"));
    });
    $("div#principal").on("click","i.edit-entrada2",function(e){
       e.preventDefault();
       $("div#edit-entrada2").modal('show');
       $("div#edit-entrada2").find("input#e_titulo").val($(this).parent().find("a").text());
       $("div#edit-entrada2").find("input#e_vinculo").val($(this).parent().find("a").first().attr("href"));
       $("div#edit-entrada2").attr("data-id",$(this).data("id"));
    });
    $("button#btn-edit-entrada").click(function(){
         if($("div#edit-entrada").find("input#e_titulo").val()==""){
            swal({
		title: "TITULO REQUERIDO",
		text: "Introduce el titulo",
		imageUrl: "galeria/img/logos/bill-ok.png",
		showConfirmButton: true
            });
            $("div#edit-entrada").find("input#e_titulo").focus();
            return false;
        }
        if($("div#edit-entrada").find("textarea#e_descripcion").val()===""){
            swal({
		title: "DESCRIPCIÓN REQUERIDA",
		text: "Introduce la descripción",
		imageUrl: "galeria/img/logos/bill-ok.png",
		showConfirmButton: true
            });
            $("div#edit-entrada").find("textarea#e_descripcion").focus();
            return false;
        }
        var titulo=$("div#edit-entrada").find("input#e_titulo").val();
        var descripcion=$("div#edit-entrada").find("textarea#e_descripcion").val();
        var color=$("div#edit-entrada").find("input#e_color").val();
        var id=$("div#edit-entrada").data("id");
        $.ajax({
           url:"paginas/grupo/fcn/f_grupo.php",
           data:{metodo:"editentrada",id:id,titulo:titulo,descripcion:descripcion,color:color},
           type:"POST",
           dataType:"html",
           success:function(data){
               console.log(data);
               $("div#edit-entrada").modal('hide');
           }
        });
    });
    $("button#btn-edit-entrada2").click(function(){
         if($("div#edit-entrada2").find("input#e_titulo").val()===""){
            swal({
		title: "TITULO REQUERIDO",
		text: "Introduce el titulo",
		imageUrl: "galeria/img/logos/bill-ok.png",
		showConfirmButton: true
            });
            $("div#edit-entrada2").find("input#e_titulo").focus();
            return false;
        }
        var titulo=$("div#edit-entrada2").find("input#e_titulo").val();
        var vinculo=$("div#edit-entrada2").find("input#e_vinculo").val();
        var id=$("div#edit-entrada2").data("id");
        $.ajax({
           url:"paginas/grupo/fcn/f_grupo.php",
           data:{metodo:"editentrada2",titulo:titulo,vinculo:vinculo,id:id},
           type:"POST",
           dataType:"html",
           success:function(data){
               console.log(data);
               $("div#edit-entrada2").modal('hide');
           }
        });
    });
    $("div#principal").on("click","a#ver-mas-eventos",function(e){
       e.preventDefault();
       var pagina=parseInt($(this).attr("data-pagina"));
       var id=$("div#principal").data("id");
       var total=$(this).data("total");
       loadingAjax(true);
       $.ajax({
          url:"paginas/grupo/fcn/f_grupo.php",
          data:{metodo:"vermaseventos",id:id,pagina:pagina},
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
    $("div#principal").on("click","a.ver-mas-comentarios",function(e){
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
    $("div#principal").on("click","i.calificar-evento",function(data){
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