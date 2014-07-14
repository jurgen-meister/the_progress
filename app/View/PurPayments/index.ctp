<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Pur Payments'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('pur_purchase_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('pur_payment_type_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('due_date');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('amount');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($purPayments as $purPayment): ?>
			<tr>
				<td><?php echo h($purPayment['PurPayment']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($purPayment['PurPurchase']['id'], array('controller' => 'pur_purchases', 'action' => 'view', $purPayment['PurPurchase']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($purPayment['PurPaymentType']['name'], array('controller' => 'pur_payment_types', 'action' => 'view', $purPayment['PurPaymentType']['id'])); ?>
				</td>
				<td><?php echo h($purPayment['PurPayment']['due_date']); ?>&nbsp;</td>
				<td><?php echo h($purPayment['PurPayment']['amount']); ?>&nbsp;</td>
				<td><?php echo h($purPayment['PurPayment']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($purPayment['PurPayment']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($purPayment['PurPayment']['creator']); ?>&nbsp;</td>
				<td><?php echo h($purPayment['PurPayment']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($purPayment['PurPayment']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($purPayment['PurPayment']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $purPayment['PurPayment']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $purPayment['PurPayment']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $purPayment['PurPayment']['id']), null, __('Are you sure you want to delete # %s?', $purPayment['PurPayment']['id'])); ?>
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
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Purchases')), array('controller' => 'pur_purchases', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Purchase')), array('controller' => 'pur_purchases', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Payment Types')), array('controller' => 'pur_payment_types', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment Type')), array('controller' => 'pur_payment_types', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>