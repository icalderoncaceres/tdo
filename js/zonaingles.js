var medio;
var iniciar;
var barra;
var progreso;	
var maximo=720;
var disco="";
var nivel="";
var id="";
var i=0;
var posicion;
var audios=[];
var textos=[];
var bucle_lab;
var audio1;
var recognition;
var recognizing = false;
var texto="";
var leccion;
var canvas;
var cxt;
var fondo;
$(document).ready(function(){	
    $("li.menu").removeClass("active");
    $("li.menu#menuingles").addClass("active");
	var discos=[1,2,3,4,1,2,3,4,1,2,3,4];
	var niveles=["1","1","1","1","2","2","2","2","3","3","3","3"];
	var medio;	
	var iniciar;
	var barra;
	var progreso;
	$("button#registrar-pago").click(function(){
		if(document.getElementById("txt-documento").value==""){
            enviarMensaje("Falta el documento","Es necesario indicar el numero de documento");
			return false;            
		}
		if(document.getElementById("txt-nombre").value==""){
            enviarMensaje("Falta el nombre","Es necesario indicar el nombre");
			return false;            
		}
		if(document.getElementById("txt-apellido").value==""){
            enviarMensaje("Falta el apellido","Es necesario indicar el apellido");
			return false;            
		}
		if(document.getElementById("txt-email").value==""){
            enviarMensaje("Falta el email","Es necesario indicar el email");
			return false;
		}
		if(document.getElementById("txt-telefono").value==""){
            enviarMensaje("Falta el telefono","Es necesario indicar el telefono");
			return false;            
		}
		if(document.getElementById("select-plan").value==""){
            enviarMensaje("Falta seleccionar el plan","Es necesario seleccionar el plan");
			return false;            
		}
		if(document.getElementById("select-forma").value==""){
            enviarMensaje("Falta seleccionar la forma de pago","Es necesario seleccionar la forma de pago");
			return false;            
		}
		if(document.getElementById("select-banco").value==""){
            enviarMensaje("Falta seleccionar el banco","Es necesario seleccionar el banco");
			return false;            
		}
		if(document.getElementById("txt-referencia").value==""){
            enviarMensaje("Falta la referencia","Es necesaria indicar la referencia");
			return false;
		}
		form=$("form#frm-reservacion").serialize() + "&metodo=reservar";
		$.ajax({
			url:"paginas/zonaingles/fcn/f_zonaingles.php",
			data:form,
			type:"POST",
			dataType:"json",
			success:function(data){
				console.log(data);
				if(data.result==="ok"){
                    swal({
						title: "Muy bien, muchas gracias por la confianza",
						text: "Confirmaremos tu pago y activaremos tu reservacion dentro de 24 horas.",
						imageUrl: "galeria/img/logos/bill-ok.png",
						showConfirmButton: true
					}, function(){			
						location.reload();
					});
				}else{
					SweetError();
				}
			},
			error:function(xhr){
				SweetError(xhr);
			}
		});
	});
	$(document).on("click","li.menu-ingles>a",function(){
		$("li.menu-ingles").removeClass("active");
		$(this).parent().addClass("active");
		pagina=$(this).parent().attr("id")
		aleatorio=Math.random()*10000;
		loadingAjax(true);
		$("section#center").load("paginas/zonaingles/p_" + pagina + ".php?aleatorio=" + aleatorio,function(){
			if(pagina==="menu-audios"){
				medio=$('#audio');
				iniciar=$('#iniciar');
				barra=$('#barra');
				progreso=$('#progreso');
			}else if(pagina==="menu-vocabulario"){
				$("ul#lista-audios").html("Cargando...");
				$.ajax({
					url:"paginas/zonaingles/fcn/f_zonaingles.php",
					data:{metodo:"getVocabulario"},
					type:"POST",
					dataType:"html",
					success:function(data){
						console.log(data);
						$("ul#lista-audios").html(data);
					}
				});				
				if($("section#center").data("status")=="0" || $("section#center").data("status")=="1")
					$("div#mensaje-vocabulario").addClass("hidden");
			}else if(pagina==="menu-laboratorio"){
				status=$("section#center").data("status");
				leccion=$("section#center").data("leccion");
				parametros=getRuta(leccion);
				cadena="LESSON " + parametros.leccion2 + " LEVEL " + parametros.nivel.toUpperCase();
				cadena=cadena + " &nbsp;&nbsp;<input type='radio' id='acento' name='acento' value='en-US' checked> <img src='galeria/img/american.png' width='38px' height='19px' /> </input>";
				cadena=cadena + " &nbsp;&nbsp;<input type='radio' id='acento' name='acento' value='en-GB'> <img src='galeria/img/british.png' width='50px' height='26px' /></input>";
				$("p#nivel-actual").html(cadena);
				if(status!=1){
					if($("div#centro-aviso1").hasClass("hidden"))
						$("div#centro-aviso1").removeClass("hidden");
				}else{
					if (!('webkitSpeechRecognition' in window)) {
						if($("div#centro-nosoportado").hasClass("hidden"))
							$("div#centro-nosoportado").removeClass("hidden");
					}else{
						audio1=document.getElementById("audio-listen");
						audio1.addEventListener("play",function(){ bucle_lab=setInterval(estadolaboratorio,1000); });
						document.getElementById("procesar").addEventListener("click",procesar);
						recognition = new webkitSpeechRecognition();
						recognition.lang = $("input#acento:checked").val();
						recognition.continuous = false;
						recognition.interimResults = true;
						recognition.onstart = function() {
							document.getElementById("procesar").innerHTML="Stop";							
							recognizing = true;
							console.log("empezando a escuchar");
						}	
						recognition.onresult = function(event) {
							for (var i = event.resultIndex; i < event.results.length; i++) {
								if(event.results[i].isFinal)
									texto+= event.results[i][0].transcript;
							}
						}	
						recognition.onerror = function(event) {

						}
						recognition.onend = function() {
							recognizing = false;
							document.getElementById("procesar").innerHTML="Start";
							console.log("terminó de escuchar, llegó a su fin");
							$("div#listen-yourself").removeClass("hidden");
							loadingAjax(true);
							$.ajax({
								url:"paginas/zonaingles/fcn/f_zonaingles.php",
								data:{metodo:"getPorcentaje",texto:texto,audio:$("audio#audio-listen").data("texto")},
								type:"POST",
								dataType:"json",
								success:function(data){
									$("span#you-said").text(texto);
									if(data.result==="ok"){
										$("span#porcentaje").text(Math.round(data.porcentaje) + "%");
										if(data.porcentaje>=90){
											$("span#porcentaje").addClass("green");
											$("span#porcentaje").removeClass("red");
											if((posicion+1)<audios.length){
												$("button#btn-again").addClass("hidden");
												$("button#btn-next").removeClass("hidden");
											}else{												
												swal({
													title: "CONGRATULATIONS",
													text: "Congratulations you won.",
													imageUrl: "galeria/img/logos/bill-ok.png",													
													showConfirmButton: true
												}, function(){
													$.ajax({
														url:"paginas/zonaingles/fcn/f_zonaingles.php",
														data:{metodo:"upLection",leccion:leccion},
														type:"POST",
														dataType:"json",
														success:function(data){															
															location.reload();
														}
													});													
												});
											}
										}else{
											$("button#btn-next").addClass("hidden");
											$("button#btn-again").removeClass("hidden");
											$("span#porcentaje").addClass("red");
											$("span#porcentaje").removeClass("green");
										}
									}else{
										$("span#porcentaje").text("Sorry, I didn't hear you!");
									}
									texto="";
									loadingAjax(false);
								},
								error:function(){
									$("span#porcentaje").text("Error desconocido");		
									loadingAjax(false);	
								}
							});
						}
						if($("div#centro-aviso2").hasClass("hidden"))
							$("div#centro-aviso2").removeClass("hidden");
						$.ajax({
							url:"paginas/zonaingles/fcn/f_zonaingles.php",
							data:{metodo:"getAudios",leccion:leccion,tabla:parametros.tabla},
							type:"POST",
							dataType:"json",
							success:function(data){
								$("audio#audio-listen").attr("src",parametros.ruta + data.audios[0]["archivo"] + ".mp3");
								$("audio#audio-listen").data("texto",data.audios[0]["texto"]);
								audios=[];
								textos=[];
								indice=0;
								for (var field in data.audios){
									audios[indice]=data.audios[field]["archivo"];
									textos[indice]=data.audios[field]["texto"];
									indice++;
								}
								posicion=0;
							},
							error:function(){
								SweetError();
							}
						});
					}
				}
			}else if(pagina==="menu-test"){
				status=$("section#center").data("status");
				if(status!="1"){
					$("div#centro-aviso1").removeClass("hidden");
				}else{
					$("div#centro-aviso2").removeClass("hidden");
				}
			}else if(pagina==="menu-juegos2"){
				$('head').append('<script src="js/juegos/1.js"></script>');
				iniciarJuego();
			}
			loadingAjax(false);
		});
	});	
	/************************AUDIES BEGIN**************************/
	$(document).on("change","select#select-niveles",function(){
		id=$(this).val();
		disco=discos[id];
		nivel=niveles[id];
		status=$("section#center").data("status");
		if((disco=="1" && nivel==="1") || status==1){
			$("div#loading-ajax").removeClass("hidden");
			if(!$("div#centro-aviso").hasClass("hidden"))
				$("div#centro-aviso").addClass("hidden");
			if($("div#centro-audios").hasClass("hidden"))
				$("div#centro-audios").removeClass("hidden");
			$.ajax({
				url:"paginas/zonaingles/fcn/f_zonaingles.php",
				data:{metodo:"getTitulos",disco:disco,nivel:nivel},
				type:"POST",
				dataType:"json",
				success:function(data){
					$("ul#lista-audios").html("");
					indice=0;
					audios=[];
					for(field in data.audios){
						$("ul#lista-audios").append("<li data-indice=" + indice + "><a href='#' class='song'>" + data["audios"][field]["titulo"] + "</a></li>");
						audios[indice]=data["audios"][field]["texto"];
						indice++;
					}
					if($("div#centro-audios").hasClass("hidden"))
						$("div#centro-audios").removeClass("hidden");
					if($("div#barra").hasClass("hidden"))
						$("div#barra").removeClass("hidden");
					if($("div#botones").hasClass("hidden"))
						$("div#botones").removeClass("hidden");
					total=indice+1;
					i=0;
					$("div#loading-ajax").addClass("hidden");
				}
			});
		}else{
			$("ul#lista-audios").html("");
			if($("div#centro-aviso").hasClass("hidden"))
				$("div#centro-aviso").removeClass("hidden");
			if(!$("div#centro-audios").hasClass("hidden"))
				$("div#centro-audios").addClass("hidden");			
		}
	});
	$(document).on("click","button#iniciar",function(){
		if(medio.attr("src")===""){
			primero=$("ul#lista-audios").children("li[data-indice=" + i + "]");
			primeroTexto=primero.text();
			primero.addClass("active");
			if(nivel==1){
				nivel2="basic";
			}else if(nivel==2){
				nivel2="intermediate";
			}else{
				nivel2="advance";
			}
			$("div#textos").html(audios[i]);
			medio.attr("src","medias/audios/" + nivel2 + "/" + disco + "/" + primeroTexto + ".mp3");
			reproducir();			
		}else{
			pausarRenovar();
		}
	});
	$(document).on("click","button#prev",function(){
		if(i>0){
			i--;
			$("ul#lista-audios").find("li").removeClass("active");
			actual=$("ul#lista-audios").children("li[data-indice=" + i + "]");
			actual.addClass("active");
			actualTexto=actual.text();
			medio.end();
			window.clearInterval(bucle);
			if(nivel==1){
				nivel2="basic";
			}else if(nivel==2){
				nivel2="intermediate";
			}else{
				nivel2="advance";
			}
			$("div#textos").html(audios[i]);
			medio.attr("src","medias/audios/" + nivel2 + "/" + disco + "/" + actualTexto + ".mp3");
			reproducir();
		}
	});
	$(document).on("click","button#next",function(){
		if(i<total-1){
			i++;
			$("ul#lista-audios").find("li").removeClass("active");
			actual=$("ul#lista-audios").children("li[data-indice=" + i + "]");
			actual.addClass("active");
			actualTexto=actual.text();
			medio.end();
			window.clearInterval(bucle);
			if(nivel==1){
				nivel2="basic";
			}else if(nivel==2){
				nivel2="intermediate";
			}else{
				nivel2="advance";
			}
			$("div#textos").html(audios[i]);
			medio.attr("src","medias/audios/" + nivel2 + "/" + disco + "/" + actualTexto + ".mp3");
			reproducir();			
		}
	});	
	$("section#center").on("click","a.song",function(e){
		e.preventDefault();
		i=$(this).parent().data("indice");
		$("ul#lista-audios").find("li").removeClass("active");
		actual=$("ul#lista-audios").children("li[data-indice=" + i + "]");
		actual.addClass("active");
		actualTexto=actual.text();
		medio.end();
		window.clearInterval(bucle);
		if(nivel==1){
			nivel2="basic";
		}else if(nivel==2){
			nivel2="intermediate";
		}else{
			nivel2="advance";
		}		
		$("div#textos").html(audios[i]);
		medio.attr("src","medias/audios/" + nivel2 + "/" + disco + "/" + actualTexto + ".mp3");
		reproducir();
	});
	/**********************AUDIES END**********************/
	/**********************LESSON BEGIN********************/
	$("section#center").on("click","a.lesson",function(e){
		indice=$(this).parent().data("indice");
		status=$("section#center").data("status");
		leccion=$("section#center").data("leccion");
		actual=$(this).parent();
		if(status!=1){
			if(indice<1){
				loadingAjax(true);
				if(!$("div#centro-aviso").hasClass("hidden"))
					$("div#centro-aviso").addClass("hidden");
				if($("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").removeClass("hidden");
				if(!$("div#centro-aviso2").hasClass("hidden"))
					$("div#centro-aviso2").addClass("hidden");				
				$("ul#lista-audios").find("li").removeClass("active");
				$("div#centro-escenas").load("paginas/zonaingles/lessons/" + indice + ".html",function(){
					actual.addClass("active");
					loadingAjax(false);
				});
			}else{
				$("div#centro-escenas").html("");
				if($("div#centro-aviso").hasClass("hidden"))
					$("div#centro-aviso").removeClass("hidden");
				if(!$("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").addClass("hidden");				
			}
		}else{
			if(indice<=leccion){
				loadingAjax(true);
				if(!$("div#centro-aviso").hasClass("hidden"))
					$("div#centro-aviso").addClass("hidden");
				if($("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").removeClass("hidden");
				if(!$("div#centro-aviso2").hasClass("hidden"))
					$("div#centro-aviso2").addClass("hidden");				
				$("ul#lista-audios").find("li").removeClass("active");
				$("div#centro-escenas").load("paginas/zonaingles/lessons/" + indice + ".html",function(){
					actual.addClass("active");
					loadingAjax(false);
				});
			}else{
				$("div#centro-escenas").html("");
				if($("div#centro-aviso2").hasClass("hidden"))
					$("div#centro-aviso2").removeClass("hidden");
				if(!$("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").addClass("hidden");				
			}
		}
	});
	/**********************LESSON END********************/
	
	/**********************SCENES BEGIN********************/
	$("section#center").on("click","a.song-escenas",function(e){
		indice=$(this).parent().data("indice");
		status=$("section#center").data("status");
		leccion=$("section#center").data("leccion");
		if(status!=1){
			if(indice<4){
				loadingAjax(true);
				if(!$("div#centro-aviso").hasClass("hidden"))
					$("div#centro-aviso").addClass("hidden");
				if($("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").removeClass("hidden");
				if(!$("div#centro-aviso2").hasClass("hidden"))
					$("div#centro-aviso2").addClass("hidden");				
				$("ul#lista-audios").find("li").removeClass("active");
				ruta="medias/escenas/" + indice + ".mp4";
				$("video#video").attr("src",ruta);
				$(this).parent().addClass("active");
				loadingAjax(false);
				document.getElementById("video").play();
			}else{
				document.getElementById("video").src="";
				if($("div#centro-aviso").hasClass("hidden"))
					$("div#centro-aviso").removeClass("hidden");
				if(!$("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").addClass("hidden");				
			}
		}else{
			if(indice<=leccion){
				loadingAjax(true);
				if(!$("div#centro-aviso").hasClass("hidden"))
					$("div#centro-aviso").addClass("hidden");
				if($("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").removeClass("hidden");
				if(!$("div#centro-aviso2").hasClass("hidden"))
					$("div#centro-aviso2").addClass("hidden");				
				$("ul#lista-audios").find("li").removeClass("active");
				ruta="medias/escenas/" + indice + ".mp4";
				$("video#video").attr("src",ruta);
				$(this).parent().addClass("active");
				loadingAjax(false);
				document.getElementById("video").play();				
			}else{
				document.getElementById("video").src="";
				if($("div#centro-aviso2").hasClass("hidden"))
					$("div#centro-aviso2").removeClass("hidden");
				if(!$("div#centro-escenas").hasClass("hidden"))
					$("div#centro-escenas").addClass("hidden");				
			}
		}
	});
	/**********************SCENES END**********************/
	/**********************VOCABULARY BEGIN**********************/	
	$("section#center").on("click","a.song-vocabulario",function(e){
		e.preventDefault();
		$("ul#lista-audios").find("li").removeClass("active");
		i=$(this).parent().data("indice");
		$("div#textos-vocabulario").html($(this).data("spanish"));
		$(this).parent().addClass("active");
	});
	/**********************VOCABULARY END**********************/	
	/**********************EJERCITY BEGIN**********************/
	$(document).on("click","button#btn-go-ejercicios",function(){
		nivel=$("select#select-niveles-ejercicios").val();
		disco=$("select#select-discos-ejercicios").val();
		if(nivel==="0" || disco==="0")
			return false;
		status=$("section#center").data("status");
		if(disco=="1" && nivel==="basic"){
			callExercises();
		}else{
			if(status!=1){
				if($("div#centro-aviso").hasClass("hidden"))
					$("div#centro-aviso").removeClass("hidden");
				if(!$("div#centro-aviso2").hasClass("hidden"))
					$("div#centro-aviso2").addClass("hidden");				
				if(!$("div#centro-ejercicios").hasClass("hidden"))
					$("div#centro-ejercicios").addClass("hidden");
			}else{
				leccion=$("section#center").data("leccion");
				if(isAllowSection(disco,nivel,leccion)){
					callExercises();
				}else{
					if(!$("div#centro-aviso").hasClass("hidden"))
						$("div#centro-aviso").addClass("hidden");
					if(!$("div#centro-ejercicios").hasClass("hidden"))
						$("div#centro-ejercicios").addClass("hidden");					
					if($("div#centro-aviso2").hasClass("hidden"))				
						$("div#centro-aviso2").removeClass("hidden");
				}
			}
		}
	});
	$(document).on("click","button#btn-back-ejercicios",function(){
		destino=$(this).data("destino");
		$("section#s" + (parseInt(destino)+1)).addClass("hidden");
		$("section#s" + destino).removeClass("hidden");
		$(this).data("destino",destino-1);
		$("button#btn-next-ejercicios").data("destino",destino+1);
		if($("button#btn-next-ejercicios").hasClass("hidden"))
			$("button#btn-next-ejercicios").removeClass("hidden");
		if(destino==1)
			$(this).addClass("hidden");
	});
	$(document).on("click","button#btn-next-ejercicios",function(){
		destino=$(this).data("destino");
		if($("button#btn-back-ejercicios").hasClass("hidden"))
			$("button#btn-back-ejercicios").removeClass("hidden");
		if(destino>=$("div#secciones").data("total"))
			$(this).addClass("hidden");
		$("section#s" + (destino-1)).addClass("hidden");
		$("section#s" + destino).removeClass("hidden");
		$(this).data("destino",destino+1);
		$("button#btn-back-ejercicios").data("destino",parseInt(destino)-1);
	});
	$(document).on("click","button#btn-check-ejercicios",function(){
		actual=parseInt($("button#btn-next-ejercicios").data("destino"))-1;
		if(actual===1){
			i=0;
			good=0;bad=0;
			$("div.respuesta-multiple").each(function(index){
				i++;
				resultado=$(this).find("div.resultado").first();
				resultado.removeClass("hidden");
				if($(this).find("input:checked").first().val()=="1"){
					resultado.find("span").first().addClass("hidden");
					resultado.find("span").last().removeClass("hidden");
					good++;
				}else{
					resultado.find("span").first().removeClass("hidden");
					resultado.find("span").last().addClass("hidden");
					bad++;
				}	
			});
			total=good + bad;
			porcentaje=good * 100 / total;			
			if(porcentaje>=90){
				$("section#s1").find("div#calificacion").html("<i class='fa fa-thumbs-up green'></i> " + good + " de " + total + " &nbsp;/ &nbsp;" + porcentaje + "%<br>");
				if($("section#s1").find("div#calificacion").hasClass("red"))
					$("section#s1").find("div#calificacion").removeClass("red");
			}else{
				$("section#s1").find("div#calificacion").html("<i class='fa fa-times red'></i> " + good + " de " + total + " &nbsp;/ &nbsp;" + porcentaje + "%<br>");
				if(!$("section#s1").find("div#calificacion").hasClass("red"))
					$("section#s1").find("div#calificacion").addClass("red");
			}
		}else if(actual<8){
			i=0;
			good=0;bad=0;
			$("section#s" + actual).find("div.respuesta-audio").each(function(index){
				i++;
				resultado=$(this).find("div.resultado").first();
				resultado.removeClass("hidden");
				if($(this).find("input").first().val()==$(this).data("texto")){
					resultado.find("span").first().addClass("hidden");
					resultado.find("span").last().removeClass("hidden");
					good++;					
				}else{
					resultado.find("span").first().removeClass("hidden");
					resultado.find("span").last().addClass("hidden");
					bad++;					
				}
			});
			total=good + bad;
			porcentaje=parseInt(good * 100 / total);
			if(porcentaje>=90){
				$("section#s" + actual).find("div#calificacion").html("<i class='fa fa-thumbs-up green'></i> " + good + " de " + total + " &nbsp;/ &nbsp;" + porcentaje + "%<br>");
				if($("section#s" + actual).find("div#calificacion").hasClass("red"))
					$("section#s" + actual).find("div#calificacion").removeClass("red");
			}else{
				$("section#s" + actual).find("div#calificacion").html("<i class='fa fa-times red'></i> " + good + " de " + total + " &nbsp;/ &nbsp;" + porcentaje + "%<br>");
				if(!$("section#s" + actual).find("div#calificacion").hasClass("red"))
					$("section#s" + actual).find("div#calificacion").addClass("red");
			}
		}
	});
	/**********************EJERCITY END**********************/
	/********************ACTIVITIES BEGIN********************/
	//POR EL MOMENTO NADA
	/********************ACTIVITIES BEGIN********************/
	/**********************JUEGOS BEGIN**********************/
	$(document).on("click",".dropdown-menu>li>a",function(){
		archivo=$(this).data("archivo");
		$(".dropdown-menu>li").removeClass("active");
		$("#objeto-flash").attr("data","medias/swf/" + archivo + ".swf");
		$("#params-flash").attr("value","medias/swf/" + archivo + ".swf");
		$(this).parent().addClass("active");
	});
	/***********************JUEGOS END***********************/	
	/**********************API TRASLATE BEGIN**********************/
	$(document).on("click","button#btn-go-traslate",function(){
		if($("textarea#txt-traslate").val()!=""){
			status=$("section#center").data("status");
			if(status!="1"){
				if($("div#traslate-aviso").hasClass("hidden"))
					$("div#traslate-aviso").removeClass("hidden")
			}else{
				if($("div#traslate-aviso2").hasClass("hidden"))
					$("div#traslate-aviso2").removeClass("hidden")				
			}
		}
	});
	/**********************API TRASLATE END************************/
	/*********************VIDEO LIBRARY BEGIN**********************/
	$(document).on("click","button#btn-go-library",function(){
		alert(document.getElementById("txt-library").value);
	});	
	$(document).on("click","div.spot_P>a",function(){
		$("iframe#video").attr("src","https://www.youtube.com/embed/" + $(this).parent().data("vid"));
	});
	/*********************VIDEO LIBRARY END************************/
	/**********************LABORATORY BEGIN************************/
	$(document).on("click","button#btn-go-laboratorio",function(){
		if($("#select-niveles-laboratorio").val()!=="0" && $("#select-discos-laboratorio").val()!=="0"){
			$("div#elementos").removeClass("hidden");
		}
	});
	$(document).on("click","button#btn-again",function(){
		$("div#listen-yourself").addClass("hidden");
		$("div#repeat").addClass("hidden");
		$("span#you-said").text("");		
		document.getElementById("audio-listen").play();
	});
	
	$(document).on("click","button#btn-next",function(){
		$("div#listen-yourself").addClass("hidden");
		$("div#repeat").addClass("hidden");
		$("span#you-said").text("");
		posicion++;
		$("audio#audio-listen").attr("src","medias/audios/basic/1/" + audios[posicion] + ".mp3");
		$("audio#audio-listen").data("texto",textos[posicion]);
		document.getElementById("audio-listen").play();
	});
	$(document).on("click","input#acento",function(){
		recognition.lang=$(this).val();
	});
	/**********************LABORATORY END***********************/	
	
});
function enviarMensaje(title,text){
    swal({
        title: title,
	    text: text,
	    imageUrl: "galeria/img/logos/bill-ok.png",
	    showConfirmButton: true
    });        
}
function repetir(){
	posicion++;
	titulo=$("ul#lista-audios").children("li[data-indice=" + posicion + "]").text();
	$.ajax({
		url:"medias/audios/advance/4/" + titulo + ".TXT",
		type:"POST",
		dataType:"html",
		success:function(data){
			contenido=data;
			$.ajax({
				url:"controladores/c_ingles.php",
				data:{metodo:"uploads",tabla:tabla,posicion:posicion,titulo:titulo,contenido:contenido},
				type:"POST",
				dataType:"html",
				success:function(data){
					if(i<total){
						repetir();
					}else{
						alert("Termino");
					}
				}
			});
		}
	});	
}
function reproducir(){
	medio=document.getElementById('audio');
	iniciar=document.getElementById('iniciar');
	barra=document.getElementById('barra');
	progreso=document.getElementById('progreso');	
	medio.play();
	iniciar.innerHTML='Pause';
	bucle=setInterval(estado, 1000);
}
function estado(){
	if(!medio.ended){
		var total=parseInt(medio.currentTime*maximo/medio.duration);
		progreso.style.width=total+'px';
	}else{
		progreso.style.width='0px';
		window.clearInterval(bucle);
		for(j=0;j<100000;j++){
			
		}
		i++;
		siguiente=$("ul#lista-audios").children("li[data-indice=" + i + "]");
		$("ul#lista-audios").find("li").removeClass("active");
		siguienteTexto=siguiente.text();
		siguiente.addClass("active");
		if(nivel==1){
			nivel2="basic";
		}else if(nivel==2){
			nivel2="intermediate";
		}else{
			nivel2="advance";
		}		
		$("div#textos").html(audios[i]);
		medio.src="medias/audios/" + nivel2 + "/" + disco + "/" + siguienteTexto + ".mp3";
		reproducir();		
	}
}
function pausarRenovar(){
	if(medio.paused){
		bucle=setInterval(estado, 1000);
		medio.play();
		iniciar.innerHTML="Pause";
	}else{
		window.clearInterval(bucle);
		medio.pause();
		iniciar.innerHTML="Play";
	}
}

function procesar(){
	if(!recognizing){
		recognition.start();
	}else{
		recognition.stop();
	}
}

function estadolaboratorio(){
	if(audio1.ended){
		$("div#repeat").removeClass("hidden");
		window.clearInterval(bucle_lab);
	}
}

function getRuta(leccion){
	if(leccion>=0 && leccion<20){
		tabla="eng_1_1";
		nivel="basic";
		disco="1";
		leccion2=parseInt(leccion) + 1;
	}else if(leccion>=20 && leccion<40){
		tabla="eng_1_2";
		nivel="basic";
		disco="2";		
		leccion2=parseInt(leccion) + 1;
	}else if(leccion>=40 && leccion<60){
		tabla="eng_1_3";
		nivel="basic";
		disco="3";		
		leccion2=parseInt(leccion) + 1;
	}else if(leccion>=60 && leccion<80){
		tabla="eng_1_4";
		nivel="basic";
		disco="4";		
		leccion2=parseInt(leccion) + 1;
	}else if(leccion>=80 && leccion<100){
		tabla="eng_2_1";
		nivel="intermediate";
		disco="1";		
		leccion2=parseInt(leccion) - 79;
	}else if(leccion>=100 && leccion<120){
		tabla="eng_2_2";
		nivel="intermediate";
		disco="2";
		leccion2=parseInt(leccion) - 79;
	}else if(leccion>=120 && leccion<140){
		tabla="eng_2_3";
		nivel="intermediate";
		disco="3";
		leccion2=parseInt(leccion) - 79;
	}else if(leccion>=140 && leccion<160){
		tabla="eng_2_4";
		nivel="intermediate";
		disco="4";
		leccion2=parseInt(leccion) - 79;
	}else if(leccion>=160 && leccion<180){
		tabla="eng_3_1";
		nivel="advance";
		disco="1";
		leccion2=parseInt(leccion) - 159;
	}else if(leccion>=180 && leccion<200){
		tabla="eng_3_2";
		nivel="advance";
		disco="2";
		leccion2=parseInt(leccion) - 159;
	}else if(leccion>=200 && leccion<220){
		tabla="eng_3_3";
		nivel="advance";
		disco="3";
		leccion2=parseInt(leccion) - 159;
	}else if(leccion>=220 && leccion<240){
		tabla="eng_3_4";
		nivel="advance";
		disco="4";
		leccion2=parseInt(leccion) - 159;
	}
	ruta="medias/audios/" + nivel + "/" + disco + "/";
	return {tabla:tabla,ruta:ruta,nivel:nivel,disco:disco,leccion2:leccion2};
}

function callExercises(){
	loadingAjax(true);
	aleatorio=Math.random()*10000;	
	$("div#centro-ejercicios").load("paginas/zonaingles/ejercicios/" + nivel + disco + ".html?aleatorio=" + aleatorio,function(){
		if(!$("div#centro-aviso").hasClass("hidden"))
			$("div#centro-aviso").addClass("hidden");
		if(!$("div#centro-aviso2").hasClass("hidden"))
			$("div#centro-aviso2").addClass("hidden");		
		if($("div#centro-ejercicios").hasClass("hidden"))
			$("div#centro-ejercicios").removeClass("hidden");
		$("section#s2").load("paginas/zonaingles/fcn/f_sonidos.php?nivel=" + nivel + "&disco=" + disco + "&parte=1&aleatorio=" + aleatorio);
		$("section#s3").load("paginas/zonaingles/fcn/f_organizar.php?nivel=" + nivel + "&disco=" + disco + "&parte=1&aleatorio=" + aleatorio);
		$("section#s4").load("paginas/zonaingles/fcn/f_sonidos.php?nivel=" + nivel + "&disco=" + disco + "&parte=2&aleatorio=" + aleatorio);
		$("section#s5").load("paginas/zonaingles/fcn/f_organizar.php?nivel=" + nivel + "&disco=" + disco + "&parte=2&aleatorio=" + aleatorio);
		$("section#s6").load("paginas/zonaingles/fcn/f_sonidos.php?nivel=" + nivel + "&disco=" + disco + "&parte=3&aleatorio=" + aleatorio);
		$("section#s7").load("paginas/zonaingles/fcn/f_organizar.php?nivel=" + nivel + "&disco=" + disco + "&parte=3&aleatorio=" + aleatorio);
		$("section#s8").load("paginas/zonaingles/fcn/f_sopa_letras.php?nivel=" + nivel + "&disco=" + disco + "&parte=3&aleatorio=" + aleatorio);
		loadingAjax(false);
	});	
}

function isAllowSection(disco,nivel,leccion){
	valor_nivel=nivel=="basic"?0:nivel=="intermediate"?1:2;
	valor=(valor_nivel*80)+((disco-1)*20);
	return (leccion>=valor);
}