<div class="pad20" data-ng-controller="ctrlIndex">
    <div class="container">
        <div class="row">
            <form role="form">
                <br/>
                <center><h2>Nivel de seguridad de la parte administrativa</h2></center>
                <br class="hidden-xs"/>
                <div class="col-xs-hidden col-sm-3"></div>
                <div class="col-xs-12 col-sm-3">
                    <span class="t26 blue">Clave de acceso </span>
                </div>
                <div class="col-xs-12 col-sm-3 col-sm-3">
                    <input type="password" class="form-input" data-ng-model="password" />
                </div>
                <div class="col-xs-hidden col-sm-3"></div>
                <div class="col-xs-12"><br><br></div>
                <div class="col-xs-hidden col-sm-3"></div>
                <div class="col-xs-12 col-sm-6 text-center">
                    <div class="col-xs-12 col-sm-6"><button class="btn btn-primary" data-ng-click="ingresar()">Ingresar</button></div>
                    <div class="col-xs-12 col-sm-6"><button class="btn btn-primary" data-ng-click="limpiar()">Limpiar</button> </div>
                </div>
                <div class="col-xs-hidden col-sm-3"></div>
            </form>
        </div>
    </div>
</div>