<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Items Supplier');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invItemsSupplier['InvItemsSupplier']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Supplier'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invItemsSupplier['InvSupplier']['name'], array('controller' => 'inv_suppliers', 'action' => 'view', $invItemsSupplier['InvSupplier']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Item'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invItemsSupplier['InvItem']['code'], array('controller' => 'inv_items', 'action' => 'view', $invItemsSupplier['InvItem']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($invItemsSupplier['InvItemsSupplier']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($invItemsSupplier['InvItemsSupplier']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($invItemsSupplier['InvItemsSupplier']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($invItemsSupplier['InvItemsSupplier']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($invItemsSupplier['InvItemsSupplier']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($invItemsSupplier['InvItemsSupplier']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Inv Items Supplier')), array('action' => 'edit', $invItemsSupplier['InvItemsSupplier']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Inv Items Supplier')), array('action' => 'delete', $invItemsSupplier['InvItemsSupplier']['id']), null, __('Are you sure you want to delete # %s?', $invItemsSupplier['InvItemsSupplier']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items Suppliers')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Items Supplier')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Suppliers')), array('controller' => 'inv_suppliers', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Supplier')), array('controller' => 'inv_suppliers', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

