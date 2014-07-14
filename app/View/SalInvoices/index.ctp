<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Sal Invoices'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('sal_sale_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('invoice_number');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('name');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('nit');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('total');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('description');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($salInvoices as $salInvoice): ?>
			<tr>
				<td><?php echo h($salInvoice['SalInvoice']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($salInvoice['SalSale']['id'], array('controller' => 'sal_sales', 'action' => 'view', $salInvoice['SalSale']['id'])); ?>
				</td>
				<td><?php echo h($salInvoice['SalInvoice']['invoice_number']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['date']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['name']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['nit']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['total']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['description']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['creator']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($salInvoice['SalInvoice']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $salInvoice['SalInvoice']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $salInvoice['SalInvoice']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $salInvoice['SalInvoice']['id']), null, __('Are you sure you want to delete # %s?', $salInvoice['SalInvoice']['id'])); ?>
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
			<li><?php echo $this->Html->link(__('New %s', __('Sal Invoice')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>