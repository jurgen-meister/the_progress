<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Sal Invoice');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Sal Sale'); ?></dt>
			<dd>
				<?php echo $this->Html->link($salInvoice['SalSale']['id'], array('controller' => 'sal_sales', 'action' => 'view', $salInvoice['SalSale']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Invoice Number'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['invoice_number']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['date']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Nit'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['nit']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Total'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['total']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($salInvoice['SalInvoice']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Sal Invoice')), array('action' => 'edit', $salInvoice['SalInvoice']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Sal Invoice')), array('action' => 'delete', $salInvoice['SalInvoice']['id']), null, __('Are you sure you want to delete # %s?', $salInvoice['SalInvoice']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Invoices')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Invoice')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

