var moduleApp = angular.module("registrarAp", []);
moduleApp.factory("httpService", function ($http) {
    return {
        get: function (metodo, url, datos) {
        return $http({
            method: metodo,
            url: url,
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            data: datos
        });
        },
        json: function (url, name) { 
            return $http.get(url + name + ".json");  
	},
	translate: function (url, idioma) { 
            return $http.get(url + idioma + ".json"); 
	}
    };
});
moduleApp.controller("RegistrarController", function($scope,httpService) {
     $scope.dias=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];     
     $scope.meses=[{indice:0,mes:"mes"},
                   {indice:1,mes:"Ene."},
                   {indice:2,mes:"Feb."},
                   {indice:3,mes:"Mar."},
                   {indice:4,mes:"Abr."},
                   {indice:5,mes:"May."},
                   {indice:6,mes:"Jun."},
                   {indice:7,mes:"Jul."},
                   {indice:8,mes:"Ago."},
                   {indice:9,mes:"Sep."},
                   {indice:10,mes:"Oct."},
                   {indice:11,mes:"Nov."},
                   {indice:12,mes:"Dic."}];
     $scope.agnos=[];
     for(i=2016;i>1950;i--)
     $scope.agnos[2016-i]=i;
	 $scope.acepto=false;
	 $scope.aceptar=function(){
		valido=validar();
		if(valido!=="ok"){
			swal({
				title: "Cargue todos los datos.",
				text: valido,
				imageUrl: "galeria/img/logos/bill-ok.png",
			});
			return false;
		}
		dia=$("#e_dia_nac").val();
		mes=$("#e_mes_nac").val();
		agno=$("#e_agno_nac").val();
		form=$("form#usr-reg-form").serialize() + "&metodo=registrar&dia=" + dia + "&mes=" + mes + "&agno=" + agno;		
		loadingAjax(true);
		$.ajax({
			url:"paginas/registro/fcn/f_registro.php",
			data:form,
			type:"POST",
			dataType:"html",
			success:function(data){
				console.log(data);
				swal({
					title: "Bienvenido", 
					text: "Seras redireccionado en 2 segundos.",
					imageUrl: "galeria/img/logos/bill-ok.png",
					timer: 2000, 
					showConfirmButton: true
				},function(){			
					window.open("index","_self");
				});
			},
			error:function(xhr){
				SweetError(text);
			}
		});
	}	
});
function validar(){	
	if(document.getElementById("e_nombres").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("e_apellidos").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("e_genero").value=="1"){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("e_direccion").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("seudonimo").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("email").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("password").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("password_val").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("e_dia_nac").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("e_mes_nac").value==""){
		return "Todos los datos son necesarios para el registro.";
	}		
	if(document.getElementById("e_agno_nac").value==""){
		return "Todos los datos son necesarios para el registro.";
	}
	if(document.getElementById("password").value!==document.getElementById("password_val").value){
		return "La clave no coincide.";
	}		
	return "ok";
}