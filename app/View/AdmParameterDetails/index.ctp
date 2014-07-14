<div class="span12">
	<h3><?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de %s', __('Parametros Detalle'));?>
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
			<th><?php echo $this->BootstrapPaginator->sort('adm_parameter_id');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_int1');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_int2');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_char1');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_char2');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_num1');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_num2');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_bool1');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('par_bool2');?></th>				
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($admParameterDetails as $admParameterDetail): ?>
		<tr>
			<td><?php echo $cont++;?></td>
			<td>
				<?php echo $this->Html->link($admParameterDetail['AdmParameter']['name'], array('controller' => 'adm_parameters', 'action' => 'view', $admParameterDetail['AdmParameter']['id'])); ?>
			</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_int1']); ?>&nbsp;</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_int2']); ?>&nbsp;</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_char1']); ?>&nbsp;</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_char2']); ?>&nbsp;</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_num1']); ?>&nbsp;</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_num2']); ?>&nbsp;</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_bool1']); ?>&nbsp;</td>
			<td><?php echo h($admParameterDetail['AdmParameterDetail']['par_bool2']); ?>&nbsp;</td>				
			<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('action' => 'view', $admParameterDetail['AdmParameterDetail']['id'])); ?>
				<?php echo $this->Html->link('<i class= "icon-pencil icon-white"></i>', array('action' => 'edit', $admParameterDetail['AdmParameterDetail']['id']),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $admParameterDetail['AdmParameterDetail']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar'), __('Are you sure you want to delete # %s?', $admParameterDetail['AdmParameterDetail']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</div>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>