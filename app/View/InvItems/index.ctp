<?php  echo  $this->BootstrapPaginator->options(array('url' => $this->passedArgs));?>	
<div class="span12">
		<h3><?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo'));?>
			<?php echo __('Lista de %s', __('Productos'));?>
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
			<?php echo $this->BootstrapForm->create('InvItem', array('class' => 'form-search', 'novalidate' => true));?>
			<fieldset>
						<?php
						echo $this->BootstrapForm->input('code', array(											
										'id'=>'txtCode',
										'value'=>$code,
										'placeholder'=>'Codigo producto'
										));
						/*
						echo $this->BootstrapForm->input('item', array(											
									'id'=>'txtItem',
									'value'=>$code,
									'placeholder'=>'Nombre producto'
									));
						 * 
						 */
						echo $this->BootstrapForm->input('stock', array(											
										'id'=>'cbxStock',
										'value'=>$valueWarehouse,
										'options'=>$warehouses,
										'type'=>'select',
										'label'=>'Stock: ',
//										'class'=>'span3'
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
		<div class="widget-content nopadding">
		
		<?php $cont = $this->BootstrapPaginator->counter('{:start}');?>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th><?php echo "#";?></th>
				<th><?php echo 'Código';?></th>
				<th><?php echo 'Nombre';?></th>
				<th><?php echo 'Marca';?></th>
				<th><?php echo 'Categoría';?></th>
<!--				<th><?php echo 'Descripción';?></th>   -->
				<th style="width:30%"><?php echo 'Descripción';?></th>
				<th><?php echo 'Stock';?></th>
				<th class="actions"><?php echo __('Acciones');?></th>
			</tr>
		<?php foreach ($invItems as $invItem): ?>
			<tr>
				<td><?php echo $cont++;?></td>
				<td><?php echo $invItem['InvItem']['code']; ?></td>
				<td><?php echo $invItem['InvItem']['name']; ?></td>
				<td><?php echo $invItem['InvBrand']['name']; ?></td>
				<td><?php echo h($invItem['InvCategory']['name']); ?>&nbsp;</td>
				<td><?php echo h($invItem['InvItem']['description']); ?>&nbsp;</td>
				<td style="text-align: center;"><?php echo h($invItem['InvItem']['stock']); ?>&nbsp;</td>
				<td class="actions" style="width: 84px">
					<?php //echo $this->Html->link(__('View'), array('action' => 'view', $invItem['InvItem']['id'])); ?>
					<?php 
							$url = array();
							$parameters = $this->passedArgs;
						
							
							$url['action'] = 'save_item';
							$parameters['id'] = $invItem['InvItem']['id'];
							$stockArg = 0;
							if(isset($this->passedArgs["stock"])){
								$stockArg = $this->passedArgs["stock"];
							}
							$parameters['stock'] = $stockArg;
							echo $this->Html->link('<i class= "icon-pencil icon-white"></i>',array_merge($url,$parameters),array('class' => 'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); //array('action' => 'save_item', $invItem['InvItem']['id']));  ?>
					<?php echo $this->Form->postLink('<i class= "icon-trash icon-white"></i>', array('action' => 'delete', $invItem['InvItem']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title' => 'Eliminar'), __('Are you sure you want to delete # %s?', $invItem['InvItem']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		</div>
		</div>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
</div>
