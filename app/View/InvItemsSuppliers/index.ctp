<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Inv Items Suppliers'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_supplier_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_item_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invItemsSuppliers as $invItemsSupplier): ?>
			<tr>
				<td><?php echo h($invItemsSupplier['InvItemsSupplier']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($invItemsSupplier['InvSupplier']['name'], array('controller' => 'inv_suppliers', 'action' => 'view', $invItemsSupplier['InvSupplier']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($invItemsSupplier['InvItem']['code'], array('controller' => 'inv_items', 'action' => 'view', $invItemsSupplier['InvItem']['id'])); ?>
				</td>
				<td><?php echo h($invItemsSupplier['InvItemsSupplier']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($invItemsSupplier['InvItemsSupplier']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($invItemsSupplier['InvItemsSupplier']['creator']); ?>&nbsp;</td>
				<td><?php echo h($invItemsSupplier['InvItemsSupplier']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($invItemsSupplier['InvItemsSupplier']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($invItemsSupplier['InvItemsSupplier']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $invItemsSupplier['InvItemsSupplier']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $invItemsSupplier['InvItemsSupplier']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $invItemsSupplier['InvItemsSupplier']['id']), null, __('Are you sure you want to delete # %s?', $invItemsSupplier['InvItemsSupplier']['id'])); ?>
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
			<li><?php echo $this->Html->link(__('New %s', __('Inv Items Supplier')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Suppliers')), array('controller' => 'inv_suppliers', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Supplier')), array('controller' => 'inv_suppliers', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>