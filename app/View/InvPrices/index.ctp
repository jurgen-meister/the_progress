<div class="span12">
	<h3><?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de %s', __('Precios'));?>
	</h3>

	<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-th"></i>
		</span>
		<h5><?php echo $this->BootstrapPaginator->counter(array('format' => __('Página {:page} de {:pages}, mostrando {:current} de un total de {:count} registros')));?></h5>
	</div>
	<div class="widget-content nopadding">

	<?php $cont = $this->BootstrapPaginator->counter('{:start}');?>
	<table class="table table-striped table-bordered table-hover">
		<tr>
			<th><?php echo "#";?></th>
			<th><?php echo $this->BootstrapPaginator->sort('inv_item_id', 'Item');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('inv_price_type_id', 'Tipo de Precio');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('price', 'Monto');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('description', 'Descripcion');?></th>				
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($invPrices as $invPrice): ?>
		<tr>
			<td><?php echo $cont++;?></td>
			<td>
				<?php echo $this->Html->link($invPrice['InvItem']['full_name'], array('controller' => 'inv_items', 'action' => 'view', $invPrice['InvItem']['id'])); ?>
			</td>
			<td>
				<?php echo $this->Html->link($invPrice['InvPriceType']['name'], array('controller' => 'inv_price_types', 'action' => 'view', $invPrice['InvPriceType']['id'])); ?>
			</td>
			<td><?php echo h($invPrice['InvPrice']['price']); ?>&nbsp;</td>
			<td><?php echo h($invPrice['InvPrice']['description']); ?>&nbsp;</td>				
			<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('action' => 'view', $invPrice['InvPrice']['id'])); ?>
				<?php echo $this->Html->link('<i class= "icon-pencil icon-white"></i>', array('action' => 'edit', $invPrice['InvPrice']['id']),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $invPrice['InvPrice']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar'), __('Are you sure you want to delete # %s?', $invPrice['InvPrice']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</div>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>	