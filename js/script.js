$(document).ready(function() {
        $(".menu").first().addClass("active");
	$("#derecha").on("click",".amigo-conectado",function(){
		var id=$(this).data("id");
                var amigo=$(this).find("span").first().text();
//                loadingAjax(true);
		$.ajax({
			url:"fcn/f_conversacion.php",
			data:{id:id,amigo:amigo},
			type:"POST",
			dataType:"html",
			success:function(data){
                            console.log(data);
                            $("#info-conversacion #ajaxConversacion").data("amigo",id);
                            $("div#ajaxConversacion").html(data);
//                            loadingAjax(false);
			}
		});
	});
        $(document).on("click","i#btn-enviar",function(){
            var actual=$("textarea#txtmensaje");
            var valor=actual.val();
            var amigo=$("div#ajaxConversacion").data("amigo");
            if(valor!=""){
                $.ajax({
                   url:"fcn/f_index.php",
                   data:{metodo:"guardarMensaje",mensaje:valor,amigo:amigo},
                   type:"POST",
                   dataType:"html",
                   success:function(data){
                       console.log(data);
                       var nuevoMensaje="<span>Tu dijistes</span><p>" + valor + "</p>";
                       $("div#ajaxConversacion").prepend(nuevoMensaje);
                       actual.val("");
                       actual.focus();
                   }
                });
           } 
        });
        $(document).on("click","i#btn-borrar",function(){
           var actual=$("textarea#txtmensaje");
           actual.val("");
           actual.focus();           
        });
	/* ============================----- Modal Registrar -----=========================*/
	var pagina=1;
	$('#usr-reg-form').formValidation({
		locale: 'es_ES',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {
			e_nombres : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			e_apellidos : {validators : {
				notEmpty : {},
				stringLength : {max : 512},
				regexp: {regexp: /^[\u00F1a-z\s]+$/i}}},
			e_telefono1 : {validators : {
				notEmpty : {},
				phone : {country:'VE'}}},
			e_regiones_id : {validators : {
				notEmpty : {}}},
			e_direccion : {validators : {
				notEmpty : {},
				stringLength : {min: 10,max : 1024}}},
			seudonimo : {validators : {
				notEmpty : {},
				stringLength : {max : 64},
				regexp: {regexp: /^[a-zA-Z0-9_.-]*$/i},
				blank: {}}},
			email : {validators : {
				notEmpty : {},
				emailAddress : {},
				blank: {}}},
			email_val : {validators : {
				identical: {field: 'email'}}},
			password : {validators : {
				notEmpty : {},
				stringLength : {min:6,max : 64}}},
			password_val : {validators : {
				identical: {field: 'password'}}}
		}
	}).on('success.form.fv', function(e) {
		e.preventDefault();				
		var form = $(e.target);
		var fv = form.data('formValidation'); 
		var foto = "&foto=galeria/img/logos/silueta-bill.png";	
		var method = "&method=new"; 		
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + foto + method, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta		           
            success: function (data) {
            	// código a ejecutar si la petición es satisfactoria;	
            	// console.log(data);
	            if (data.result === 'error') {
	            	$("#usr-reg-skip").hide();
            		$("#usr-reg-foto").hide();
            		$("section").hide();
            		keys = Object.keys(data.fields);
            		if(jQuery.inArray("e_rif",keys) !== -1 || jQuery.inArray("p_identificacion",keys) !== -1){
            			$("#usr-reg-submit").data("step",1);	
            			$("section[data-type='"+$("#type").val()+"']").show();
            		}else if(jQuery.inArray("seudonimo",keys) !== -1 || jQuery.inArray("email",keys)!== -1){
            			$("#usr-reg-submit").data("step",2);	
            			$("section[data-step='2']").show();
            		}
	            	for (var field in data.fields) { 
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	            	}
	            } else {
	            	swal({
						title: "Bienvenido", 
						text: "Seras redireccionado en 2 segundos.",
						imageUrl: "galeria/img/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){			
							location.reload();
						});
                }              
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });          
    });	
	/* ============================----- Formulario de registro -----=========================*/
	/*Codigo que pide al usuario seleccionar si sera personal natural o juridica*/
	$('.alert-reg').click(function() {
//		$("section").hide();
		$("#usr-reg-skip").hide();
		$("#usr-reg-foto").hide();
		$("#usr-reg-submit").data("step",1);		

		$("#usr-reg").modal({
			  keyboard: false,
			  backdrop: "static"
		});

		$("#usr-reg").modal('show');
		$("#usr-reg-title").html($("section[data-type='e']").data("title"));
		$("#usr-reg-submit").data("type","e");
		$("section[data-type='e']").fadeIn();
		$("#type").val("e");
		
	});
	$("#usr-reg-submit").click(function(){
		var step, section;
		step = $("#usr-reg-submit").data("step");
		switch(step){
		case 1:
			if(validarForm(step)){
				step++;
				$("#usr-reg-submit").data("step",step);		
				$("section[data-type='"+$("#usr-reg-submit").data("type")+"']").fadeOut( "slow", function() {
					$("#usr-reg-title").html($("section[data-step='"+step+"']").data("title"));
					$("section[data-step='"+step+"']").fadeIn("slow");
				});
			}
			break;
		case 2:
			$("#usr-reg-form").data('formValidation').validate();
			break;
		}
	});

	function validarForm(step){
		var type;
		 var fv = $('#usr-reg-form').data('formValidation'), // FormValidation instance
        // The current step container
		type = $("#usr-reg-submit").data("type");
		if(step === 1){
			$container = $('#usr-reg-form').find('section[data-type="' + type +'"]');
		}else{
			$container = $('#usr-reg-form').find('section[data-step="' + step +'"]');
		}
        // Validate the container
        fv.validateContainer($container);	
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        }        
        return true;
	}
	
	/* ============================----- Modal Login -----=========================*/	
	
	$('#usr-log-form').formValidation({
		locale: 'es_ES',
		excluded: ':disabled',
		framework : 'bootstrap',
		icon : {
			valid : 'glyphicon glyphicon-ok',
			invalid : 'glyphicon glyphicon-remove',
			validating : 'glyphicon glyphicon-refresh'
		},
		addOns: { i18n: {} },
		err: { container: 'tooltip' },
		fields : {			
			log_usuario : {validators : {
				notEmpty : {},
				blank: {}}},
			log_password : {validators : {
				notEmpty : {},
				blank: {}}}
		}
	}).on('success.field.fv', function(e, data) {
        if (data.fv.getInvalidFields().length > 0) {    // There is invalid field
            data.fv.disableSubmitButtons(true);            
        }
    }).on('err.form.fv', function(e,data) {
    	$(".dropdown-toggle").dropdown('toggle');
    }).on('success.form.fv', function(e) {
		e.preventDefault();
		if($("#recordar").data("valor")==1){
			var recordar="SI";
		}else{
			var recordar="NO";
		}
		var form = $(e.target);
		var fv = form.data('formValidation');
		var method = "&method=log&recordar=" + recordar;
		$.ajax({
			url: form.attr('action'), // la URL para la petición
            data: form.serialize() + method, // la información a enviar
            type: 'POST', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta            
            success: function (data) {
            	// código a ejecutar si la petición es satisfactoria;
            	// código a ejecutar si la petición es satisfactoria;
            	// console.log(data);
	            if (data.result === 'error'){
	            	for (var field in data.fields) {
	        			fv
	                    // Show the custom message
	                    .updateMessage(field, 'blank', data.fields[field])
	                    // Set the field as invalid
	                    .updateStatus(field, 'INVALID', 'blank');
	        			setTimeout(function(){
	        				$("#"+field).focus();	       			
	        			}, 10);
	            	}
	            	$(".dropdown-toggle").dropdown('toggle');
	            } else {
	            	swal({
						title: "Bienvenido", 
						text: "Seras redireccionado en 2 segundos.",
						imageUrl: "galeria/img/logos/bill-ok.png",
						timer: 2000, 
						showConfirmButton: true
						}, function(){
							location.reload();
						});
                } 
          	},// código a ejecutar si la petición falla;
            error: function (xhr, status) {
            	SweetError(status);
            }
        });
	});
	$("#usr-log-submit").prop("disabled",true);	
// Tooltip ------------------------------------
  $('[data-toggle="tooltip"]').tooltip();
//---------------------------------------------
	$("#e_pais").change(function(e){
                pais=$(this).val();
		$.ajax({
                     url:"fcn/f_index.php",
		     data:{metodo:"buscarRegiones",pais:pais},
                     type:"POST",
                     dataType:"html",
                     success:function(data){
                         console.log(data);
			 $("#regiones").html(data);
                         $("#e_regiones").removeAttr("disabled");
		     },
                     error:function(xhr,status){
                         console(status);
		     }
                });
        });
	$("#recordar").click(function(){
		if($(this).data("valor")==0){
			$(this).data("valor","1");
		}else{
			$(this).data("valor","0");
		}
	});        
});