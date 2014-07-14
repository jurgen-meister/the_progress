<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Sal Employee');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Sal Customer'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['sal_customer']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('First Name'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['first_name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Last Name'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['last_name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Phone'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['phone']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Email'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['email']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($salEmployee['SalEmployee']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Sal Employee')), array('action' => 'edit', $salEmployee['SalEmployee']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Sal Employee')), array('action' => 'delete', $salEmployee['SalEmployee']['id']), null, __('Are you sure you want to delete # %s?', $salEmployee['SalEmployee']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Employees')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Employee')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Sal Sales')); ?></h3>
	<?php if (!empty($salEmployee['SalSale'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Sal Employee Id'); ?></th>
				<th><?php echo __('Sal Buyer'); ?></th>
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
		<?php foreach ($salEmployee['SalSale'] as $salSale): ?>
			<tr>
				<td><?php echo $salSale['id'];?></td>
				<td><?php echo $salSale['sal_employee_id'];?></td>
				<td><?php echo $salSale['sal_buyer'];?></td>
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
