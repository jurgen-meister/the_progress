<span style="font-size: 25px; font-weight: bold">IMEXPORT</span><span style="font-weight: bold">SRL</span>
<hr style="height: 2px; color: #000; background-color: #000;">
<?php
$reportTypeName = " (DETALLADO) ";
if($initialData['detail'] == "NO"){
	$reportTypeName = " (TOTALES) ";
}
?>	
<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">MOVIMIENTOS DE ALMACEN<?php echo $reportTypeName;?>: <?php echo strtoupper($initialData['movementTypeName']);?></div>
<br>
<table class="report-table" border="0" style="border-collapse:collapse; width:100%;">
	<thead>
	<tr style="text-align:center">
		<th style="width:20%">Fecha Inicio:</th>
		<th style="width:20%">Fecha Fin:</th>
		<th style="width:20%">Almacen</th>
		<th style="width:20%">Almacen a Comparar</th>
		<th style="width:20%">Tipo de Cambio:</th>
	</tr>
	</thead>
	<tbody>
		<tr style="text-align:center">
			<td><?php echo $initialData['startDate'];?></td>
			<td><?php echo $initialData['finishDate'];?></td>
			<td><?php echo $initialData['warehouseName'];?></td>
			<td><?php echo $initialData['warehouseName2'];?></td>
			<td><?php echo $initialData['currency'];?></td>
		</tr>
	</tbody>
</table>
<hr style="height: 1px; color: #444; background-color: #444;">
<?php 
	$currencyAbbr = $initialData['currencyAbbreviation'];
	
	$globalQuantity = 0;
	$globalQuantityFOB = 0;
	$globalQuantityCIF = 0;
	$globalQuantitySALE = 0;
	
	$fobQuantityTotalDivided = 0;
	$cifQuantityTotalDivided = 0;
	$saleQuantityTotalDivided = 0;
	
	$warehousesInOut = array($initialData['warehouse']=>$initialData['warehouseName'], $initialData['warehouse2']=>$initialData['warehouseName2']);
	foreach($itemsMovements as $val){ 
	$quantityTotal = 0;
	$countMovements = 0;
	
	if(isset($val['Movements'])){
		$countMovements = 1;
	}
	$counter = 1;
?>
	<table class="report-table" border="0" style="border-collapse:collapse; width:100%;">
		<tr>
			<td colspan="2" ><span style="font-weight:bold;">Producto: </span><?php echo $val['Item']['codeName']; ?></td>
		</tr>
		<tr>
			<td><span style="font-weight:bold;">Categoria: </span><?php echo $val['Item']['category']; ?></td>
			<td><span style="font-weight:bold;">Marca: </span><?php echo $val['Item']['brand']; ?></td>
		</tr>
	</table>	
	<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
		<?php if($countMovements == 1){?>
			<thead>
				<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
				<tr> <th style="width:100%" colspan="10">Movimientos</th></tr>
				<tr >
					<th colspan="4" style="text-align:right;"></th>
					<th colspan="4">Compra</th>
					<th colspan="2">Venta</th>
				</tr>
				<tr>
					<th>Fecha</th>
					<!--<th>Codigo <br> Transferencia</th>-->
					<!--<th>Codigo <br> Salida</th>-->
					<!--<th>Codigo <br> Entrada</th>-->
					<th>Almacen <br> Origen <br> (Salida)</th>
					<th>Almacen <br> Destino <br> (Entrada)</th>
					<th>Cantidad <br> (Unidad)</th>
					<th>Precio Unitario FOB <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Total FOB <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Unitario CIF <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Total FOB <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Unitario Venta <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Total Venta<br><?php echo $currencyAbbr ; ?></th>
				</tr>
				<?php }else{ //end - detail YES?>
				<tr >
					<th colspan="2" style="text-align:right;"></th>
					<th colspan="2">Compra</th>
					<th colspan="1">Venta</th>
				</tr>
				<tr>
					<th></th>
					<th>Cantidad <br> (Unidad)</th>
					<th>Precio FOB <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio CIF <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Venta<br><?php echo $currencyAbbr ; ?></th>
				</tr>
				<?php } //end - detail NO?>
			</thead>
			<tbody>
			<?php foreach($val['Movements'] as $movement){?>
				<?php 
					if(($counter % 2) == 1){
						$codeIN = $movement['code'];
						$warehouseIN = $movement['warehouse'];
					}
					if(($counter % 2) == 0){ 
						$codeOUT = $movement['code'];
						$warehouseOUT = $movement['warehouse'];
				?>
					
					<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
					<tr style="text-align:center;">
						<td style="text-align:left;" ><?php echo $movement['date'];?></td>
						<!--<td style="text-align:left;"><?php //echo $movement['document_code'];?></td>-->
						<!--<td style="text-align:left;"><?php //echo $codeOUT;?></td>-->
						<!--<td style="text-align:left;"><?php //echo $codeIN;?></td>-->
						<td style="text-align:left;"><?php echo $warehousesInOut[$warehouseOUT];?></td>
						<td style="text-align:left;"><?php echo $warehousesInOut[$warehouseIN];?></td>
						<td style="font-weight:bold;"><?php echo $movement['quantity'];?></td>
						<td ><?php echo $movement['fob'];?></td>
						<td style="font-weight:bold;"><?php echo number_format($movement['fobQuantity'],2);?></td>
						<td ><?php echo $movement['cif'];?></td>
						<td style="font-weight:bold;"><?php echo number_format($movement['cifQuantity'],2);?></td>
						<td ><?php echo $movement['sale'];?></td>
						<td style="font-weight:bold;"><?php echo number_format($movement['saleQuantity'],2);?></td>
					</tr>
					<?php } //end - detail YES?>
					
					<?php $quantityTotal = $quantityTotal + $movement['quantity'];?>
					<?php } $counter++;  //module?>
			<?php }//foreach movement?>		
					<tr style="text-align:center;font-weight:bold;">
						<?php $extraEmptyTotalTds = ""; 
						if($initialData['detail'] == 'YES'){ //start - detail YES

						$extraEmptyTotalTds = "<td ></td>";
						?>
						
						<td colspan="3" style="text-align:right; padding-right: 10px">Total: </td>
						<?php }else{//end - detail YES?>
						<td>Total:</td>
						<?php }//end - detail NO ?>
						
						<td ><?php echo $quantityTotal; ?></td>
						<?php echo $extraEmptyTotalTds;?>
						<?php $fobQuantityTotalDivided=($val['TotalMovements']['fobQuantityTotal'] / 2);?>
						<td ><?php echo number_format($fobQuantityTotalDivided,2); ?></td>
						<?php echo $extraEmptyTotalTds;?>
						<?php $cifQuantityTotalDivided=($val['TotalMovements']['cifQuantityTotal'] / 2);?>
						<td ><?php echo number_format($cifQuantityTotalDivided,2); ?></td>
						<?php echo $extraEmptyTotalTds;?>
						<?php $saleQuantityTotalDivided=($val['TotalMovements']['saleQuantityTotal'] / 2);?>
						<td ><?php echo number_format($saleQuantityTotalDivided,2); ?></td>
					</tr>
		<?php }else{?>
				<thead>
				<tr> <th style="width:100%" colspan="10">Movimientos</th></tr>
				</thead>
				<tbody>
					<tr style="text-align:center;"><td>SIN MOVIMIENTOS</td></tr>
				</tbody>
		<?php }?>		
	</table>
	<hr style="height: 1px; color: #CCC; background-color: #CCC;">

<?php 
	if($countMovements == 1){
		$globalQuantity = $globalQuantity + $quantityTotal;
		//debug($fobQuantityTotalDivided);
		$globalQuantityFOB = $globalQuantityFOB + $fobQuantityTotalDivided;
		$globalQuantityCIF = $globalQuantityCIF + $cifQuantityTotalDivided;
		$globalQuantitySALE = $globalQuantitySALE + $saleQuantityTotalDivided;
	}
} //end initial foreach 


if($initialData['detail'] == 'NO'){ //start - detail NO
?>
	<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">TOTAL GLOBAL:</div>
	<br>
	<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
		<tr >
			<th colspan="2" style="text-align:right;"></th>
			<th colspan="2">Compra</th>
			<th colspan="1">Venta</th>
		</tr>
		<tr>
			<th></th>
			<th>Cantidad <br> (Unidad)</th>
			<th>Precio FOB<br><?php echo $currencyAbbr ; ?></th>
			<th>Precio CIF<br><?php echo $currencyAbbr ; ?></th>
			<th>Precio Venta<br><?php echo $currencyAbbr ; ?></th>
		</tr>
		<tr style="text-align:center;font-weight:bold;">
			<td>TOTAL:</td>
			<td><?php echo $globalQuantity;?></td>
			<td><?php echo number_format($globalQuantityFOB,2);?></td>
			<td><?php echo number_format($globalQuantityCIF,2);?></td>
			<td><?php echo number_format($globalQuantitySALE,2);?></td>
		</tr>
	</table>	
	<br>
<?php	
}
?>