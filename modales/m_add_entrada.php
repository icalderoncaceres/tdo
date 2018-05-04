<script>
var archivos=[];
var c=0;
var demo=angular.module('todoAp',[]).controller('GrupoController',['$scope',function ($scope){
    $scope.icono_sel="fa fa-file-word-o";
    $scope.entradas=[];
    $scope.agregar=function (){
        if(document.getElementById("new-file").value==""){
            bandera=0;
        }else{
            bandera=1;
        }
        if($scope.titulo!="" && $scope.titulo!=undefined){
            $scope.entradas.push({               
               icono:$scope.icono_sel,
               titulo:$scope.titulo,
               vinculo:$scope.vinculo,
               archivo:$scope.archivo,
               bandera:bandera,
            });
            $scope.titulo="";
            $scope.vinculo="";
        }
        archivos[c]=document.getElementById("new-file").files[0];
        c++;
        document.getElementById("new-file").value="";
    };
    $scope.seleccionar=function(clase){
        $scope.icono_sel=clase;  
    };
    $scope.bajar=function(indice){
          var aux=$scope.entradas;
          $scope.entradas=[];
          angular.forEach(aux,function(value,key){
              if(key==indice){
                  aux2={titulo:value.titulo,vinculo:value.vinculo,icono:value.icono,bandera:value.bandera};
              }else if(key==indice + 1){
                  $scope.entradas.push({titulo:value.titulo,vinculo:value.vinculo,icono:value.icono,bandera:value.bandera});
                  $scope.entradas.push(aux2);
              }else{
                  $scope.entradas.push(value);
              }
          });
          aux3=archivos[indice];
          archivos[indice]=archivos[indice+1];
          archivos[indice+1]=aux3;
    };
    $scope.subir=function(indice){
          var aux=$scope.entradas;
          $scope.entradas=[];
          angular.forEach(aux,function(value,key){
              if(key==indice-1){
                  aux2={titulo:value.titulo,vinculo:value.vinculo,icono:value.icono,bandera:value.bandera};
              }else if(key==indice){
                  $scope.entradas.push({titulo:value.titulo,vinculo:value.vinculo,icono:value.icono,bandera:value.bandera});
                  $scope.entradas.push(aux2);
              }else{
                  $scope.entradas.push(value);
              }
          });
          aux3=archivos[indice];
          archivos[indice]=archivos[indice-1];
          archivos[indice-1]=aux3;
    };
    $scope.editar=function(indice){
          $scope.icono_sel=$scope.entradas[indice].icono;
          $scope.titulo=$scope.entradas[indice].titulo;
          $scope.vinculo=$scope.entradas[indice].vinculo;
          $scope.bandera=0;
          $scope.entradas.splice(indice,1);
          document.getElementById("new-file").value=archivos(indice);
          archivos.splice(indice,1);
    };
}]);
</script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="add-entrada" data-ng-app="todoAp" data-id="<?php echo $_GET["id"];?>">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title " ><img src="galeria/img/logos/mascota.png" width="60" height="51"><span id="usr-reg-title" class="marL15">Agregar entrada al grupo</span></h3>
			</div>
			<form class="form-inline" id="frm-entrada">
				<div class="modal-body marL20 marR20" data-ng-controller="GrupoController">
					<div class="row">
						<div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 t18" >
							<input type="text" placeholder="Titulo" name="e_titulo" class="form-input" id="e_titulo">
						</div>
                                                <br><br>
        					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 t18" >
                                                    <textarea rows="3" cols="" placeholder="Descripción" id="e_descripcion" name="e_descripcion" class="form-textarea" maxlength="240"></textarea>
                        			</div>
                                                <div class="col-xs-12"><br></div>
        					<div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2 t14" >
                                                    <span>Color </span><input id="e_color" type="color" value="#5959ff"></input>
                        			</div>                                                
        					<div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3 t14" >
                                                    <div class="subir-img-active foto" style="margin-left: 0px;" data-toggle="tooltip" title="Puedes subir una imágen">
                                                        <img class="img-responsive"/>
            						<i style="position: relative; top:-40px; left:110%;" class="fa fa-times red hidden"></i>
                                                    </div>
                        			</div>
        					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 t14" >
                                                    <br>
                                                    <input id="new-file" name="new-file" type="file" />
                        			</div>   
                                                <div class="col-xs-12"><hr></div>
                                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                                    <div class="btn-group " style="margin-top: -5px;">
							  <button type="button" class="btn btn-default btn-xs"><i class="{{icono_sel}}"></i></button>
							  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="caret"></span>
                                                                <span class="sr-only">Toggle Dropdown</span>
							  </button>
							  <ul class="dropdown-menu" >
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-word-o')"><i class="fa fa-file-word-o"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-excel-o')"><i class="fa fa-file-excel-o"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-powerpoint-o')"><i class="fa fa-file-powerpoint-o"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-pdf-o')"><i class="fa fa-file-pdf-o"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-sound-o')"><i class="fa fa-file-sound-o"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-text')"><i class="fa fa-file-text"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-photo-o')"><i class="fa fa-file-photo-o"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-video-o')"><i class="fa fa-file-video-o"></i></a></li>
                                                                <li class="boton-status"><a href="#" data-ng-click="seleccionar('fa fa-file-o')"><i class="fa fa-file-o"></i></a></li>
							  </ul>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5 input">
                                                    <input type="text" placeholder="Titulo" class="form-input" data-ng-model="titulo"/>
                                                </div>
                                                <div class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5 input">
                                                    <input type="text" placeholder="Vinculo si no tiene archivo" class="form-input" data-ng-model="vinculo"/>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                                    <button data-ng-click="agregar()"><span class="t16"> + </span></button>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                    <br>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow: scroll;overflow-x: hidden">
                                                    <ul class="t16">
                                                        <li data-ng-repeat="entrada in entradas">
                                                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                                                <a href="{{entrada.vinculo}}" class="items" data-posicion="{{$index}}" data-bandera="{{entrada.bandera}}">
                                                                    <i class="{{entrada.icono}}"></i> - <span>{{entrada.titulo}}</span> - <span>{{entrada.vinculo}}</span>
                                                                </a>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">                                                                
                                                                <div class="col-xs-4"><i class="fa fa-arrow-up point" data-ng-click="subir($index)" data-ng-if="$index>0"></i></div>
                                                                <div class="col-xs-4"><i class="fa fa-arrow-down point" data-ng-click="bajar($index)" data-ng-if="!$last"></i></div>
                                                                <div class="col-xs-4"><i class="fa fa-pencil-square-o point" data-ng-click="editar($index)"></i></div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>                                  
                                	</div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-guardar-entrada" type="button" class="btn btn-primary2">Guardar</button>
                                </div>
			</form>
		</div>
	</div>
</div>