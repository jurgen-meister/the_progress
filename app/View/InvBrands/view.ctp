<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Inv Brand');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invBrand['InvBrand']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Nombre'); ?></dt>
			<dd>
				<?php echo h($invBrand['InvBrand']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Descripcion'); ?></dt>
			<dd>
				<?php echo h($invBrand['InvBrand']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Pais de Origen'); ?></dt>
			<dd>
				<?php echo h($invBrand['InvBrand']['country_source']); ?>
				&nbsp;
			</dd>
			
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Editar Marca'), array('action' => 'edit', $invBrand['InvBrand']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Eliminar Marca'), array('action' => 'delete', $invBrand['InvBrand']['id']), null, __('Esta seguro de eliminar?', $invBrand['InvBrand']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('Lista de Marcas'), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('Nueva Marca'), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('Lista de Items'), array('controller' => 'inv_items', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('Nuevo Item'), array('controller' => 'inv_items', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Inv Items')); ?></h3>
	<?php if (!empty($invBrand['InvItem'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Inv Brand Id'); ?></th>
				<th><?php echo __('Inv Category Id'); ?></th>
				<th><?php echo __('Code'); ?></th>
				<th><?php echo __('Name'); ?></th>
				<th><?php echo __('Description'); ?></th>
				<th><?php echo __('Factory Code'); ?></th>
				<th><?php echo __('Picture'); ?></th>
				<th><?php echo __('Lc State'); ?></th>
				<th><?php echo __('Lc Transaction'); ?></th>
				<th><?php echo __('Creator'); ?></th>
				<th><?php echo __('Date Created'); ?></th>
				<th><?php echo __('Modifier'); ?></th>
				<th><?php echo __('Date Modified'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($invBrand['InvItem'] as $invItem): ?>
			<tr>
				<td><?php echo $invItem['id'];?></td>
				<td><?php echo $invItem['inv_brand_id'];?></td>
				<td><?php echo $invItem['inv_category_id'];?></td>
				<td><?php echo $invItem['code'];?></td>
				<td><?php echo $invItem['name'];?></td>
				<td><?php echo $invItem['description'];?></td>
				<td><?php echo $invItem['factory_code'];?></td>
				<td><?php echo $invItem['picture'];?></td>
				<td><?php echo $invItem['lc_state'];?></td>
				<td><?php echo $invItem['lc_transaction'];?></td>
				<td><?php echo $invItem['creator'];?></td>
				<td><?php echo $invItem['date_created'];?></td>
				<td><?php echo $invItem['modifier'];?></td>
				<td><?php echo $invItem['date_modified'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'inv_items', 'action' => 'view', $invItem['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'inv_items', 'action' => 'edit', $invItem['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'inv_items', 'action' => 'delete', $invItem['id']), null, __('Are you sure you want to delete # %s?', $invItem['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Inv Item')), array('controller' => 'inv_items', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
