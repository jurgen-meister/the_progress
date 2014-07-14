<div class="span12">
	<h3>
		<?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de %s', __('Contactos'));?>
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
			<th><?php echo $this->BootstrapPaginator->sort('inv_supplier_id','Proveedor');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('name','Nombre');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('phone','Teléfono');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('job_title','Cargo');?></th>			
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($invSupplierContacts as $invSupplierContact): ?>
		<tr>
			<td><?php echo h($cont++); ?>&nbsp;</td>
			<td>
				<?php echo $this->Html->link($invSupplierContact['InvSupplier']['name'], array('controller' => 'inv_suppliers', 'action' => 'view', $invSupplierContact['InvSupplier']['id'])); ?>
			</td>
			<td><?php echo h($invSupplierContact['InvSupplierContact']['name']); ?>&nbsp;</td>
			<td><?php echo h($invSupplierContact['InvSupplierContact']['phone']); ?>&nbsp;</td>
			<td><?php echo h($invSupplierContact['InvSupplierContact']['job_title']); ?>&nbsp;</td>			
			<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('action' => 'view', $invSupplierContact['InvSupplierContact']['id'])); ?>
				<?php echo $this->Html->link('<i class= "icon-pencil icon-white"></i>', array('action' => 'edit', $invSupplierContact['InvSupplierContact']['id']),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $invSupplierContact['InvSupplierContact']['id']),array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar') , __('Are you sure you want to delete # %s?', $invSupplierContact['InvSupplierContact']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	</div>
</div>