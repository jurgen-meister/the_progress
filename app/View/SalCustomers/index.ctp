<?php  echo  $this->BootstrapPaginator->options(array('url' => $this->passedArgs));?>	
<div class="span12">
	<h3>
		<?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'vsave'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
		<?php echo __('%s', __('Clientes'));?>
	</h3>
	
	<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-search"></i>
				</span>
				<h5>Filtro</h5>
			</div>
			<div class="widget-content nopadding">
			<!-- ////////////////////////////////////////INCIO - FORMULARIO BUSQUEDA////////////////////////////////////////////////-->
			<?php echo $this->BootstrapForm->create('SalCustomer', array('class' => 'form-search', 'novalidate' => true));?>
			<fieldset>
						<?php
						echo $this->BootstrapForm->input('name', array(											
										'id'=>'txtName',
										'value'=>$name,
										'placeholder'=>'Nombre Cliente',
										'class'=>'span4'
										));
						?>				

					<?php
						echo $this->BootstrapForm->submit('<i class="icon-search icon-white"></i>',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSearch', 'title'=>'Buscar'));
					?>

			</fieldset>
			<?php echo $this->BootstrapForm->end();?>
			<!-- ////////////////////////////////////////FIN - FORMULARIO BUSQUEDA////////////////////////////////////////////////-->		
			</div>
		</div>

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
			<th><?php echo $this->BootstrapPaginator->sort('name','Nombre');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('address','Direccion');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('phone','Telf./Cel.');?></th>
			<th><?php echo $this->BootstrapPaginator->sort('email');?></th>				
			<th class="actions"><?php echo __('Acciones');?></th>
		</tr>
	<?php foreach ($salCustomers as $salCustomer): ?>
		<tr>
			<td><?php echo $cont++;?></td>
			<td><?php echo h($salCustomer['SalCustomer']['name']); ?>&nbsp;</td>
			<td><?php echo h($salCustomer['SalCustomer']['address']); ?>&nbsp;</td>
			<td><?php echo h($salCustomer['SalCustomer']['phone']); ?>&nbsp;</td>
			<td><?php echo h($salCustomer['SalCustomer']['email']); ?>&nbsp;</td>				
			<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('action' => 'view', $salCustomer['SalCustomer']['id'])); ?>
				<?php 
							$url = array();
							$parameters = $this->passedArgs;
						
							
							$url['action'] = 'vsave';
							$parameters['id'] = $salCustomer['SalCustomer']['id'];
					   echo $this->Html->link('<i class= "icon-pencil icon-white"></i>',array_merge($url, $parameters),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); ?>
				<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $salCustomer['SalCustomer']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar'), __('Está seguro de eliminar este cliente?', $salCustomer['SalCustomer']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</div>

	<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>