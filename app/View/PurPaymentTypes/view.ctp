<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Pur Payment Type');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($purPaymentType['PurPaymentType']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Pur Payment Type')), array('action' => 'edit', $purPaymentType['PurPaymentType']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Pur Payment Type')), array('action' => 'delete', $purPaymentType['PurPaymentType']['id']), null, __('Are you sure you want to delete # %s?', $purPaymentType['PurPaymentType']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Payment Types')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment Type')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Payments')), array('controller' => 'pur_payments', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment')), array('controller' => 'pur_payments', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Pur Payments')); ?></h3>
	<?php if (!empty($purPaymentType['PurPayment'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Pur Purchase Id'); ?></th>
				<th><?php echo __('Pur Payment Type Id'); ?></th>
				<th><?php echo __('Due Date'); ?></th>
				<th><?php echo __('Amount'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($purPaymentType['PurPayment'] as $purPayment): ?>
			<tr>
				<td><?php echo $purPayment['id'];?></td>
				<td><?php echo $purPayment['pur_purchase_id'];?></td>
				<td><?php echo $purPayment['pur_payment_type_id'];?></td>
				<td><?php echo $purPayment['due_date'];?></td>
				<td><?php echo $purPayment['amount'];?></td>
				<td><?php echo $purPayment['lc_state'];?></td>
				<td><?php echo $purPayment['lc_transaction'];?></td>
				<td><?php echo $purPayment['creator'];?></td>
				<td><?php echo $purPayment['date_created'];?></td>
				<td><?php echo $purPayment['modifier'];?></td>
				<td><?php echo $purPayment['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'pur_payments', 'action' => 'view', $purPayment['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'pur_payments', 'action' => 'edit', $purPayment['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'pur_payments', 'action' => 'delete', $purPayment['id']), null, __('Are you sure you want to delete # %s?', $purPayment['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment')), array('controller' => 'pur_payments', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
