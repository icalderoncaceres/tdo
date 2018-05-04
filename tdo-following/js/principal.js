var moduleApp = angular.module("apPrincipal", []);
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
moduleApp.config(["$routeProvider",
    function($routeProvider) {
	$routeProvider. when("/", { templateUrl: "vistas/inicio.html", controller: "ctrlInicio"  }).
                    when("/foros/temas", { templateUrl: "vistas/temas.html", controller: "ctrlTemas"  }).
                    when("/foros/aportes", { templateUrl: "vistas/aportes.html", controller: "ctrlAportes"  }).
                    when("/articulos", { templateUrl: "vistas/articulos.html", controller: "ctrlArticulos"  }).
					when("/recursos/mis-recursos", { templateUrl: "vistas/recursos.html", controller: "ctrlRecursos"  }).
                    when("/recursos/pendientes", { templateUrl: "vistas/recursos_pendientes.html", controller: "ctrlRecursos_pendientes"  }).
                    when("/muros/mensajes", { templateUrl: "vistas/muros-mensajes.html", controller: "ctrlMuros_mensajes"  }).
                    when("/muros/comentarios", { templateUrl: "vistas/muros-comentarios.html", controller: "ctrlMuros_comentarios"  }).
                    when("/configuracion", { templateUrl: "vistas/configuracion.html", controller: "ctrlConfiguracion"  }).
                    when("/ayuda", { templateUrl: "vistas/ayuda.html", controller: "ctrlAyuda"  }).
			otherwise({ redirectTo: "/" });
}]);
moduleApp.controller("ctrlInicio", function($scope,httpService) {
});
moduleApp.controller("ctrlTemas", function($scope,httpService) {
    $scope.fondo1="fondo1";
    $scope.fondo2="fondo2";
    $scope.paginas=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
    var tabla="temas";
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",tabla:tabla})).success(function(data){
          $scope.temas=data.records;
    });
    $scope.cambiarPagina=function(pagina){
        loadingAjax(true);
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",pagina:pagina,tabla:tabla})).success(function(data){
              $scope.temas=data.records;
              loadingAjax(false);
        });        
    }
    $scope.cambiarStatus=function(id,status){
        if(status==true){
            status=1;
        }else{
            status=0;
        }
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"changeStatus",id:id,status:status,tabla:tabla})).success(function(data){
            console.log(data);
        });                
    };
});
moduleApp.controller("ctrlAportes", function($scope,httpService) {
    $scope.fondo1="fondo1";
    $scope.fondo2="fondo2";
    $scope.paginas=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
    var tabla="aportes";
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",tabla:tabla})).success(function(data){
          $scope.aportes=data.records;
    });
    $scope.cambiarPagina=function(pagina){
        loadingAjax(true);
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",pagina:pagina,tabla:tabla})).success(function(data){
              $scope.aportes=data.records;
              loadingAjax(false);
        });        
    }
    $scope.cambiarStatus=function(id,status){
        if(status==true){
            status=1;
        }else{
            status=0;
        }
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"changeStatus",id:id,status:status,tabla:tabla})).success(function(data){
            console.log(data);
        });                
    };
});

moduleApp.controller("ctrlArticulos", function($scope,httpService) {
    $scope.fondo1="fondo1";
    $scope.fondo2="fondo2";
    $scope.paginas=[1,2,3,4,5];
    $scope.titulo="";
    $scope.descripcion="";
    $scope.ruta="";
    var tabla="articulos";
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",tabla:tabla})).success(function(data){
          $scope.articulos=data.records;
    });
    $scope.cambiarPagina=function(pagina){
        loadingAjax(true);
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",pagina:pagina,tabla:tabla})).success(function(data){
              $scope.articulos=data.records;
              loadingAjax(false);
        });
    }
    $scope.cambiarStatus=function(id,status){
        if(status==true){
            status=1;
        }else{
            status=0;
        }
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"changeStatus",id:id,status:status,tabla:tabla})).success(function(data){
            console.log(data);
        });   
    };
    $scope.agregar=function(){
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"addArticulo",titulo:$scope.titulo,descripcion:$scope.descripcion,ruta:$scope.ruta})).success(function(data){
            console.log(data);
            if(data.result==="ok"){
                $scope.articulos.push({id:data.id,titulo:$scope.titulo,descripcion:$scope.descripcion,ruta:$scope.ruta,status:1});
                $scope.titulo="";
                $scope.descripcion="";
                $scope.ruta="";
            }else{
                alert("Error desconocido")
            }
        });
    };
});
moduleApp.controller("ctrlRecursos", function($scope,httpService) {
    $scope.fondo1="fondo1";
    $scope.fondo2="fondo2";
    $scope.paginas=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getEmployer"})).success(function(data){ 
        $scope.id=data.employer.usuarios_id;
        var tabla="recursos";    
        var condicion="employer_id=" + $scope.id;
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",tabla:tabla,condicion:condicion,campos:"id,titulo,fecha,status,ruta,descripcion,vinculo"})).success(function(data){
              $scope.recursos=data.records;
        });        
    });    
    $scope.cambiarPagina=function(pagina){
        loadingAjax(true);
        var tabla="recursos";    
        var condicion="employer_id=" + $scope.id;
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",pagina:pagina,tabla:tabla,condicion:condicion,campos:"id,titulo,fecha,status,ruta,descripcion,vinculo"})).success(function(data){
              $scope.recursos=data.records;
              loadingAjax(false);
        });        
    }
    $scope.desasignar=function(id,index){
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"unsetRecurso",id:id})).success(function(data){
            if(data.result==="ok"){
                $scope.recursos.splice(index,1);
            }else{
                alert("Error inesperado");
            }
        });                
    };
    $scope.cambiarStatus=function(id,status){
        var tabla="recursos";    
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"changeStatus",id:id,status:status,tabla:tabla})).success(function(data){
            alert("Modificacion realizada, recuerda que estos cambios son vistos inmediatamente por nuestros usuarios, GRACIAS POR TU APOYO");
            console.log(data);
        });   
    };
	$scope.pasar=function(recurso){
		document.getElementById("titulo").value=recurso.titulo;
		document.getElementById("descripcion").value=recurso.descripcion;
		document.getElementById("id").value=recurso.id;
		document.getElementById("ruta").value=recurso.ruta;
		document.getElementById("vinculo").value=recurso.vinculo;
	};
});
moduleApp.controller("ctrlRecursos_pendientes", function($scope,httpService) {
    $scope.fondo1="fondo1";
    $scope.fondo2="fondo2";
    $scope.paginas=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
    var tabla="recursos";    
    var condicion="employer_id is null";
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",tabla:tabla,condicion:condicion,campos:"id,titulo,fecha,status,ruta"})).success(function(data){
        $scope.recursos=data.records;
    });        
    $scope.cambiarPagina=function(pagina){
        loadingAjax(true);
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",pagina:pagina,tabla:tabla,condicion:"employer_id is null",campos:"id,titulo,fecha,status,ruta"})).success(function(data){
              $scope.recursos=data.records;
              loadingAjax(false);
        });        
    }
    $scope.asignar=function(id,index){
        loadingAjax(true);
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"setRecurso",id:id})).success(function(data){
            if(data.result==="ok"){
                $scope.recursos.splice(index,1);
            }
            loadingAjax(false);
        });
    };
});
moduleApp.controller("ctrlMuros_mensajes", function($scope,httpService) {
    $scope.fondo1="fondo1";
    $scope.fondo2="fondo2";
    $scope.paginas=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
    var tabla="eventos";
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",tabla:tabla,condicion:"eventos_tipos_id=1"})).success(function(data){
          $scope.mensajes=data.records;
    });
    $scope.cambiarPagina=function(pagina){
        loadingAjax(true);
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",pagina:pagina,tabla:tabla,condicion:"eventos_tipos_id=1"})).success(function(data){
              $scope.mensajes=data.records;
              loadingAjax(false);
        });        
    }
    $scope.cambiarStatus=function(id,status){
        if(status==true){
            status=1;
        }else{
            status=0;
        }
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"changeStatus",id:id,status:status,tabla:tabla})).success(function(data){
            console.log(data);
        });                
    };    
});
moduleApp.controller("ctrlMuros_comentarios", function($scope,httpService) {
    $scope.fondo1="fondo1";
    $scope.fondo2="fondo2";
    $scope.paginas=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
    var tabla="eventos_comentarios";
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",tabla:tabla})).success(function(data){
          $scope.comentarios=data.records;
    });
    $scope.cambiarPagina=function(pagina){
        loadingAjax(true);
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getValores",pagina:pagina,tabla:tabla})).success(function(data){
              $scope.comentarios=data.records;
              loadingAjax(false);
        });        
    }
    $scope.cambiarStatus=function(id,status){
        if(status==true){
            status=1;
        }else{
            status=0;
        }
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"changeStatus",id:id,status:status,tabla:tabla})).success(function(data){
            console.log(data);
        });                
    };    
});
moduleApp.controller("ctrlConfiguracion", function($scope,httpService) {
    httpService.get("POST","controladores/c_principal.php",toParams({metodo:"getEmployer"})).success(function(data){ 
        $scope.employer=data.employer;
    });
    $scope.actualizar=function(){
        r=$scope.employer;
        httpService.get("POST","controladores/c_principal.php",toParams({metodo:"updateEmployer",id:r.id,n:r.nombres,a:r.apellidos,d:r.direccion,t:r.telefonos,e:r.email,p:r.password,o:r.observaciones})).success(function(data){ 
            if(data.result==="ok"){
                alert("Actualizado con éxito");
            }else{
                alert("Error inesperado, posiblemente no has realizado modificaciones");
            }
            console.log(data);
        });
    };
});
moduleApp.controller("ctrlAyuda", function($scope,httpService) {
});