<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Pur Payment Types'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('name');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('description');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($purPaymentTypes as $purPaymentType): ?>
			<tr>
				<td><?php echo h($purPaymentType['PurPaymentType']['id']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['name']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['description']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['creator']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($purPaymentType['PurPaymentType']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $purPaymentType['PurPaymentType']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $purPaymentType['PurPaymentType']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $purPaymentType['PurPaymentType']['id']), null, __('Are you sure you want to delete # %s?', $purPaymentType['PurPaymentType']['id'])); ?>
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
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment Type')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Payments')), array('controller' => 'pur_payments', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment')), array('controller' => 'pur_payments', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>