<div class="span12">
	<h3>
		<?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de %s', __('Encargados'));?>
	</h3>

	<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-th"></i>
		</span>
		<h5><?php echo $this->BootstrapPaginator->counter(array('format' => __('Página {:page} de {:pages}, mostrando {:current} de un total de {:count} registros')));?></h5>
	</div>
		<?php $cont = $this->BootstrapPaginator->counter('{:start}');?>
	<table class="table table-striped table-bordered table-hover">
		<tr>
			<th><?php echo "#";?></th>
			<th><?php echo $this->BootstrapPaginator->sort('sal_customer_id', 'Cliente');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('name','Encargado(a)');?></th>				
			<th><?php echo $this->BootstrapPaginator->sort('phone', 'Telf./Cel.');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('email');?></th>				
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($salEmployees as $salEmployee): ?>
		<tr>
			<td><?php echo $cont++;?></td>
			<td>
				<?php echo $this->Html->link($salEmployee['SalCustomer']['name'], array('controller' => 'sal_customers', 'action' => 'view', $salEmployee['SalCustomer']['id'])); ?>
			</td>				
			<td><?php echo h($salEmployee['SalEmployee']['name']); ?>&nbsp;</td>				
			<td><?php echo h($salEmployee['SalEmployee']['phone']); ?>&nbsp;</td>
			<td><?php echo h($salEmployee['SalEmployee']['email']); ?>&nbsp;</td>				
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('action' => 'view', $salEmployee['SalEmployee']['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $salEmployee['SalEmployee']['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $salEmployee['SalEmployee']['id']), null, __('Are you sure you want to delete # %s?', $salEmployee['SalEmployee']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</div>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>