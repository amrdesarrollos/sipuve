<div class="row">


	<div class="col-md-12">
<!-- Single button -->
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/inventary-word.php">Word 2007 (.docx)</a></li>
  </ul>
</div>
		<h1><i class="glyphicon glyphicon-stats"></i> Inventario de Productos</h1>
		<div class="clearfix"></div>
	<div class="col-md-12">
		<form>
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="view" value="inventary">
				<input type="text" name="product" class="form-control">
			</div>
			<div class="col-md-3">
			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
			</div>
		</div>
		</form>
	</div>

<?php
$page = 1;
if(isset($_GET["page"])){
	$page=$_GET["page"];
}
$limit=10;
if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
	$limit=$_GET["limit"];
}
if(isset($_GET["product"])){
	$products = ProductData::getLike($_GET["product"]);
} else {
	$products = ProductData::getAll("");
}

if(count($products)>0){

if($page==1){
	if(isset($_GET["product"])){
		$curr_products = ProductData::getAllByPage($products[0]->cons,$limit,$_GET["product"]);
	} else {		
		$curr_products = ProductData::getAllByPage($products[0]->cons,$limit,"");
	}
}else{
	if(isset($_GET["product"])){
		$curr_products = ProductData::getAllByPage($products[($page-1)*$limit]->cons,$limit,$_GET["product"]);
	} else {		
		$curr_products = ProductData::getAllByPage($products[($page-1)*$limit]->cons,$limit,"");
	}
}
$npaginas = floor(count($products)/$limit);
 $spaginas = count($products)%$limit;

if($spaginas>0){ $npaginas++;}

	?>

	<h3>Pagina <?php echo $page." de ".$npaginas; ?></h3>
<div class="btn-group pull-right">
<?php
$px=$page-1;
if($px>0):
?>
<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventary&limit=$limit&page=".($px)."&product=".$_GET["product"]; ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atras </a>
<?php endif; ?>

<?php 
$px=$page+1;
if($px<=$npaginas):
?>
<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=inventary&limit=$limit&page=".($px)."&product=".$_GET["product"]; ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
<?php endif; ?>
</div>
<div class="clearfix"></div>
<br><table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Talla</th>
		<th>Color</th>
		<th>Reservado</th>
		<th>Disponible</th>
		<th></th>
	</thead>
	<?php foreach($curr_products as $product):
	$q=OperationData::getQYesF($product->id);
	$r=OperationData::getReservado($product->id);
	?>
	<tr class="<?php if($q<=$product->inventary_min/2){ echo "danger";}else if($q<=$product->inventary_min){ echo "warning";}?>">
		<td><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><?php if($product->talla_id!=null){echo $product->getTalla()->name;}else{ echo "<center>----</center>"; } ?></td>
		<td><?php if($product->color_id!=null){echo $product->getColor()->name;}else{ echo "<center>----</center>"; } ?></td>
		<td><?php echo $r; ?></td>
		<td><?php echo $q; ?></td>
		<td style="width:93px;">
<!--		<a href="index.php?view=input&product_id=<?php echo $product->id; ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-circle-arrow-up"></i> Alta</a>-->
		<a href="index.php?view=history&product_id=<?php echo $product->id; ?>" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-time"></i> Historial</a>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div class="btn-group pull-right">
<?php

for($i=0;$i<$npaginas;$i++){
	echo "<a href='index.php?view=inventary&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
}
?>
</div>
<form class="form-inline">
	<label for="limit">Limite</label>
	<input type="hidden" name="view" value="inventary">
	<input type="number" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
</form>

<div class="clearfix"></div>

	<?php
}else{
	?>
	<div class="jumbotron">
		<h2>No hay productos</h2>
		<p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Producto"</b>.</p>
	</div>
	<?php
}

?>
<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>