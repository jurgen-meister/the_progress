<span style="font-size: 30px; font-weight: bold">IMEXPORT</span><span style="font-weight: bold">SRL</span>
<div style="height: 2px; background-color: black"></div>
<?php
	switch ($movement['InvMovement']['lc_state']){
		case 'PENDANT':
			$stateName = 'PENDIENTE';
			break;
		case 'APPROVED':
			$stateName = 'APROBADO';
			break;
		case 'CANCELLED':
			$stateName = 'CANCELADO';
			break;
	}
	switch ($movement['InvMovementType']['status']){
		case 'entrada':
			$documentType = 'ENTRADA DE ALMACEN: ';
			break;
		case 'salida':
			$documentType = 'SALIDA DE ALMACEN: ';
			if($movement['InvMovementType']['id'] == 3){$documentType = 'TRASPASO ENTRE ALMACENES: ';}
			break;
	}
?>
<table style="width:100%">
	<tr>
		<td align="right"><span class="report-title"><?php echo $documentType;?></span><?php echo $stateName;?></td>
	</tr>
</table>
<br>

<?php if($movement['InvMovementType']['id'] == 3){?>
<p><span class="report-title">Codigo: </span><?php echo $movement['InvMovement']['document_code'];?></p>
<?php }else{?>
<p><span class="report-title">Codigo: </span><?php echo $movement['InvMovement']['code'];?></p>
<?php }?>

<?php if($movement['InvMovementType']['id'] == 3){?>
<p><span class="report-title">Codigo Documentos Referencia: </span><?php echo $movement['InvMovement']['code'].', '.$movement['Transfer']['code'] ;?></p>
<?php }else{?>
<p><span class="report-title">Codigo Documento Referencia: </span><?php echo $movement['InvMovement']['document_code'];?></p>
<?php }?>


<p><span class="report-title">Fecha: </span><?php echo date("d/m/Y", strtotime($movement['InvMovement']['date']));?></p>
<?php if($movement['InvMovementType']['id'] == 3){
		$nameWarehouse = 'Almacen Origen(Salida): ';
		$objectWarehouse2 = '<p><span class="report-title">Almacen Destino(Entrada): </span>'.$movement['Transfer']['warehouseName'].'</p>';
	}else{
		$nameWarehouse = 'Almacen: ';
		$objectWarehouse2='';
	}
	
?>
<p><span class="report-title"><?php echo $nameWarehouse;?></span><?php echo $movement['InvWarehouse']['name'];?></p>
<?php echo $objectWarehouse2;?>
<p><span class="report-title">Tipo Movimiento: </span><?php echo $movement['InvMovementType']['name'];?></p>
<p><span class="report-title">Descripción: </span><?php echo $movement['InvMovement']['description'];?></p>

<br>

<table class="report-table" border="1" bordercolor="red" style="border-collapse:collapse;">
							<thead>
								<tr>
									<th style="width:50%">Item (unidad)</th>
									<!--<th style="width:25%">Stock</th>-->
									<th style="width:25%">Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($i=0; $i<count($details); $i++){
									echo '<tr >';
										echo '<td style="width:40%">'.$details[$i]['item'].'</td>';
										//echo '<td style="width:20%" align="center">'.$details[$i]['stock'].'</td>';
										echo '<td style="width:20%" align="center">'.$details[$i]['cantidad'].'</td>';
									echo '</tr>';								
								}
								?>
							</tbody>
						</table>

<style type="text/css">
	.report-title{
		font-weight: bold
	}
	.report-table{
		width: 100%
	}
</style>
