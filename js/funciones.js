//setTimeout("cambiarBanner()",2000);
$(document).ready(function(){
cambiarBanner();
var i=0;
function cambiarBanner(){
if(i==5)
i=1;
else
i++;
var ruta="<img src=galeria/imagenes/bannerpublicidad/" + i + ".png></img>"
$("#banner").html(ruta);
$("#banner").fadeOut(3000,function(){$("#banner").fadeIn(2500);cambiarBanner();});

}

});