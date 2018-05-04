//Funciones del juego tipo dinosaurio
var keyboard=[];
var playing=false;
var intervalo,intervalo2;
var character={x:150,y:140,speed:3,radius:5,width:5,height:5};
var words=[],words2=[],contador=0,life=200,aleatorio,fallido=0,velocidad_words=1,velocidad_add_word=1300,lesson=1;
$(document).ready(function(){
    swal({
		title: "Estamos actualizando nuestra gama de juegos",
		text: "Por el momento tenemos disponible un juego, en los proximos dias habilitaremos muchos mas.",
		imageUrl: "galeria/img/logos/bill-ok.png",
		time:2000,
		showConfirmButton: true
	});
//	*123iraima28021980* Contraseña de Iraima WiFi
	$.ajax({
		url:"paginas/zonaingles/fcn/f_zonaingles.php",
		data:{metodo:"getVocabulario"},
		type:"POST",
		dataType:"html",
		success:function(data){
			$("ul#vocablos").append(data);
			$("a.song-vocabulario").each(function(index){
				words.push({
					spanish:$(this).data("spanish"),
					english:$(this).text()
				});
			});
		}
	});
});
function iniciarJuego(){
	canvas=document.getElementById("micanvas");
	cxt=canvas.getContext("2d");
	drawBackground();
	document.getElementById("btn-start").addEventListener("click",startGame);
}

function startGame(){
	if(!playing){
		intervalo=window.setInterval(frameLoop,25);
		intervalo2=window.setInterval(addWord,velocidad_add_word);
		intervalo3=window.setInterval(upLevel,12000);
		document.getElementById("btn-start").innerHTML="Stop";
		document.addEventListener("keydown",function(e){
				keyboard[e.keyCode]=true;
			}
		);
		document.addEventListener("keyup",function(e){
				keyboard[e.keyCode]=false;
			}
		);
		selectWord();
		canvasVidas=document.getElementById("canvas-vidas");
		cxtVidas=canvasVidas.getContext("2d");
		cxtVidas.save();
		cxtVidas.fillStyle="blue";
		cxtVidas.fillRect(0,15,life,70);
		cxtVidas.restore();
		document.getElementById("marcador").innerHTML="SCORE = 0";
	}else{
		clearInterval(intervalo);
		clearInterval(intervalo2);
		clearInterval(intervalo3);		
		document.getElementById("btn-start").innerHTML="Restart";
	}
	playing=!playing;
}

function frameLoop(){
	cxt.clearRect(0,0,canvas.width,canvas.height);
	drawBackground();
	drawCharacter();
	moveWords();
	drawWords();
}

function drawBackground(){
	cxt.save();
	cxt.fillStyle = "black";
	cxt.fillRect(0,0,canvas.width,canvas.height);
	cxt.restore();	
}

function drawStarts(){
	cxt.save();
	cxt.fillStyle="white";
	for(var i=0;i<50;i++){
		cxt.fillRect(Math.random()*canvas.width,Math.random()*(canvas.height/4),1,1);
	}
	cxt.restore();
}

function drawCharacter(){
	if(keyboard[37]){
		character.x-=character.speed;
		if(character.x<character.radius) character.x=character.radius;
	}else if(keyboard[39]){
		character.x+=character.speed;
		if(character.x>(canvas.width)-character.radius) character.x=canvas.width-character.radius;
	}
	if(keyboard[38]){
		character.y-=character.speed;
		if(character.y<0) character.y=0;		
	}else if(keyboard[40]){
		character.y+=character.speed;
		if(character.y>canvas.height) character.y=canvas.height;
	}
	cxt.save();
	cxt.beginPath();
	cxt.strokeStyle="red";
	cxt.fillStyle="green";
	cxt.arc(character.x,character.y,character.radius,0,Math.PI*2);
	cxt.stroke();
	cxt.fill();
	cxt.restore();
}

function drawWords(){
	cxt.save();
	cxt.beginPath();
	cxt.font="bold 10px verdana, sans-serif";
	cxt.textAlign="start";
	cxt.fillStyle="white";	
	words2=words2.filter(function(word){
		return word.y<canvas.height;
	});
	for(i in words2){
		word=words2[i];
		cxt.fillText(word.texto,word.x,word.y);
		if(hit(word,character)){
			word.y+=400;
			fallido=Math.round(Math.random()*5);
			if(word.texto==document.getElementById("palabra-oculta").value){
				document.getElementById("audio-yes").play();
				contador++;
				document.getElementById("marcador").innerHTML="SCORE = " + contador;
				selectWord();
				life+=2;
			}else{
				document.getElementById("audio-no").play();
				cxtVidas.clearRect(0,15,life,70);
				life-=10;
				cxtVidas.save();
				cxtVidas.fillStyle="blue";
				cxtVidas.fillRect(0,15,life,70);
				cxtVidas.restore();
				if(life<=0){
					window.clearInterval(intervalo);
					window.clearInterval(intervalo2);
					window.clearInterval(intervalo3);
					document.removeEventListener("keydown",function(e){}
					);
					document.removeEventListener("keyup",function(e){}
					);					
					setTimeout(finishGame,100);
				}
			}
		}
	}	
	cxt.restore();
}

function addWord(){
	if(fallido>=8){
		fallido=0;
		aleatorio_local=aleatorio;
	}else{
		fallido++;
		aleatorio_local=parseInt(Math.random()*(words.length-1));
	}
	ancho=(words[aleatorio_local].english.length)*8;
	words2.push({texto:words[aleatorio_local].english,x:Math.random()*(canvas.width*0.8),y:20,width:ancho,height:10});
}

function moveWords(){
	for(i in words2){
		word=words2[i];
		word.y+=velocidad_words;
	}
}

function selectWord(){
	limite=lesson*30;
	aleatorio=parseInt(Math.random()*limite);
	document.getElementById("palabra-buscar").innerHTML=words[aleatorio].spanish;
	document.getElementById("palabra-oculta").value=words[aleatorio].english;
}

function hit(a,b){
	var hit=false;
	if(b.x + b.width >= a.x && b.x < a.x + a.width){
		if(b.y + b.height >= a.y && b.y < a.y + a.height){
			hit=true;
		}
	}
	if(b.x <= a.x && b.x + b.width >= a.x + a.width){
		if(b.y <= a.y && b.y + b.height >= a.y + a.height){
			hit=true;
		}
	}
	if(a.x <= b.x && a.x + a.width >= b.x + b.width){
		if(a.y <= b.y && a.y + a.height >= b.y + b.height){
			hit=true;
		}
	}
	return hit;
}

function finishGame(){
	var texto="GAME OVER";
	flag=document.getElementById("record-personal").innerHTML!=""?1:0;
	if(flag==0 || contador>parseInt(document.getElementById("record-personal").innerHTML)){
		texto="NEW RECORD";
		$.ajax({
			url:"paginas/zonaingles/fcn/f_zonaingles.php",
			data:{metodo:"updatePuntaje",puntos:contador,flag:flag},
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
			}
		});
	}
	cxt.clearRect(0,0,canvas.width,canvas.height);
	drawBackground();
	cxt.font="bold 30px verdana, sans-serif";
	cxt.textAlign="center";
	cxt.fillStyle="white";	
	cxt.fillText(texto,canvas.width / 2,canvas.height / 2);
	playing=false;
	document.getElementById("btn-start").innerHTML="Start";
	life=200;
	fallido=0;
	velocidad_words=1;
	velocidad_add_word=1000;
}

function upLevel(){
	addLesson();
	if(velocidad_words>2.3)
		return false;
	velocidad_words+=0.02;
	if(parseFloat(velocidad_words)>0){
		velocidad_add_word-=20;
		window.clearInterval(intervalo2);		
		intervalo2=window.setInterval(addWord,velocidad_add_word);
	}
}

function addLesson(){
	lesson++;
	/*
	$.ajax({
		url:"paginas/zonaingles/fcn/f_zonaingles.php",
		data:{metodo:"getVocabulario",lesson:lesson},
		type:"POST",
		dataType:"html",
		success:function(data){
			$("ul#vocablos").append(data);
			$("a.song-vocabulario").each(function(index){
				words.push({
					spanish:$(this).data("spanish"),
					english:$(this).text()
				});
			});
		}
	});	
	*/
}