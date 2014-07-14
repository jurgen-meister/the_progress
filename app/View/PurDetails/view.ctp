<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Pur Detail');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Pur Purchase'); ?></dt>
			<dd>
				<?php echo $this->Html->link($purDetail['PurPurchase']['id'], array('controller' => 'pur_purchases', 'action' => 'view', $purDetail['PurPurchase']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Item'); ?></dt>
			<dd>
				<?php echo $this->Html->link($purDetail['InvItem']['name'], array('controller' => 'inv_items', 'action' => 'view', $purDetail['InvItem']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Quantity'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['quantity']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($purDetail['PurDetail']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Pur Detail')), array('action' => 'edit', $purDetail['PurDetail']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Pur Detail')), array('action' => 'delete', $purDetail['PurDetail']['id']), null, __('Are you sure you want to delete # %s?', $purDetail['PurDetail']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Details')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Detail')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Purchases')), array('controller' => 'pur_purchases', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Purchase')), array('controller' => 'pur_purchases', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

