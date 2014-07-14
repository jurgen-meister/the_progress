<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Item');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Brand'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invItem['InvBrand']['name'], array('controller' => 'inv_brands', 'action' => 'view', $invItem['InvBrand']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Category Id'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['inv_category_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Code'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['code']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Factory Code'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['factory_code']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Picture'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['picture']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($invItem['InvItem']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Inv Item')), array('action' => 'edit', $invItem['InvItem']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Inv Item')), array('action' => 'delete', $invItem['InvItem']['id']), null, __('Are you sure you want to delete # %s?', $invItem['InvItem']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Brands')), array('controller' => 'inv_brands', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Brand')), array('controller' => 'inv_brands', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Prices')), array('controller' => 'inv_prices', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Price')), array('controller' => 'inv_prices', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Movements')), array('controller' => 'inv_movements', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement')), array('controller' => 'inv_movements', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items Suppliers')), array('controller' => 'inv_items_suppliers', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Items Supplier')), array('controller' => 'inv_items_suppliers', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Prices')); ?></h3>
	<?php if (!empty($invItem['InvPrice'])):?>
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
		<?php foreach ($invItem['InvPrice'] as $invPrice): ?>
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
<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Movements')); ?></h3>
	<?php if (!empty($invItem['InvMovement'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Inv Item Id'); ?></th>
				<th><?php echo __('Inv Warehouse Id'); ?></th>
				<th><?php echo __('Inv Document Type Id'); ?></th>
				<th><?php echo __('Document'); ?></th>
				<th><?php echo __('Code'); ?></th>
				<th><?php echo __('Date'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Quantity'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invItem['InvMovement'] as $invMovement): ?>
			<tr>
				<td><?php echo $invMovement['id'];?></td>
				<td><?php echo $invMovement['inv_item_id'];?></td>
				<td><?php echo $invMovement['inv_warehouse_id'];?></td>
				<td><?php echo $invMovement['inv_document_type_id'];?></td>
				<td><?php echo $invMovement['document'];?></td>
				<td><?php echo $invMovement['code'];?></td>
				<td><?php echo $invMovement['date'];?></td>
				<td><?php echo $invMovement['description'];?></td>
				<td><?php echo $invMovement['quantity'];?></td>
				<td><?php echo $invMovement['lc_state'];?></td>
				<td><?php echo $invMovement['lc_transaction'];?></td>
				<td><?php echo $invMovement['creator'];?></td>
				<td><?php echo $invMovement['date_created'];?></td>
				<td><?php echo $invMovement['modifier'];?></td>
				<td><?php echo $invMovement['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'inv_movements', 'action' => 'view', $invMovement['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'inv_movements', 'action' => 'edit', $invMovement['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'inv_movements', 'action' => 'delete', $invMovement['id']), null, __('Are you sure you want to delete # %s?', $invMovement['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Inv Movement')), array('controller' => 'inv_movements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Items Suppliers')); ?></h3>
	<?php if (!empty($invItem['invItemsSupplier'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Inv Supplier Id'); ?></th>
				<th><?php echo __('Inv Item Id'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invItem['invItemsSupplier'] as $invItemsSupplier): ?>
			<tr>
				<td><?php echo $invItemsSupplier['id'];?></td>
				<td><?php echo $invItemsSupplier['inv_supplier_id'];?></td>
				<td><?php echo $invItemsSupplier['inv_item_id'];?></td>
				<td><?php echo $invItemsSupplier['lc_state'];?></td>
				<td><?php echo $invItemsSupplier['lc_transaction'];?></td>
				<td><?php echo $invItemsSupplier['creator'];?></td>
				<td><?php echo $invItemsSupplier['date_created'];?></td>
				<td><?php echo $invItemsSupplier['modifier'];?></td>
				<td><?php echo $invItemsSupplier['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'inv_items_suppliers', 'action' => 'view', $invItemsSupplier['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'inv_items_suppliers', 'action' => 'edit', $invItemsSupplier['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'inv_items_suppliers', 'action' => 'delete', $invItemsSupplier['id']), null, __('Are you sure you want to delete # %s?', $invItemsSupplier['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Inv Items Supplier')), array('controller' => 'inv_items_suppliers', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
