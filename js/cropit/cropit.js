/**
 * JavaScript: Cropit
 */
$(document).ready(function(){	
	$('.image-editor').cropit({
		exportZoom: 0.5,
		imageBackground: true,
		imageBackgroundBorderWidth: 25,
		smallImage: 'allow',
		maxZoom: 2,
		freeMove: true
	});
	$('button#save-foto').click(function() {                
		var imageData = $('.image-editor').cropit('export');
//		if($("button#save-foto").data("nro") === undefined){
			var count = 1;
                        var clasefoto;
                        if($("li#pesta4").hasClass("active"))
                            clasefoto='div#add-entrada .foto';
                        else
                            clasefoto='.foto';
			$(clasefoto).each(function(i, obj) {
				//if($(this).children("img").attr("id") === undefined){
					$(this).css("background","transparent");
					$(this).children("img").attr("src",imageData);
					$(this).children("img").attr("id",count);
					$(this).children("i").removeClass('hidden');
					return false;
				//}
				count++;
			});
//		}
                /*else{
                    alert("aqui");
			$("#"+$(this).data("nro")).attr("src",imageData);
			$("#"+$(this).data("nro")).parent().css("background","transparent");
			$("#"+$(this).data("nro")).next().removeClass('hidden');
			$(this).removeData("nro");
		}*/
	});
});