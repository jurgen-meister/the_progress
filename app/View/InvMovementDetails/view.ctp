<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Movement Detail');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invMovementDetail['InvMovementDetail']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Item'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invMovementDetail['InvItem']['name'], array('controller' => 'inv_items', 'action' => 'view', $invMovementDetail['InvItem']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Warehouse'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invMovementDetail['InvWarehouse']['name'], array('controller' => 'inv_warehouses', 'action' => 'view', $invMovementDetail['InvWarehouse']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Movement'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invMovementDetail['InvMovement']['code'], array('controller' => 'inv_movements', 'action' => 'view', $invMovementDetail['InvMovement']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Quantity'); ?></dt>
			<dd>
				<?php echo h($invMovementDetail['InvMovementDetail']['quantity']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($invMovementDetail['InvMovementDetail']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($invMovementDetail['InvMovementDetail']['lc_transaction']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Inv Movement Detail')), array('action' => 'edit', $invMovementDetail['InvMovementDetail']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Inv Movement Detail')), array('action' => 'delete', $invMovementDetail['InvMovementDetail']['id']), null, __('Are you sure you want to delete # %s?', $invMovementDetail['InvMovementDetail']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Movement Details')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement Detail')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Warehouses')), array('controller' => 'inv_warehouses', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Warehouse')), array('controller' => 'inv_warehouses', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Movements')), array('controller' => 'inv_movements', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement')), array('controller' => 'inv_movements', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

