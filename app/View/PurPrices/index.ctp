<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Pur Prices'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_price_type_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('pur_purchase_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('amount');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($purPrices as $purPrice): ?>
			<tr>
				<td><?php echo h($purPrice['PurPrice']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($purPrice['InvPriceType']['name'], array('controller' => 'inv_price_types', 'action' => 'view', $purPrice['InvPriceType']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($purPrice['PurPurchase']['id'], array('controller' => 'pur_purchases', 'action' => 'view', $purPrice['PurPurchase']['id'])); ?>
				</td>
				<td><?php echo h($purPrice['PurPrice']['amount']); ?>&nbsp;</td>
				<td><?php echo h($purPrice['PurPrice']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($purPrice['PurPrice']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($purPrice['PurPrice']['creator']); ?>&nbsp;</td>
				<td><?php echo h($purPrice['PurPrice']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($purPrice['PurPrice']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($purPrice['PurPrice']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $purPrice['PurPrice']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $purPrice['PurPrice']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $purPrice['PurPrice']['id']), null, __('Are you sure you want to delete # %s?', $purPrice['PurPrice']['id'])); ?>
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
			<li><?php echo $this->Html->link(__('New %s', __('Pur Price')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Price Types')), array('controller' => 'inv_price_types', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Price Type')), array('controller' => 'inv_price_types', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Purchases')), array('controller' => 'pur_purchases', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Purchase')), array('controller' => 'pur_purchases', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>