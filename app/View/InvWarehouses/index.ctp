<div class="span12">
	<h3>
		<?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de Almacenes');?>
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
			<th><?php echo ('#');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('name', 'Nombre');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('location', 'Ciudad y Pais');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('address', 'Dirección');?></th>
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($invWarehouses as $invWarehouse): ?>
		<tr>
			<td><?php echo h($cont++); ?>&nbsp;</td>
			<td><?php echo h($invWarehouse['InvWarehouse']['name']); ?>&nbsp;</td>
			<td><?php echo h($invWarehouse['InvWarehouse']['location']); ?>&nbsp;</td>
			<td><?php echo h($invWarehouse['InvWarehouse']['address']); ?>&nbsp;</td>
			<td class="actions">
				<?php //echo $this->Html->link(__('Ver'), array('action' => 'view', $invWarehouse['InvWarehouse']['id'])); ?>
				<?php echo $this->Html->link('<i class= "icon-pencil icon-white"></i>', array('action' => 'edit', $invWarehouse['InvWarehouse']['id']),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $invWarehouse['InvWarehouse']['id']),array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar') , __('Are you sure you want to delete # %s?', $invWarehouse['InvWarehouse']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	</div>
</div>