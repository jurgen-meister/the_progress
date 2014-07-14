<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Sal Payment');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Sal Payment Type'); ?></dt>
			<dd>
				<?php echo $this->Html->link($salPayment['SalPaymentType']['name'], array('controller' => 'sal_payment_types', 'action' => 'view', $salPayment['SalPaymentType']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Sal Sale'); ?></dt>
			<dd>
				<?php echo $this->Html->link($salPayment['SalSale']['id'], array('controller' => 'sal_sales', 'action' => 'view', $salPayment['SalSale']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Amount'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['amount']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($salPayment['SalPayment']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Sal Payment')), array('action' => 'edit', $salPayment['SalPayment']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Sal Payment')), array('action' => 'delete', $salPayment['SalPayment']['id']), null, __('Are you sure you want to delete # %s?', $salPayment['SalPayment']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Payments')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Payment')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Payment Types')), array('controller' => 'sal_payment_types', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Payment Type')), array('controller' => 'sal_payment_types', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

