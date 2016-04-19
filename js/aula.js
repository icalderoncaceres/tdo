$(document).ready(function(){
    $(".menu").removeClass("active");
    $(".menu#menuaulaonline").addClass("active");    
    $("#menuaula").on("click",".menu-aula",function(){
	$("#centroaula").load($(this).data("vinculo"));
	$("#menuaula").find("li").removeClass("active");
	$(this).parent().addClass("active");
    });
    $("#centroaula").on("click","#chkSinLimite",function(){
        if($(this).data("marcado")==0){
            $(this).data("marcado",1);
        }else{
            $(this).data("marcado",0);
        }
    });
    $("#centroaula").on("click","button#btn-guardar",function(e){
	e.preventDefault();
	if(document.getElementById("cmbdescripcion").value==1){
            enviarMensaje("Seleccione","Es necesario indicar la descripcion de su grupo");
  	    return false;            
	}
	if(document.getElementById("txtnombre").value==""){
            enviarMensaje("Dato requerido","galeria/img/logos/bill-ok.png");
   	    return false;
	}
        if($("#chkSinLimite").data("marcado")==1){
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
                $("#centroaula").load("paginas/aula/p_principal.php");
        	$("#menuaula").find("li").removeClass("active");
                $("#menuaula").find("li").first().addClass("active");
            }
	});
    });
    $("#centroaula").on("click","button#btn-add-grupo",function(){
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
    $("#centroaula").on("click","button#btn-find-grupo",function(){
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
                   $("#confirmacion").removeClass("hidden");
                   $("#confirmacion span").first().text("Nombre del grupo:" + data.nombre);
                   $("#admin").text("Administrador:" + data.administrador);
		   $("#confirmacion").data("id",data.id);
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
    $("#centroaula").on("click","button#btn-cancelar",function(){
       $("#confirmacion").addClass("hidden");
       $("#txtCodigo").val("");
       $("#txtCodigo").focus();
    });
    $("#centroaula").on("click","button#btn-confirmar",function(){
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
              $("#btn-cancelar").click();
          }
       });
    });
    $("#centroaula").on("click","button#btn-generar",function(){
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
    $("#centroaula").on("click","button#btn-aceptar-rep",function(){
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
                        alert(data);
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
});