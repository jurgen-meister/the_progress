<span style="font-size: 25px; font-weight: bold">IMEXPORT</span><span style="font-weight: bold">SRL</span>
<hr style="height: 2px; color: #000; background-color: #000;">
<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">REPORTE DE VENTAS - COMPRAS DE CLIENTES:</div>
<br>

<table class="report-table" border="0" style="border-collapse:collapse; width:100%;">
	<thead>
	<tr style="text-align:center">
		<th style="width:25%">Gestión:</th>
		<th style="width:25%">Mes:</th>
	</tr>
	</thead>
	<tbody>
		<tr style="text-align:center">
			<td><?php echo $initialData['year'];?></td>
			<td><?php echo $initialData['monthName'];?></td>
		</tr>
	</tbody>
</table>
<hr style="height: 1px; color: #444; background-color: #444;">

<?php $currencyAbbr = ' (Bs)'; if(strtoupper($initialData['currency']) == 'DOLARES'){$currencyAbbr=' ($us)';}?>

<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
			<thead>
				<tr>
					<th>#</th>
					<th>Cliente</th>
					<th>Cantidad (Unidad)</th>
					<th> Monto Dinero <?php echo $currencyAbbr;?></th>
				</tr>
			</thead>
			<tbody>
				<?php $counter = 1; $totalMoney = 0; $totalQuantity=0;?>
				<?php foreach($details as $value){?>
				<tr>
					<td style="text-align:center;"><?php echo $counter;?></td>
					<td style="padding-left: 10px;"><?php echo $value['SalCustomer']['name'];?></td>
					<td style="text-align:center;"><?php echo $value[0]['quantity'];?></td>
					<td style="text-align:center;"><?php echo number_format($value[0]['money'],2);?></td>
				</tr>
				<?php 
				$totalQuantity = $totalQuantity + $value[0]['quantity'];
				$totalMoney = $totalMoney + $value[0]['money'];
				$counter++;
				}?>
				<tr>
					<td colspan="2" style="text-align:right; padding-right: 10px"> Total:</td>
					<td style="font-weight:bold;text-align:center;"><?php echo $totalQuantity;?></td>
					<td style="font-weight:bold;text-align:center;"><?php echo number_format($totalMoney,2);?></td>
				</tr>
			</tbody>
	</table>

<hr style="height: 1px; color: #444; background-color: #444;">
<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">PRODUCTOS SELECCIONADOS:</div>
<br>
<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
	<thead>
				<tr>
					<th>#</th>
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Marca</th>
					<th>Categoria</th>
				</tr>
			</thead>
			<?php $counter=1; ?>
			<?php foreach($items as $item){?>
			<tr>
					<td style="text-align: center;"><?php echo $counter;?></td>
					<!--<td style="padding-left: 10px;"><?php //echo "[ ".$item["InvItem"]["code"]." ] ". $item["InvItem"]["name"];?></td>-->
					<td style="text-align: center;"><?php echo $item["InvItem"]["code"];?></td>
					<td style="text-align: center;"><?php echo $item["InvItem"]["name"];?></td>
					<td style="text-align: center;"><?php echo $item["InvBrand"]["name"];?></td>
					<td style="text-align: center;"><?php echo $item["InvCategory"]["name"];?></td>
			</tr>
			<?php $counter++;}?>
</table>
<br>
<br>