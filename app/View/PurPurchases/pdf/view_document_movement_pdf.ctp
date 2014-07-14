<span style="font-size: 30px; font-weight: bold">IMEXPORT</span><span style="font-weight: bold">SRL</span>
<div style="height: 2px; background-color: black"></div>
<?php
	switch ($movement['PurPurchase']['lc_state']){
		case 'ORDER_PENDANT':
			$stateName = 'PENDIENTE';
			$docType = 1;
			break;
		case 'ORDER_APPROVED':
			$stateName = 'APROBADO';
			$docType = 1;
			break;
		case 'ORDER_CANCELLED':
			$stateName = 'CANCELADO';
			$docType = 1;
			break;
		case 'PINVOICE_PENDANT':
			$stateName = 'PENDIENTE';
			$docType = 2;
			break;
		case 'PINVOICE_APPROVED':
			$stateName = 'APROBADO';
			$docType = 2;
			break;
		case 'PINVOICE_CANCELLED':
			$stateName = 'CANCELADO';
			$docType = 2;
			break;
	}
?>

<table style="width:100%">
	<tr>
		<?php if($docType == 1){?>
		<td align="right"><span class="report-title"><?php echo "ORDEN DE COMPRA: ";?></span><?php echo $stateName;?></td>
		<?php }else{?>
		<td align="right"><span class="report-title"><?php echo "FACTURA DE COMPRA: ";?></span><?php echo $stateName;?></td>
		<?php }?>
	</tr>
</table>
<br>


<p><span class="report-title">No. Factura Proforma: </span><?php echo $movement['PurPurchase']['note_code'];?></p>


<p><span class="report-title">Fecha: </span><?php echo date("d/m/Y", strtotime($movement['PurPurchase']['date']));?></p>


<p><span class="report-title">Descripción: </span><?php echo $movement['PurPurchase']['description'];?></p>

<br>

<table class="report-table" border="1" bordercolor="red" style="border-collapse:collapse;">
	<thead>
		<tr>
			<th style="width:52%">Item (unidad)</th>
			<th style="width:12%">Proveedor</th>
			<th style="width:12%">Precio Unitario</th>
			<th style="width:12%">Cantidad</th>
			<th style="width:12%">Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$total = '0.00';
		for($i=0; $i<count($details); $i++){
			echo '<tr >';
				echo '<td style="width:52%">'.$details[$i]['item'].'</td>';
				echo '<td style="width:12%" align="center">'.$details[$i]['supplier'].'</td>';
				echo '<td style="width:12%" align="center">'.$details[$i]['exFobPrice'].'</td>';
				echo '<td style="width:12%" align="center">'.$details[$i]['cantidad'].'</td>';
				$subtotal = $details[$i]['exFobPrice']*$details[$i]['cantidad'];
				echo '<td style="width:12%" align="center">'.$subtotal.'</td>';
			echo '</tr>';								
			$total += $subtotal;
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td style="border: 1px solid white;"></td>
			<td style="border: 1px solid white;"></td>
			<td style="border: 1px solid white;"></td>
			<td align="center"><h4>Total:</h4></td>
			<td align="center"><h4><?php echo number_format($total, 2, '.', '').' $us.'; ?></h4></td>
		</tr>	
	</tfoot>	
</table>

<?php if($docType == 2){?>
	<br>
	<table class="report-table" border="1" bordercolor="red" style="border-collapse:collapse;">
		<thead>
			<tr>
				<th style="width:52%">Costos Adicionales de Importación</th>
				<th style="width:12%">Monto</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = '0.00';
			for($i=0; $i<count($costDetails); $i++){
				echo '<tr >';
					echo '<td style="width:52%">'.$costDetails[$i]['costCodeName'].'</td>';
					echo '<td style="width:12%" align="center">'.$costDetails[$i]['costExAmount'].'</td>';
					
				echo '</tr>';								
				$total += $costDetails[$i]['costExAmount'];
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td align="center"><h4>Total:</h4></td>
				<td align="center"><h4><?php echo number_format($total, 2, '.', '').' $us.'; ?></h4></td>
			</tr>	
		</tfoot>	
	</table>
	<br>
	<table class="report-table" border="1" bordercolor="red" style="border-collapse:collapse;">
		<thead>
			<tr>
				<th style="width:20%">Fecha de Pago</th>
				<th style="width:60%">Descripcion</th>
				<th style="width:20%">Monto</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total = '0.00';
			for($i=0; $i<count($payDetails); $i++){
				echo '<tr >';
					echo '<td style="width:20%" align="center">'.$payDetails[$i]['payDate'].'</td>';
					echo '<td style="width:60%" align="center">'.$payDetails[$i]['payDescription'].'</td>';
					echo '<td style="width:20%" align="center">'.$payDetails[$i]['payAmount'].'</td>';
				echo '</tr>';								
				$total += $payDetails[$i]['payAmount'];
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td style="border: 1px solid white;"></td>
				<td align="center"><h4>Total:</h4></td>
				<td align="center"><h4><?php echo number_format($total, 2, '.', '').' Bs.'; ?></h4></td>
			</tr>	
		</tfoot>	
	</table>
<?php }?>

<style type="text/css">
	.report-title{
		font-weight: bold
	}
	.report-table{
		width: 100%
	}
</style>
