$(document).ready(function(){
	$(document).on("click","li.menu-monitoreo>a",function(){
		$("li.menu-monitoreo").removeClass("active");
		$(this).parent().addClass("active");
		pagina=$(this).parent().attr("id");
		aleatorio=Math.random()*10000;
		loadingAjax(true);
		$("section#center").load("paginas/monitoreo/p_" + pagina + ".php?aleatorio=" + aleatorio,function(e){
			loadingAjax(false);
		});
	});
});