<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Sal Details'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('sal_sale_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_item_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('quantity');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($salDetails as $salDetail): ?>
			<tr>
				<td><?php echo h($salDetail['SalDetail']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($salDetail['SalSale']['id'], array('controller' => 'sal_sales', 'action' => 'view', $salDetail['SalSale']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($salDetail['InvItem']['full_name'], array('controller' => 'inv_items', 'action' => 'view', $salDetail['InvItem']['id'])); ?>
				</td>
				<td><?php echo h($salDetail['SalDetail']['quantity']); ?>&nbsp;</td>
				<td><?php echo h($salDetail['SalDetail']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($salDetail['SalDetail']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($salDetail['SalDetail']['creator']); ?>&nbsp;</td>
				<td><?php echo h($salDetail['SalDetail']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($salDetail['SalDetail']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($salDetail['SalDetail']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $salDetail['SalDetail']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $salDetail['SalDetail']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $salDetail['SalDetail']['id']), null, __('Are you sure you want to delete # %s?', $salDetail['SalDetail']['id'])); ?>
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
			<li><?php echo $this->Html->link(__('New %s', __('Sal Detail')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>