<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Inv Movement Details'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_item_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_warehouse_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_movement_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('quantity');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invMovementDetails as $invMovementDetail): ?>
			<tr>
				<td><?php echo h($invMovementDetail['InvMovementDetail']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($invMovementDetail['InvItem']['name'], array('controller' => 'inv_items', 'action' => 'view', $invMovementDetail['InvItem']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($invMovementDetail['InvWarehouse']['name'], array('controller' => 'inv_warehouses', 'action' => 'view', $invMovementDetail['InvWarehouse']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($invMovementDetail['InvMovement']['code'], array('controller' => 'inv_movements', 'action' => 'view', $invMovementDetail['InvMovement']['id'])); ?>
				</td>
				<td><?php echo h($invMovementDetail['InvMovementDetail']['quantity']); ?>&nbsp;</td>
				<td><?php echo h($invMovementDetail['InvMovementDetail']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($invMovementDetail['InvMovementDetail']['lc_transaction']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $invMovementDetail['InvMovementDetail']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $invMovementDetail['InvMovementDetail']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $invMovementDetail['InvMovementDetail']['id']), null, __('Are you sure you want to delete # %s?', $invMovementDetail['InvMovementDetail']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement Detail')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Warehouses')), array('controller' => 'inv_warehouses', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Warehouse')), array('controller' => 'inv_warehouses', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Movements')), array('controller' => 'inv_movements', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement')), array('controller' => 'inv_movements', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>