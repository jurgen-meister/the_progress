<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Pur Price');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Price Type'); ?></dt>
			<dd>
				<?php echo $this->Html->link($purPrice['InvPriceType']['name'], array('controller' => 'inv_price_types', 'action' => 'view', $purPrice['InvPriceType']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Pur Purchase'); ?></dt>
			<dd>
				<?php echo $this->Html->link($purPrice['PurPurchase']['id'], array('controller' => 'pur_purchases', 'action' => 'view', $purPrice['PurPurchase']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Amount'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['amount']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($purPrice['PurPrice']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Pur Price')), array('action' => 'edit', $purPrice['PurPrice']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Pur Price')), array('action' => 'delete', $purPrice['PurPrice']['id']), null, __('Are you sure you want to delete # %s?', $purPrice['PurPrice']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Prices')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Price')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Price Types')), array('controller' => 'inv_price_types', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Price Type')), array('controller' => 'inv_price_types', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Pur Purchases')), array('controller' => 'pur_purchases', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Pur Purchase')), array('controller' => 'pur_purchases', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

