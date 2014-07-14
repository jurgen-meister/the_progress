<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Pur Payment');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Pur Purchase'); ?></dt>
			<dd>
				<?php echo $this->Html->link($purPayment['PurPurchase']['id'], array('controller' => 'pur_purchases', 'action' => 'view', $purPayment['PurPurchase']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Pur Payment Type'); ?></dt>
			<dd>
				<?php echo $this->Html->link($purPayment['PurPaymentType']['name'], array('controller' => 'pur_payment_types', 'action' => 'view', $purPayment['PurPaymentType']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Due Date'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['due_date']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Amount'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['amount']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($purPayment['PurPayment']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Pur Payment')), array('action' => 'edit', $purPayment['PurPayment']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Pur Payment')), array('action' => 'delete', $purPayment['PurPayment']['id']), null, __('Are you sure you want to delete # %s?', $purPayment['PurPayment']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Payments')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Purchases')), array('controller' => 'pur_purchases', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Purchase')), array('controller' => 'pur_purchases', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Payment Types')), array('controller' => 'pur_payment_types', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Payment Type')), array('controller' => 'pur_payment_types', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

