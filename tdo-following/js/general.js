function toParams(obj) {
    var p = [];
    for (var key in obj) p.push(key + "=" + encodeURIComponent(obj[key]));
	return p.join("&");	
}
function loadingAjax(status){
    if(status){
        //$('<div class="modal-backdrop fade in cargador" style="display:none"></div>').appendTo(document.body);
	document.getElementById("load-ajax").style.visibility="visible";
    }else{
	document.getElementById("load-ajax").style.visibility="hidden";
    }
}