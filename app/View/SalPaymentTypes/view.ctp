<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Sal Payment Type');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($salPaymentType['SalPaymentType']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Sal Payment Type')), array('action' => 'edit', $salPaymentType['SalPaymentType']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Sal Payment Type')), array('action' => 'delete', $salPaymentType['SalPaymentType']['id']), null, __('Are you sure you want to delete # %s?', $salPaymentType['SalPaymentType']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Payment Types')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Payment Type')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Payments')), array('controller' => 'sal_payments', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Payment')), array('controller' => 'sal_payments', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Sal Payments')); ?></h3>
	<?php if (!empty($salPaymentType['SalPayment'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Sal Payment Type Id'); ?></th>
				<th><?php echo __('Sal Sale Id'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Amount'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($salPaymentType['SalPayment'] as $salPayment): ?>
			<tr>
				<td><?php echo $salPayment['id'];?></td>
				<td><?php echo $salPayment['sal_payment_type_id'];?></td>
				<td><?php echo $salPayment['sal_sale_id'];?></td>
				<td><?php echo $salPayment['description'];?></td>
				<td><?php echo $salPayment['amount'];?></td>
				<td><?php echo $salPayment['lc_state'];?></td>
				<td><?php echo $salPayment['lc_transaction'];?></td>
				<td><?php echo $salPayment['creator'];?></td>
				<td><?php echo $salPayment['date_created'];?></td>
				<td><?php echo $salPayment['modifier'];?></td>
				<td><?php echo $salPayment['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'sal_payments', 'action' => 'view', $salPayment['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'sal_payments', 'action' => 'edit', $salPayment['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sal_payments', 'action' => 'delete', $salPayment['id']), null, __('Are you sure you want to delete # %s?', $salPayment['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Sal Payment')), array('controller' => 'sal_payments', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
