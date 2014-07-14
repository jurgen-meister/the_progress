<?php 
$countKardexWarehouses = count($kardexWarehouses); 
//debug($kardexWarehouses);
$columnColors = array("Yellow", "LightGreen", "SkyBlue", "Coral", "DarkGray", "LightSalmon", "YellowGreen", "PowderBlue", "SandyBrown", "Thistle");
?>
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
	//debug($initialData['detail']);
	$currencyAbbr = $initialData['currencyAbbreviation'];
	$globalStock = 0;
	$globalMultipleStock = array();
	$globalQuanttityIn = 0;
	$globalQuanttityOut = 0;
	$globalQuantityFOB = 0;
	$globalQuantityCIF = 0;
	$globalQuantitySALE = 0;
	
	$finalFOB = 0;
	$finalCIF = 0;
	$finalSale = 0;
	
	$finalFOBGlobal = 0;
	$finalCIFGlobal = 0;
	$finalSaleGlobal = 0;
	
	foreach($itemsMovements as $val){ 
	$quantityTotal = 0;
	$stockQuantity = 0;
	$multipleStock = array();
	$inQuantityTotal = 0;
	$outQuantityTotal = 0;
	//$stock=0;
	$countMovements = 0;
	$colspanTableHeader = 5;
	if(isset($val['Movements'])){
		$countMovements = 1;
		$colspanTableHeader = 13;
	}
	//debug($initialStocks);
	if($countKardexWarehouses == 0){
		foreach ($initialStocks as $valStock) {
			if($valStock['InvMovementDetail']['inv_item_id'] == $val['Item']['id']){
				$stockQuantity=$valStock[0]['stock'];
			}
		}
	}else{
		foreach($kardexWarehouses as $key => $nm){
//			debug($initialStocks);
			$multipleStock[$key] = 0;
			foreach ($initialStocks[$key] as $valStock) {
				if($valStock['InvMovementDetail']['inv_item_id'] == $val['Item']['id']){
					$multipleStock[$key] = $valStock[0]['stock'];
				}
			}
//			debug($key);
//			debug($multipleStock);
		}
	}
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
		
		<thead>
			<tr> <th style="width:100%" colspan="<?php echo $colspanTableHeader;?>">Movimientos</th></tr>
			<?php if($countMovements == 1){ ?>
			
			<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
			<tr >
				<th colspan="5" style="text-align:right; padding-right: 10px">Saldo Inicial:</th>
				 
					<?php 
					//debug($multipleStock);
					if($countKardexWarehouses == 0){
						echo '<th style="background-color:'.$columnColors[0].'">'.$stockQuantity.'</th>'; 
					}else{
						//for($i=0; $i < $countKardexWarehouses; $i++){
						$counterColor = 0;
						/*
						foreach($multipleStock as $ms){
							echo '<th style="background-color:'.$columnColors[$counterColor].'">'.$ms.'</th>';	
							$counterColor++;
						}
						*/
						foreach ($kardexWarehouses as $key3 => $value3) {
							$multiplevalue =0;
							if(isset($multipleStock[$key3])){
								$multiplevalue = $multipleStock[$key3];
							}
							echo '<th style="background-color:'.$columnColors[$counterColor].'">'.$multiplevalue.'</th>';	
							$counterColor++;
						}
						
					}	
					?>
				
				
				<th colspan="4">Compra</th>
				<th colspan="2">Venta</th>
			</tr>	
			
			
				
				<tr>
					<th>Fecha</th>
					<th>Tipo Movimiento</th>
					<th>Nota <br> Remisión</th>
					<th>Cantidad Entrada <br>(Unidad)</th>
					<th>Cantidad Salida<br>(Unidad)</th>
					<?php if($countKardexWarehouses == 0){?>
						<th style="background-color:<?php echo $columnColors[0]; ?>">Saldo <br> (Unidad)</th>
					<?php }else{ 
						$counterColors1=0;
						foreach($kardexWarehouses as $value){
							echo '<th style="background-color:'.$columnColors[$counterColors1].';"> Saldo <br> '.$value.'<br>(Unidad)</th>';
							$counterColors1++;
						}
					}?>
					<th>Precio Unitario FOB <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Total FOB <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Unitario CIF <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Total CIF <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Unitario Venta <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Total Venta<br><?php echo $currencyAbbr ; ?></th>
				</tr>
				<?php }else{ //end - detail YES => start detail NO?>
				<tr >
					<th colspan="<?php echo (2 + $countKardexWarehouses);?>" style="text-align:right;"></th>
					<th colspan="2">Compra</th>
					<th colspan="1">Venta</th>
				</tr>	
				<tr>
					<th></th>
					<?php
					if($countKardexWarehouses == 0){?>
						<th>Saldo <br> (Unidad)</th>
					<?php }else{ 
						foreach($kardexWarehouses as $value){
							echo "<th> Saldo <br> ".$value."<br>(Unidad)</th>";
						}
						echo "<th> Saldo Todos los Almacenes <br> (Unidad)</th>";
					}?>
					
					<th>Precio FOB<br><?php echo $currencyAbbr ; ?></th>
					<th>Precio CIF <br><?php echo $currencyAbbr ; ?></th>
					<th>Precio Venta <br><?php echo $currencyAbbr ; ?></th>
				</tr>
				<?php } //end - detail NO?>
			<?php }else{?>
				<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
			<tr >
				<th  style="text-align:right; padding-right: 10px; width: 50%;">Saldo Inicial:</th>
				<th  style="text-align:left; padding-left: 10px; width: 50%;"><?php echo $stockQuantity; ?></th>
			</tr>	
				<?php }//end - detail YES?>	
			<?php }?>
		</thead>

		<tbody>
			<?php 
				if($countMovements == 1){
					foreach($val['Movements'] as $movement){
			?>
			
			<?php
				$inQuantity = '-';
				$outQuantity = '-';
				if($countKardexWarehouses == 0){
					if($movement['status'] == 'entrada'){
						$inQuantity = $movement['quantity'];
						$stockQuantity = $stockQuantity + $inQuantity;
						$inQuantityTotal = $inQuantityTotal + $inQuantity;  
					}else{//salida
						$outQuantity = $movement['quantity'];
						$stockQuantity = $stockQuantity - $outQuantity;
						$outQuantityTotal = $outQuantityTotal + $outQuantity;  
					}
				}else{
					if($movement['status'] == 'entrada'){
						$inQuantity = $movement['quantity'];
//						debug($multipleStock);
//						debug($movement['warehouse']);
							$multipleStock[$movement['warehouse']] = $multipleStock[$movement['warehouse']] + $inQuantity;
						
						$inQuantityTotal = $inQuantityTotal + $inQuantity;  
					}else{//salida
						$outQuantity = $movement['quantity'];
							$multipleStock[$movement['warehouse']] = $multipleStock[$movement['warehouse']] - $outQuantity;
						$outQuantityTotal = $outQuantityTotal + $outQuantity;  
					}
				}
				
				//debug($stockQuantity);
			?>
			
			<?php 
			$finalFOB = $movement['fob'];
			$finalCIF = $movement['cif'];
			$finalSale = $movement['sale'];
			?>
			<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
					<tr style="text-align:center;">
						<td style="text-align:left;" ><?php echo $movement['date'];?></td>
						<td style="text-align:left;">
							<?php 
							//echo $movement['code'];
							$movementType = "Entrada";
							if(substr($movement['code'], 0, 3) == "SAL"){
								$movementType = "Salida";
							}
							$tokenMovement = substr($movement['document_code'], 0, 3);
							if( $tokenMovement == "TRA"){
								$movementType .= " (Traspaso)";
							}elseif($tokenMovement == "VEN"){
								$movementType .= " (Venta)";
							}elseif($tokenMovement == "COM"){
								$movementType .= " (Compra)";
							}
							echo $movementType;
							//echo $movement['document_code'];
							?>
						</td>
						<td style="text-align:left;"><?php echo $movement['note_code'];?></td>
						
						<td style="font-weight:bold;"><?php echo $inQuantity;?></td>
						<td style="font-weight:bold;"><?php echo $outQuantity;?></td>
						
						<?php if($countKardexWarehouses == 0){ //if single?>
						<td style="font-weight:bold;text-align:center;background-color:<?php echo $columnColors[0];?>"><?php echo $stockQuantity;?></td>
						<?php }else{//if multiple
							//d+ehbug($multipleStock);
	                            $counterColors2 = 0;
								foreach ($kardexWarehouses as $key2 => $value2) {
									$tokenStyleBold = "";
									if($key2 == $movement["warehouse"]){
										$tokenStyleBold = "font-weight:bold;";
									}
									//use multiple value and isset for fix when there is no stock registered in a warehouse
									$multiplevalue =0;
									if(isset($multipleStock[$key2])){
										$multiplevalue = $multipleStock[$key2];
									}
									
									echo '<td style="background-color:'.$columnColors[$counterColors2].';text-align:center;'.$tokenStyleBold.'">'.$multiplevalue.'</td>'; 
								$counterColors2++;
								}
						}?>
						<td ><?php echo $movement['fob'];?></td>
						<td style="font-weight:bold;"><?php echo number_format($movement['fobQuantity'],2);?></td>
						<td ><?php echo $movement['cif'];?></td>
						<td style="font-weight:bold;"><?php echo number_format($movement['cifQuantity'],2);?></td>
						<td ><?php echo $movement['sale'];?></td>
						<td style="font-weight:bold;"><?php echo number_format($movement['saleQuantity'],2);?></td>
					</tr>
					<?php $quantityTotal = $quantityTotal + $movement['quantity'];?>
			<?php } //end - detail YES?>

		<?php } //MOVEMENTS loop ends ?>
			
			<?php 
			//////START values NO DETAIL
			if($initialData['detail'] == 'NO'){ //only when global?>
					<tr style="text-align:center;font-weight:bold;">
						<?php 
						$extraEmptyTotalTds = "<td ></td>";
						if($initialData['detail'] == 'YES'){ //start - detail YES?>
						<td colspan="4" style="text-align:right; padding-right: 10px">Total: </td>
						<?php }else{//end - detail YES ?>
						<td>Total: </td>
						<?php 
							$extraEmptyTotalTds = "";
						}//end - detail NO
						?>
						
						
						
						<?php
						
						if($countKardexWarehouses == 0){ //A Single Stock
							$finalFOBTemp = $stockQuantity * $val['Item']['last_fob'];
							$finalCIFTemp = $stockQuantity * $val['Item']['last_cif'];
							$finalSaleTemp = $stockQuantity * $val['Item']['last_sale'];
							$finalFOBGlobal = $finalFOBGlobal + $finalFOBTemp;
							$finalCIFGlobal = $finalCIFGlobal + $finalCIFTemp;
							$finalSaleGlobal = $finalSaleGlobal + $finalSaleTemp;
						?>
						<td ><?php echo $stockQuantity; ?></td>
						<td ><?php echo number_format($finalFOBTemp,2); ?></td>
						<td ><?php echo number_format($finalCIFTemp,2); ?></td>
						<td ><?php echo number_format($finalSaleTemp,2); ?></td>
						
						<?php
						}else{//A Multiple Stock
							//debug($multipleStock);
							$sumMultipleQuantityNoDetail = 0;
							foreach ($kardexWarehouses as $key2 => $value2) {
								echo '<td style="text-align:center;">'.$multipleStock[$key2].'</td>'; 
								$sumMultipleQuantityNoDetail = $sumMultipleQuantityNoDetail + $multipleStock[$key2];
								if(isset($globalMultipleStock[$key2])){
									$globalMultipleStock[$key2] = $globalMultipleStock[$key2] + $multipleStock[$key2];
								}else{
									$globalMultipleStock[$key2] = $multipleStock[$key2];
								}
							}
							echo '<td style="text-align:center;">'.$sumMultipleQuantityNoDetail.'</td>';
							$globalStock = $globalStock + $sumMultipleQuantityNoDetail;
							$finalFOBTemp = $sumMultipleQuantityNoDetail * $val['Item']['last_fob'];
							$finalCIFTemp = $sumMultipleQuantityNoDetail * $val['Item']['last_cif'];
							$finalSaleTemp = $sumMultipleQuantityNoDetail * $val['Item']['last_sale'];
							$finalFOBGlobal = $finalFOBGlobal + $finalFOBTemp;
							$finalCIFGlobal = $finalCIFGlobal + $finalCIFTemp;
							$finalSaleGlobal = $finalSaleGlobal + $finalSaleTemp;
						?>
							<td ><?php echo number_format($finalFOBTemp,2); ?></td>
							<td ><?php echo number_format($finalCIFTemp,2); ?></td>
							<td ><?php echo number_format($finalSaleTemp,2); ?></td>
						<?php }//A?>
					</tr>
			<?php } 
			//FINISH VALUES NO DETAIL ?>

					
					
					
					
					
				<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
				<tr style="font-weight:bold;">
					
				<th colspan="5" style="text-align:right; padding-right: 10px">Saldo Final:</td>
				<?php if($countKardexWarehouses == 0){
					echo '<td style="text-align:center;background-color:'.$columnColors[0].'">'.$stockQuantity.'</td>';
				}else{
					$counterColors3=0;
					foreach ($kardexWarehouses as $key3 => $value3) {
						$multiplevalue =0;
						if(isset($multipleStock[$key3])){
							$multiplevalue = $multipleStock[$key3];
						}
						echo '<td style="text-align:center; background-color:'.$columnColors[$counterColors3].';">'.$multiplevalue.'</td>';
						$counterColors3++;
					}
				}
?>
				<th colspan="6"></td>
				<?php }//end - detail YES?>	
			</tr>	
			<?php }else{//$countMovements == 1 ?>
					<tr style="text-align:center;">
						<td colspan="5">SIN MOVIMIENTOS</td>
					</tr>
					<?php if($initialData['detail'] == 'YES'){ //start - detail YES?>
						<tr>
							<td  style="text-align:right; padding-right: 10px; font-weight:bold; width: 50%;">Saldo Final: </td>
							<td  style="text-align:left; padding-left: 10px; font-weight:bold; width: 50%;"><?php echo $stockQuantity; ?></td>
						</tr>
					<?php }else{//end - detail YES => starts detail NO?>	
					<!------------------------------------------------->
					<tr >
						<th colspan="2" style="text-align:right;"></th>
						<th colspan="2">Compra</th>
						<th colspan="1">Venta</th>
					</tr>	
					<tr>
						<th></th>
						<th>Saldo <br> (Unidad)</th>
						<th>Precio FOB<br><?php echo $currencyAbbr ; ?></th>
						<th>Precio CIF <br><?php echo $currencyAbbr ; ?></th>
						<th>Precio Venta <br><?php echo $currencyAbbr ; ?></th>
					</tr>
					<?php
						$globalStock = $globalStock + $stockQuantity;
						$finalFOBTemp = $stockQuantity * $val['Item']['last_fob'];
						$finalCIFTemp = $stockQuantity * $val['Item']['last_cif'];
						$finalSaleTemp = $stockQuantity * $val['Item']['last_sale'];
						$finalFOBGlobal = $finalFOBGlobal + $finalFOBTemp;
						$finalCIFGlobal = $finalCIFGlobal + $finalCIFTemp;
						$finalSaleGlobal = $finalSaleGlobal + $finalSaleTemp;
					?>
					<tr style="text-align:center;font-weight:bold;">
						<td>Total:</td>
						<td><?php echo $stockQuantity;?></td>
						<td><?php echo number_format($finalFOBTemp,2);?></td>
						<td><?php echo number_format($finalCIFTemp,2);?></td>
						<td><?php echo number_format($finalSaleTemp,2);?></td>
					</tr>
					
					<?php }
					
				} ?>
	</table>
	<hr style="height: 1px; color: #CCC; background-color: #CCC;">

<?php 
	//debug($stockQuantity);
	if($countMovements == 1){ 
		$globalStock = $globalStock + $stockQuantity;
	}
	//debug($globalStock);
	$globalQuanttityIn = $globalQuanttityIn + $inQuantityTotal;
	$globalQuanttityOut = $globalQuanttityOut + $outQuantityTotal;
	
	$globalQuantityFOB = $globalQuantityFOB + $val['TotalMovements']['fobQuantityTotal'];
	$globalQuantityCIF = $globalQuantityCIF + $val['TotalMovements']['cifQuantityTotal'];
	$globalQuantitySALE = $globalQuantitySALE + $val['TotalMovements']['saleQuantityTotal'];
?>
	
<?php } //end initial foreach?>

<?php 
if($initialData['detail'] == 'NO'){ //start - detail NO
?>
	<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">TOTAL GLOBAL:</div>
	<br>
	<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
		<tr >
			<th colspan="<?php echo (2 + $countKardexWarehouses);?>" style="text-align:right;"></th>
			<th colspan="2">Compra</th>
			<th colspan="1">Venta</th>
		</tr>	
		<tr>
			<th></th>
			<?php if($countKardexWarehouses == 0){?>
			<th>Saldo <br> (Unidad)</th>
			<?php }else{
	             foreach ($kardexWarehouses as $value4) {
					 echo '<th>Saldo <br>'.$value4.'<br> (Unidad)</th>';
				}
				echo '<th>Saldo <br> Todos los Almacenes <br> (Unidad)</th>';
			}?>
			<th>Precio FOB<br><?php echo $currencyAbbr ; ?></th>
			<th>Precio CIF <br><?php echo $currencyAbbr ; ?></th>
			<th>Precio Venta <br><?php echo $currencyAbbr ; ?></th>
		</tr>
		<tr style="text-align:center;font-weight:bold;">
			<td>Total:</td>
			<?php if($countKardexWarehouses == 0){?>
				<td><?php echo $globalStock;?></td>
			<?php }else{?>
				<?php foreach ($kardexWarehouses as $key5 => $value5) {
					echo '<td>'.$globalMultipleStock[$key5].'</td>';
				}?>
				
				<td><?php echo $globalStock;?></td>
			<?php }?>
			<td><?php echo number_format($finalFOBGlobal,2);?></td>
			<td><?php echo number_format($finalCIFGlobal,2);?></td>
			<td><?php echo number_format($finalSaleGlobal,2);?></td>
		</tr>
	</table>	
	<br>
<?php	
}
?>