<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Price Type');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($invPriceType['InvPriceType']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Inv Price Type')), array('action' => 'edit', $invPriceType['InvPriceType']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Inv Price Type')), array('action' => 'delete', $invPriceType['InvPriceType']['id']), null, __('Are you sure you want to delete # %s?', $invPriceType['InvPriceType']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Price Types')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Price Type')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Prices')), array('controller' => 'inv_prices', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Price')), array('controller' => 'inv_prices', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Prices')); ?></h3>
	<?php if (!empty($invPriceType['InvPrice'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Inv Item Id'); ?></th>
				<th><?php echo __('Inv Price Type Id'); ?></th>
				<th><?php echo __('Price'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invPriceType['InvPrice'] as $invPrice): ?>
			<tr>
				<td><?php echo $invPrice['id'];?></td>
				<td><?php echo $invPrice['inv_item_id'];?></td>
				<td><?php echo $invPrice['inv_price_type_id'];?></td>
				<td><?php echo $invPrice['price'];?></td>
				<td><?php echo $invPrice['description'];?></td>
				<td><?php echo $invPrice['lc_state'];?></td>
				<td><?php echo $invPrice['lc_transaction'];?></td>
				<td><?php echo $invPrice['creator'];?></td>
				<td><?php echo $invPrice['date_created'];?></td>
				<td><?php echo $invPrice['modifier'];?></td>
				<td><?php echo $invPrice['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'inv_prices', 'action' => 'view', $invPrice['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'inv_prices', 'action' => 'edit', $invPrice['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'inv_prices', 'action' => 'delete', $invPrice['id']), null, __('Are you sure you want to delete # %s?', $invPrice['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Inv Price')), array('controller' => 'inv_prices', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
