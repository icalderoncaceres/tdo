$(document).ready(function(){
	alert("iisisis");
	$("#ajaxContainer").on("click",".vinculos-areas",function(){
		var area=$(this).data("area");
		$.ajax({
			url:"paginas/recursos/p_tipos.php",
			data:{area:area},
			type:"POST",
			dataType:"html",
			success:function(data){
				$("#ajaxContainer").html(data);
			}
		});
	});
});