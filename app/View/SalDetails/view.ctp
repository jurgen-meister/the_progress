<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Sal Detail');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Sal Sale'); ?></dt>
			<dd>
				<?php echo $this->Html->link($salDetail['SalSale']['id'], array('controller' => 'sal_sales', 'action' => 'view', $salDetail['SalSale']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Item'); ?></dt>
			<dd>
				<?php echo $this->Html->link($salDetail['InvItem']['full_name'], array('controller' => 'inv_items', 'action' => 'view', $salDetail['InvItem']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Quantity'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['quantity']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($salDetail['SalDetail']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Sal Detail')), array('action' => 'edit', $salDetail['SalDetail']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Sal Detail')), array('action' => 'delete', $salDetail['SalDetail']['id']), null, __('Are you sure you want to delete # %s?', $salDetail['SalDetail']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Details')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Detail')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

