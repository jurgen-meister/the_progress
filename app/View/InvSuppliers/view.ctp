<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Supplier');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Code'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['code']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Location'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['location']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Adress'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['adress']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Phone'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['phone']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($invSupplier['InvSupplier']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Inv Supplier')), array('action' => 'edit', $invSupplier['InvSupplier']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Inv Supplier')), array('action' => 'delete', $invSupplier['InvSupplier']['id']), null, __('Are you sure you want to delete # %s?', $invSupplier['InvSupplier']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Suppliers')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Supplier')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Supplier Contacts')), array('controller' => 'inv_supplier_contacts', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Supplier Contact')), array('controller' => 'inv_supplier_contacts', 'action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Inv Items Suppliers')), array('controller' => 'inv_items_suppliers', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Inv Items Supplier')), array('controller' => 'inv_items_suppliers', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Supplier Contacts')); ?></h3>
	<?php if (!empty($invSupplier['InvSupplierContact'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Inv Supplier Id'); ?></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Phone'); ?></th>
				<th><?php echo __('Job Title'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invSupplier['InvSupplierContact'] as $invSupplierContact): ?>
			<tr>
				<td><?php echo $invSupplierContact['id'];?></td>
				<td><?php echo $invSupplierContact['inv_supplier_id'];?></td>
				<td><?php echo $invSupplierContact['name'];?></td>
				<td><?php echo $invSupplierContact['phone'];?></td>
				<td><?php echo $invSupplierContact['job_title'];?></td>
				<td><?php echo $invSupplierContact['lc_state'];?></td>
				<td><?php echo $invSupplierContact['lc_transaction'];?></td>
				<td><?php echo $invSupplierContact['creator'];?></td>
				<td><?php echo $invSupplierContact['date_created'];?></td>
				<td><?php echo $invSupplierContact['modifier'];?></td>
				<td><?php echo $invSupplierContact['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'inv_supplier_contacts', 'action' => 'view', $invSupplierContact['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'inv_supplier_contacts', 'action' => 'edit', $invSupplierContact['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'inv_supplier_contacts', 'action' => 'delete', $invSupplierContact['id']), null, __('Are you sure you want to delete # %s?', $invSupplierContact['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Inv Supplier Contact')), array('controller' => 'inv_supplier_contacts', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Items Suppliers')); ?></h3>
	<?php if (!empty($invSupplier['InvItemsSupplier'])):?>
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
		<?php foreach ($invSupplier['InvItemsSupplier'] as $invItemsSupplier): ?>
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
