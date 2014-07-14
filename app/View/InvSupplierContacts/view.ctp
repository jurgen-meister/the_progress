<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Supplier Contact');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Supplier'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invSupplierContact['InvSupplier']['name'], array('controller' => 'inv_suppliers', 'action' => 'view', $invSupplierContact['InvSupplier']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Phone'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['phone']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Job Title'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['job_title']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($invSupplierContact['InvSupplierContact']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Inv Supplier Contact')), array('action' => 'edit', $invSupplierContact['InvSupplierContact']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Inv Supplier Contact')), array('action' => 'delete', $invSupplierContact['InvSupplierContact']['id']), null, __('Are you sure you want to delete # %s?', $invSupplierContact['InvSupplierContact']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Supplier Contacts')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Supplier Contact')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Suppliers')), array('controller' => 'inv_suppliers', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Supplier')), array('controller' => 'inv_suppliers', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

