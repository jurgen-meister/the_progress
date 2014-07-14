<?php
//echo $chkTree; 
//debug($data);
?>
<table class="table table-bordered table-hover" id="tblTransactions">
	<thead>
		<tr>
			<th style="width: 3%;">
				<label class="checkbox">
					<input type="checkbox" id="chkMain" value="empty" <?php echo $allChecked;?> >
				</label>
			</th>
			<th style="width: 15%;">Controladores</th>
			<th>Transacciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$counter = 1;
		foreach ($data as $controller) {
			$existstransactions = count($controller['transactions']);
			?>
			<tr>
				<td style="text-align: center;">
					<?php
//					echo $counter++
					?>
					<input type="checkbox" class="chkController" name="chkTree[]" <?php echo $controller["controllerChecked"]; ?>  value="empty" >
				</td>
				<td><?php echo $controller["controllerName"]; ?></td>
				<td>
					<?php
					if ($existstransactions > 0) {
						foreach ($controller['transactions'] as $transaction) {
							?>
							<label class="checkbox inline">
								<input type="checkbox" class="chkTransaction" name="chkTree[]" <?php echo $transaction["transactionChecked"]; ?>  value="<?php echo $transaction["transactionId"]; ?>" ><?php echo $transaction["transactionName"]; ?>
							</label>
				<?php }
			} ?>
				</td>
			</tr>
	<?php
}
?>

	</tbody>
</table>