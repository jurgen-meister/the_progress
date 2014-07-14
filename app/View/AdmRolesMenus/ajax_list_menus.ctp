<table class="table table-bordered table-hover" id="tblMenus">
	<thead>
		<tr>
			<th style="width: 3%;">
				<label class="checkbox">
					<?php $checkedParent=''; if($parentMenu['empty']=='no')$checkedParent='checked = "checked"';?>
					<input type="checkbox" id="chkMain" name="chkTree[]" <?php echo $checkedParent; ?> value="<?php echo $parentMenu['id'];?>">
				</label>
			</th>
			<th><?php echo $parentMenu['name'];?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (count($data) > 0) {
			foreach ($data as $menu) {
				$checked ='';
				if($menu['checked'] > 0) $checked = 'checked = "checked"';
				?>
				<tr>
					<td style="text-align: center;">
						<input type="checkbox" class="chkController" name="chkTree[]" <?php echo $checked; ?>  value="<?php echo $menu['menuId'];?>" >
					</td>
					<td>
						<?php echo $menu['menuName'];?>
					</td>
				</tr>
				<?php
		}}
			?>
	</tbody>
</table>