<?php //debug($this->request->data);?>
<?php echo $this->Html->script('modules/AdmMenus', FALSE); ?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<h3>
<?php
echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add', $idParentMenu), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo')); 
?>
<?php echo __(' Menus');?></h3>

<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-search"></i>
				</span>
				<h5>Filtro - Menus padres</h5>
			</div>
			<div class="widget-content nopadding">
			<!-- ////////////////////////////////////////INCIO - FORMULARIO BUSQUEDA////////////////////////////////////////////////-->
			<?php echo $this->BootstrapForm->create('formAdmMenuIndexOut', array('id'=>'formAdmMenuIndexOut','class' => 'form-search span3', 'novalidate' => true));?>
			<fieldset>
						<?php
						echo $this->BootstrapForm->input('parentsMenus', array(				
										//'label' => 'Módulo:',
										'id'=>'cbxSearchModules',
										'value'=>$idParentMenu,
							
										'options'=>$parentsMenus,
										'type'=>'select',
										'placeholder'=>'Codigo Entrada',
										'class'=>'span12'
										));
						?>
			</fieldset>
			<?php echo $this->BootstrapForm->end();?>
			<?php 
			echo ' ';
			$url['action'] = 'edit';
			echo $this->Html->link('<i class="icon-pencil icon-white"></i>'.__(''),  array_merge($url,array($idParentMenu, $idParentMenu)), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); 
			//I took out this delete postLink from the main form because is generates its own form and it doesn't work if it is inside the other form
			echo ' '.$this->Form->postLink('<i class="icon-trash icon-white"></i>', array_merge(array('action' => 'delete'), array($idParentMenu, $idParentMenu)), array('class'=>'btn btn-danger', 'escape'=>false, 'title'=>'Eliminar'), __('¿Esta seguro de eliminar este menu?', $idParentMenu)); 
			?>
			<!-- ////////////////////////////////////////FIN - FORMULARIO BUSQUEDA////////////////////////////////////////////////-->		
			</div>
		</div>
		<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->


		<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-th"></i>
				</span>
				<h5><?php echo $this->BootstrapPaginator->counter(array('format' => __('Página {:page} de {:pages}, mostrando {:current} de un total de {:count} registros')));?></h5>
			</div>
			<div class="widget-content nopadding">
		<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		
		<?php $cont = $this->BootstrapPaginator->counter('{:start}');?>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th><?php echo '#';?></th>
				<th><?php echo $this->BootstrapPaginator->sort('name', 'Menu');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('order_menu', 'Orden');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('AdmModule.id', 'Módulo');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('AdmController.id', 'Controlador');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('adm_action_id', 'Acción');?></th>
				<th></th>
			</tr>
		<?php foreach ($admMenus as $admMenu): ?>
			<tr>
				<td><?php echo $cont++; ?>&nbsp;</td>
				<td><?php echo h($admMenu['AdmMenu']['name']); ?>&nbsp;</td>
				<td><?php echo h($admMenu['AdmMenu']['order_menu']); ?>&nbsp;</td>
				<td><?php echo $admMenu['AdmModule']['name'];?></td>
				<td><?php echo Inflector::camelize($admMenu['AdmController']['name']);?></td>
				<td><?php echo strtolower($admMenu['AdmAction']['name']); ?></td>
				<td>
					<?php 
					$url['action'] = 'edit';
					echo $this->Html->link('<i class="icon-pencil icon-white"></i>'.__(''),  array_merge($url,array($admMenu['AdmMenu']['id'], $idParentMenu)), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); 
					echo ' '.$this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $admMenu['AdmMenu']['id'], $idParentMenu), array('class'=>'btn btn-danger', 'escape'=>false, 'title'=>'Eliminar'), __('¿Esta seguro de borrar este menu?', $admMenu['AdmMenu']['id']));
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		</div>
	</div>
	<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		<?php echo $this->BootstrapPaginator->pagination(); ?>
<!-- ************************************************************************************************************************ -->
</div><!-- FIN CONTAINER FLUID/ROW FLUID/SPAN12 - Del Template Principal #UNICORN
<!-- ************************************************************************************************************************ -->