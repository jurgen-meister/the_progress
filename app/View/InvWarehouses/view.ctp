<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Warehouse');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invWarehouse['InvWarehouse']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Nombre'); ?></dt>
			<dd>
				<?php echo h($invWarehouse['InvWarehouse']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Ciudad y Pais'); ?></dt>
			<dd>
				<?php echo h($invWarehouse['InvWarehouse']['location']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Dirección'); ?></dt>
			<dd>
				<?php echo h($invWarehouse['InvWarehouse']['address']); ?>
				&nbsp;
			</dd>
			
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Inv Warehouse')), array('action' => 'edit', $invWarehouse['InvWarehouse']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Inv Warehouse')), array('action' => 'delete', $invWarehouse['InvWarehouse']['id']), null, __('Are you sure you want to delete # %s?', $invWarehouse['InvWarehouse']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Warehouses')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Warehouse')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Movements')), array('controller' => 'inv_movements', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement')), array('controller' => 'inv_movements', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Movements')); ?></h3>
	<?php if (!empty($invWarehouse['InvMovement'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Inv Item Id'); ?></th>
				<th><?php echo __('Inv Warehouse Id'); ?></th>
				<th><?php echo __('Inv Document Type Id'); ?></th>
				<th><?php echo __('Document'); ?></th>
				<th><?php echo __('Code'); ?></th>
				<th><?php echo __('Date'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Quantity'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invWarehouse['InvMovement'] as $invMovement): ?>
			<tr>
				<td><?php echo $invMovement['id'];?></td>
				<td><?php echo $invMovement['inv_item_id'];?></td>
				<td><?php echo $invMovement['inv_warehouse_id'];?></td>
				<td><?php echo $invMovement['inv_document_type_id'];?></td>
				<td><?php echo $invMovement['document'];?></td>
				<td><?php echo $invMovement['code'];?></td>
				<td><?php echo $invMovement['date'];?></td>
				<td><?php echo $invMovement['description'];?></td>
				<td><?php echo $invMovement['quantity'];?></td>
				<td><?php echo $invMovement['lc_state'];?></td>
				<td><?php echo $invMovement['lc_transaction'];?></td>
				<td><?php echo $invMovement['creator'];?></td>
				<td><?php echo $invMovement['date_created'];?></td>
				<td><?php echo $invMovement['modifier'];?></td>
				<td><?php echo $invMovement['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'inv_movements', 'action' => 'view', $invMovement['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'inv_movements', 'action' => 'edit', $invMovement['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'inv_movements', 'action' => 'delete', $invMovement['id']), null, __('Are you sure you want to delete # %s?', $invMovement['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement')), array('controller' => 'inv_movements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
