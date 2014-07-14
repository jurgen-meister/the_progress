<span style="font-size: 25px; font-weight: bold">IMEXPORT</span><span style="font-weight: bold">SRL</span>
<hr style="height: 2px; color: #000; background-color: #000;">
<?php
$reportTypeName = " (DETALLADO) ";
if($initialData['detail'] == "NO"){
	$reportTypeName = " (TOTALES) ";
}
?>		
<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">VENTAS<?php echo $reportTypeName;?>: <?php echo strtoupper($initialData['showByTypeName']);?></div>
<br>

<table class="report-table" border="0" style="border-collapse:collapse; width:100%;">
	<thead>
	<tr style="text-align:center">
		<th style="width:25%">Fecha Inicio:</th>
		<th style="width:25%">Fecha Fin:</th>
		<th style="width:25%">Almacen:</th>
		<th style="width:25%">Tipo de Cambio:</th>
	</tr>
	</thead>
	<tbody>
		<tr style="text-align:center">
			<td><?php echo $initialData['startDate'];?></td>
			<td><?php echo $initialData['finishDate'];?></td>
			<td><?php echo strtoupper($initialData['warehouseName']);?></td>
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
	
	foreach($itemsMovements as $val){ 
	$quantityTotal = 0;
	$countMovements = 0;
	if(isset($val['Movements'])){
		$countMovements = 1;
	}
?>
	<table class="report-table" border="0" style="border-collapse:collapse; width:100%;">
		<tr>
			<td colspan="2" ><span style="font-weight:bold;">Item: </span><?php echo $val['Item']['codeName']; ?></td>
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
				<tr> <th style="width:100%" colspan="13">Ventas</th></tr>
				<tr>
					<th>Fecha</th>
					<th>Codigo</th>
					<th>Codigo <br> Ref</th>
					<th>Nota <br> Remisión</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>Cant. <br> (Uni)</th>
					<th>P.FOB <br><?php echo $currencyAbbr ; ?></th>
					<th>P.FOB x Cant. <br><?php echo $currencyAbbr ; ?></th>
					<th>P.CIF <br><?php echo $currencyAbbr ; ?></th>
					<th>P.CIF x Cant. <br><?php echo $currencyAbbr ; ?></th>
					<th>P.Venta <br><?php echo $currencyAbbr ; ?></th>
					<th>P.Venta x Cant. <br><?php echo $currencyAbbr ; ?></th>
				</tr>
				<?php }else{ //end - detail YES?>
					<th></th>
					<th>Cant. <br> (Uni)</th>
					<th>P.FOB x Cant. <br><?php echo $currencyAbbr ; ?></th>
					<th>P.CIF x Cant. <br><?php echo $currencyAbbr ; ?></th>
					<th>P.Venta x Cant. <br><?php echo $currencyAbbr ; ?></th>
				<?php } //end - detail NO?>
			</thead>
			<tbody>
				<?php foreach($val['Movements'] as $movement){?>
					<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
					<tr style="text-align:center;">
						<td style="text-align:left;" ><?php echo $movement['date'];?></td>
						<td style="text-align:left;"><?php echo $movement['code'];?></td>
						<td style="text-align:left;"><?php echo $movement['doc_code'];?></td>
						<td style="text-align:left;"><?php echo $movement['note_code'];?></td>
						<td style="text-align:left;"><?php echo $movement['customer'];?></td>
						<td style="text-align:left;"><?php echo $movement['salesman'];?></td>
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
				<?php }?>
				<tr style="text-align:center;font-weight:bold;">
					<?php $extraEmptyTotalTds = ""; 
					if($initialData['detail'] == 'YES'){ //start - detail YES
					
					$extraEmptyTotalTds = "<td ></td>";
					?>
					<td colspan="6" style="text-align:right; padding-right: 10px">Total: </td>
					<?php }else{//end - detail YES?>
					<td>Total:</td>
					<?php }//end - detail NO ?>
					<td ><?php echo $quantityTotal; ?></td>
					<?php echo $extraEmptyTotalTds;?>
					<td ><?php echo number_format($val['TotalMovements']['fobQuantityTotal'],2); ?></td>
					<?php echo $extraEmptyTotalTds;?>
					<td ><?php echo number_format($val['TotalMovements']['cifQuantityTotal'],2); ?></td>
					<?php echo $extraEmptyTotalTds;?>
					<td ><?php echo number_format($val['TotalMovements']['saleQuantityTotal'],2); ?></td>
				</tr>
		<?php }else{?>
				<thead>
				<tr> <th style="width:100%" colspan="11">Ventas</th></tr>
				</thead>
				<tbody>
					<tr style="text-align:center;"><td>SIN VENTAS</td></tr>
				</tbody>
		<?php }?>		
	</table>
	<hr style="height: 1px; color: #CCC; background-color: #CCC;">

<?php 
	$globalQuantity = $globalQuantity + $quantityTotal;
	$globalQuantityFOB = $globalQuantityFOB + $val['TotalMovements']['fobQuantityTotal'];
	$globalQuantityCIF = $globalQuantityCIF + $val['TotalMovements']['cifQuantityTotal'];
	$globalQuantitySALE = $globalQuantitySALE + $val['TotalMovements']['saleQuantityTotal'];
	
} //end initial foreach 


if($initialData['detail'] == 'NO'){ //start - detail NO
?>
	<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">TOTAL GLOBAL:</div>
	<br>
	<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
		<tr>
			<th></th>
			<th>Cant. <br> (Uni)</th>
			<th>P.FOB x Cant. <br><?php echo $currencyAbbr ; ?></th>
			<th>P.CIF x Cant. <br><?php echo $currencyAbbr ; ?></th>
			<th>P.Venta x Cant. <br><?php echo $currencyAbbr ; ?></th>
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