<?php
if(!isset($_GET["ivan"])):
	header("Location: index.php");
endif;
include "fcn/incluir-css-js.php";
include_once "clases/bd.php";
$bd=new bd();
$reservaciones=$bd->query("select u.*,r.*,re.nombre as region from usuarios as u,reservaciones as r,regiones as re where u.id=r.usuarios_id and r.status=0 and u.regiones_id=re.id order by fecha desc");
$trafico1=$bd->query("select 
							(select count(id) from trafico where pagina=1) as tota1,
							(select count(id) from trafico where pagina=2) as tota2,
							(select count(id) from trafico where pagina=3) as tota3,
							(select count(id) from trafico where pagina=4) as tota4,
							(select count(id) from trafico where pagina=5) as tota5,
							(select count(id) from trafico where pagina=6) as tota6,
							(select count(id) from trafico where pagina=7) as tota7,
							(select count(id) from trafico where pagina=8) as tota8
							");
$sqlstr="select 
				(select COUNT(id) from usuarios where id in (select usuarios_id from usuariosxstatus where DATE(fecha)=DATE(now()))) as tota1,
				(select COUNT(id) from usuarios where id in (select usuarios_id from usuariosxstatus where WEEKOFYEAR(fecha)=WEEKOFYEAR(now()))) as tota2,
				(select COUNT(id) from usuarios where id in (select usuarios_id from usuariosxstatus where MONTH(fecha)=MONTH(now()) and YEAR(fecha)=YEAR(now()))) as tota3,
				(select COUNT(id) from usuarios) as tota4
		";
$count_usuarios=$bd->query($sqlstr);

						
$usuarios=$bd->query("select u.*,a.email,r.nombre as region,p.nombre as pais from usuarios as u,usuarios_accesos as a,regiones as r, paises as p where u.id=a.usuarios_id and u.regiones_id=r.id and r.paises_id=p.id order by u.id desc limit 30");

$total2=$bd->query("select count(id) as tota from trafico where pagina=6");
$row2=$total2->fetch();
$total3=$bd->query("select count(id) as tota from trafico where pagina=7");
$row3=$total3->fetch();
$total4=$bd->query("select count(id) as tota from usuarios");
$row4=$total4->fetch();

$visitasenglishzone=$bd->query("select u.nombres,u.apellidos,r.nombre as region,p.nombre as pais,t.pagina,count(t.id) as tota from trafico t,usuarios u,regiones r,paises p where " 
							.  "u.regiones_id=r.id and r.paises_id=p.id and u.id=t.usuarios_id group by t.usuarios_id,t.pagina");
?>
<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="js/cropit/cropit.css">
<body>
<div>
	<div class="row">
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>
		<section class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<table class="table table-bordered table-responsive">
				<caption class="text-center t30">New Reservations</caption>
				<thead>
					<tr class="success">
						<th>Number </th>
						<th>Full Name </th>
						<th>Plan </th>
						<th>Region</th>
						<th>Fecha </th>
						<th>Bank ID </th>
						<th>Reference </th>
					</tr>
					<tr></tr>
				</thead>
				<tbody>
					<?php
						$i=0;
						$planes=array("1"=>"Mensual","2"=>"Trimestral","3"=>"Semestral","4"=>"Anual");
						$clase="warning";
						foreach($reservaciones as $r):
							$i++;
							?>
							<tr class="<?php echo $clase;?>">
								<td class="text-right"><?php echo $i; ?></td>
								<td><?php echo utf8_encode($r["nombres"]) . " " . utf8_encode($r["apellidos"]); ?></td>
								<td><?php echo $planes[$r["planes_id"]]; ?></td>
								<td><?php echo $r["region"]; ?></td>
								<td><?php echo date("d/m/y",strtotime($r["fecha"])); ?></td>
								<td><?php echo $r["bancos_id"]; ?></td>
								<td><?php echo $r["referencia"]; ?></td>
							</tr>
						<?php
						endforeach;
					?>
				</tbody>
			</table>			
		</section>
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>
		<div class="col-xs-12"><br></div>
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>
		<section class="col-xs-11 col-sm-11 col-md-5 col-lg-5">
			<table class="table table-bordered table-responsive">
				<caption class="text-center t30">Count Visits</caption>
				<thead>
					<tr class="success">
						<th>Page </th>
						<th>Total visits </th>
					</tr>
					<tr></tr>
				</thead>
				<tbody>
					<?php $t=$trafico1->fetch(); ?>
					<tr class="warning">
						<td>Index</td>
						<td class="text-right"><?php echo $t["tota1"];?></td>
					</tr>
					<tr class="success">
						<td>Foros</td>
						<td class="text-right"><?php echo $t["tota2"];?></td>
					</tr>
					<tr class="danger">
						<td>Recursos</td>
						<td class="text-right"><?php echo $t["tota3"];?></td>
					</tr>
					<tr class="active">
						<td>Articulos</td>
						<td class="text-right"><?php echo $t["tota4"];?></td>
					</tr>
					<tr class="warning">
						<td>Espacio virtual</td>
						<td class="text-right"><?php echo $t["tota5"];?></td>
					</tr>					
					<tr class="success">
						<td>Main zonaingles</td>
						<td class="text-right"><?php echo $t["tota6"];?></td>
					</tr>
					<tr class="active">
						<td>Try System</td>
						<td class="text-right"><?php echo $t["tota7"];?></td>
					</tr>
					<tr class="danger">
						<td>Zonaingles without ID</td>
						<td class="text-right"><?php echo $t["tota8"];?></td>
					</tr>
				</tbody>
				<thead>
					<tr>
						<th>Total</th>
						<th class="text-right"><?php echo $t["tota1"] + $t["tota2"] + $t["tota3"] + $t["tota4"] + $t["tota5"] + $t["tota6"] + $t["tota7"] + $t["tota8"];?></th>
					</tr>
				</thead>
			</table>
		</section>
		<section class="col-xs-1 col-sm-1 hidden-md hidden-lg"></section>
		<section class="col-xs-11 col-sm-11 col-md-5 col-lg-5">
			<table class="table table-bordered table-responsive">
				<caption class="text-center t30">Count Users</caption>
				<thead>
					<tr class="success">
						<th>When </th>
						<th>Count </th>
					</tr>
					<tr></tr>
				</thead>
				<tbody>
					<?php $u=$count_usuarios->fetch();?>
					<tr class="warning">
						<td>Today</td>
						<td class="text-right"><?php echo $u["tota1"];?></td>
					</tr>
					<tr class="active">
						<td>This week</td>
						<td class="text-right"><?php echo $u["tota2"];?></td>
					</tr>
					<tr class="success">
						<td>This month</td>
						<td class="text-right"><?php echo $u["tota3"];?></td>
					</tr>
					<tr class="danger">
						<td>Total</td>
						<td class="text-right"><?php echo $u["tota4"];?></td>
					</tr>		
				</tbody>
				<thead>
					<tr>
						<th>Total</th>
						<th class="text-right"><?php echo $u["tota1"] + $u["tota2"] + $u["tota3"] + $u["tota4"];?></th>
					</tr>
				</thead>				
			</table>
		</section>
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>		
		<div class="col-xs-12"><br></div>
		
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>
		<section class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<table class="table table-bordered table-responsive">
				<caption class="text-center t30">Last Users</caption>
				<thead>
					<tr class="success">
						<th>Number </th>
						<th>Full Name </th>
						<th>Region </th>
						<th>Country</th>
						<th>Tel&eacute;fonos </th>
						<th>Email </th>
					</tr>
					<tr></tr>
				</thead>
				<tbody>
					<?php
						$i=0;
						$clase="success";
						foreach($usuarios as $u):
							$i++;
							switch($clase){
								case "success":
									$clase="active";
									break;
								case "active":
									$clase="warning";
									break;
								case "warning":
									$clase="danger";
									break;
								case "danger":
									$clase="success";
									break;			
							}
							?>
							<tr class="<?php echo $clase;?>">
								<td class="text-right"><?php echo $i; ?></td>
								<td><?php echo utf8_encode($u["nombres"]) . " " . utf8_encode($u["apellidos"]); ?></td>
								<td><?php echo $u["region"]; ?></td>
								<td><?php echo $u["pais"]; ?></td>
								<td><?php echo $u["telefonos"]; ?></td>
								<td><?php echo $u["email"]; ?></td>
							</tr>
						<?php
						endforeach;
					?>
				</tbody>
			</table>
		</section>
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>
		<div class="col-xs-12"><br></div>
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>
		<section class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<table class="table table-bordered table-responsive">
				<caption class="text-center t30">Moves by users</caption>
				<thead>
					<tr class="success">
						<th>Number </th>
						<th>Full Name </th>
						<th>Region</th>
						<th>Country</th>
						<th>Page</th>
						<th>Count </th>
					</tr>
					<tr></tr>
				</thead>
				<tbody>
					<?php
						$i=0;$ac=0;$clase="success";				
						$planes=array("1"=>"Mensual","2"=>"Trimestral","3"=>"Semestral","4"=>"Anual");
						foreach($visitasenglishzone as $v):
							$i++;$ac+=$v["tota"];
							$paginas=array("","Index","Foros","Recursos","Articulos","Espacio Virtual","Zonaingles","EnglishZone","Zonaingles Without ID");
							switch($clase){
								case "success":
									$clase="active";
									break;
								case "active":
									$clase="warning";
									break;
								case "warning":
									$clase="danger";
									break;
								case "danger":
									$clase="success";
									break;			
							}							
							?>
							<tr class="<?php echo $clase;?>">
								<td class="text-right"><?php echo $i; ?></td>
								<td><?php echo utf8_encode($v["nombres"]) . " " . utf8_encode($v["apellidos"]); ?></td>
								<td><?php echo $v["region"]; ?></td>
								<td><?php echo $v["pais"]; ?></td>
								<td><?php echo $paginas[$v["pagina"]]; ?></td>
								<td class="text-right"><?php echo $v["tota"]; ?></td>
							</tr>
						<?php
						endforeach;
					?>
				</tbody>
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>Total</th>
						<th class="text-right"><?php echo $ac;?></th>
					</tr>
				</thead>			
			</table>			
		</section>
		<section class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></section>		
	</div>
</div>
</body>
</html>
<!--
$var_1 = 'PHP IS GREAT';
$var_2 = 'WITH MYSQL';

similar_text($var_1, $var_2, $percent);

echo $percent;
// 27.272727272727

similar_text($var_2, $var_1, $percent);

echo $percent;
// 18.181818181818 
-->