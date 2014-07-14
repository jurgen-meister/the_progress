<div class="span12">
	<h3>
		<?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Tipos de Movimiento');?>
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
			<th><?php echo $this->BootstrapPaginator->sort('status', 'Tipo');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('document', 'Documento');?></th>
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($invMovementTypes as $invMovementType): ?>
		<tr>
			<td><?php echo h($cont++); ?>&nbsp;</td>
			<td><?php echo h($invMovementType['InvMovementType']['name']); ?>&nbsp;</td>
			<td><?php echo h($invMovementType['InvMovementType']['status']); ?>&nbsp;</td>
			<td><?php 
			if($invMovementType['InvMovementType']['document'] == 1){
				echo "Si";
			}else{
				echo "No";
			}
			?>&nbsp;</td>
			<td class="actions">
				<?php //echo $this->Html->link(__('Ver'), array('action' => 'view', $invMovementType['InvMovementType']['id'])); ?>
				<?php echo $this->Html->link('<i class= "icon-pencil icon-white"></i>', array('action' => 'edit', $invMovementType['InvMovementType']['id']),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $invMovementType['InvMovementType']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar'), __('Are you sure you want to delete # %s?', $invMovementType['InvMovementType']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	</div>
</div>
