<div class="span12">
	<h3>
		<?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de Marcas');?>
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
			<th><?php echo '#';?></th>
			<th><?php echo $this->BootstrapPaginator->sort('name', 'Nombre');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('description', 'Descripcion');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('country_source', 'Pais de Origen:');?></th>
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($invBrands as $invBrand): ?>
		<tr>
			<td><?php echo $cont++; ?>&nbsp;</td>
			<td><?php echo h($invBrand['InvBrand']['name']); ?>&nbsp;</td>
			<td><?php echo h($invBrand['InvBrand']['description']); ?>&nbsp;</td>
			<td><?php echo h($invBrand['InvBrand']['country_source']); ?>&nbsp;</td>
			<td class="actions">
				<?php //echo $this->Html->link(__('Ver'), array('action' => 'view', $invBrand['InvBrand']['id'])); ?>
				<?php echo $this->Html->link('<i class= "icon-pencil icon-white"></i>', array('action' => 'edit', $invBrand['InvBrand']['id']),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $invBrand['InvBrand']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar'), __('Esta seguro de eliminar?', $invBrand['InvBrand']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</div>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>