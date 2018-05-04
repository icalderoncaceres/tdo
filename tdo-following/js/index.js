var moduleApp = angular.module("apIndex", []);
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
moduleApp.controller("ctrlIndex", function($scope,httpService) {
    $scope.password="";
    $scope.ingresar=function(){
        httpService.get("POST","controladores/c_index.php",toParams({metodo:"ingresar",password:$scope.password})).success(function(data){
            if(data.result==="1"){
                window.open("principal.php","_self");
            }else{
                alert("Clave incorrecta");
                $scope.password="";
            }
        });
    };
});