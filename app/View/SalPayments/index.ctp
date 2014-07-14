<div class="span12">
	<h3>
		<?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('Lista de %s', __('Cobros'));?>
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
			<th><?php echo $this->BootstrapPaginator->sort('sal_payment_type_id', 'Tipo de Cobro');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('date_created', 'Fecha');?></th>				
			<th><?php echo $this->BootstrapPaginator->sort('sal_sale_id', 'Documento');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('description', 'Descripcion');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('amount', 'Monto');?></th>				
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($salPayments as $salPayment): ?>
		<tr>
			<td><?php echo $cont++;?></td>
			<td>
				<?php echo $this->Html->link($salPayment['SalPaymentType']['name'], array('controller' => 'sal_payment_types', 'action' => 'view', $salPayment['SalPaymentType']['id'])); ?>
			</td>
			<td><?php echo h($salPayment['SalPayment']['date_created']); ?>&nbsp;</td>
			<td>
				<?php echo $this->Html->link($salPayment['SalSale']['id'], array('controller' => 'sal_sales', 'action' => 'view', $salPayment['SalSale']['id'])); ?>
			</td>
			<td><?php echo h($salPayment['SalPayment']['description']); ?>&nbsp;</td>
			<td><?php echo h($salPayment['SalPayment']['amount']); ?>&nbsp;</td>				
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('action' => 'view', $salPayment['SalPayment']['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $salPayment['SalPayment']['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $salPayment['SalPayment']['id']), null, __('Are you sure you want to delete # %s?', $salPayment['SalPayment']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</div>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>