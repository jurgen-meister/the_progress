<div class="span12">
	<h3><?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de %s', __('Parametros'));?>
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
			<th><?php echo $this->BootstrapPaginator->sort('Nombre');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('Descripccion');?></th>				
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($admParameters as $admParameter): ?>
		<tr>
			<td><?php echo $cont++;?></td>
			<td><?php echo h($admParameter['AdmParameter']['name']); ?>&nbsp;</td>
			<td><?php echo h($admParameter['AdmParameter']['description']); ?>&nbsp;</td>				
			<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('action' => 'view', $admParameter['AdmParameter']['id'])); ?>
				<?php echo $this->Html->link('<i class= "icon-pencil icon-white"></i>', array('action' => 'edit', $admParameter['AdmParameter']['id']),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $admParameter['AdmParameter']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar'), __('Are you sure you want to delete # %s?', $admParameter['AdmParameter']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</div>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>