<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Sal Tax Number');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Sal Customer'); ?></dt>
			<dd>
				<?php echo $this->Html->link($salTaxNumber['SalCustomer']['name'], array('controller' => 'sal_customers', 'action' => 'view', $salTaxNumber['SalCustomer']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Nit'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['nit']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['date_modified']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($salTaxNumber['SalTaxNumber']['modifier']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Sal Tax Number')), array('action' => 'edit', $salTaxNumber['SalTaxNumber']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Sal Tax Number')), array('action' => 'delete', $salTaxNumber['SalTaxNumber']['id']), null, __('Are you sure you want to delete # %s?', $salTaxNumber['SalTaxNumber']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Tax Numbers')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Tax Number')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Customers')), array('controller' => 'sal_customers', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Customer')), array('controller' => 'sal_customers', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Sal Sales')); ?></h3>
	<?php if (!empty($salTaxNumber['SalSale'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Sal Employee Id'); ?></th>
				<th><?php echo __('Sal Tax Number Id'); ?></th>
				<th><?php echo __('Code'); ?></th>
				<th><?php echo __('Doc Code'); ?></th>
				<th><?php echo __('Date'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($salTaxNumber['SalSale'] as $salSale): ?>
			<tr>
				<td><?php echo $salSale['id'];?></td>
				<td><?php echo $salSale['sal_employee_id'];?></td>
				<td><?php echo $salSale['sal_tax_number_id'];?></td>
				<td><?php echo $salSale['code'];?></td>
				<td><?php echo $salSale['doc_code'];?></td>
				<td><?php echo $salSale['date'];?></td>
				<td><?php echo $salSale['description'];?></td>
				<td><?php echo $salSale['lc_state'];?></td>
				<td><?php echo $salSale['lc_transaction'];?></td>
				<td><?php echo $salSale['creator'];?></td>
				<td><?php echo $salSale['date_created'];?></td>
				<td><?php echo $salSale['modifier'];?></td>
				<td><?php echo $salSale['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'sal_sales', 'action' => 'view', $salSale['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'sal_sales', 'action' => 'edit', $salSale['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sal_sales', 'action' => 'delete', $salSale['id']), null, __('Are you sure you want to delete # %s?', $salSale['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
