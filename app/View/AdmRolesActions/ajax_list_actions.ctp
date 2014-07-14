<?php
//echo $chkTree; 
//debug($data);
?>
<table class="table table-bordered table-hover" id="tblActions">
	<thead>
		<tr>
			<th style="width: 3%;">
				<label class="checkbox">
					<input type="checkbox" id="chkMain" value="empty" <?php echo $allChecked;?> >
				</label>
			</th>
			<th style="width: 15%;">Controladores</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($data as $controller) {
			$existstransactions = count($controller['actions']);
			?>
			<tr>
				<td style="text-align: center;">
					<?php
					?>
					<input type="checkbox" class="chkController" name="chkTree[]" <?php echo $controller["controllerChecked"]; ?>  value="empty" >
				</td>
				<td><?php echo $controller["controllerName"]; ?></td>
				<td>
					<?php
					if ($existstransactions > 0) {
						foreach ($controller['actions'] as $transaction) {
							?>
							<label class="checkbox inline">
								<input type="checkbox" class="chkAction" name="chkTree[]" <?php echo $transaction["actionChecked"]; ?>  value="<?php echo $transaction["actionId"]; ?>" ><?php echo $transaction["actionName"]; ?>
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