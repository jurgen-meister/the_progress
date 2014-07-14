<?php echo $this->Html->script('modules/InvMovementsIndex', FALSE); ?> 
<!--<div class="row-fluid">--> <!-- No va porque ya esta dentro del row-fluid del container del template principal-->
<?php echo  $this->BootstrapPaginator->options(array('url' => $this->passedArgs));?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
		<h3><?php
			echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'save_warehouses_transfer'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo')); 
			?>
<?php echo __(' Traslados entre Almacenes');?></h3>
		
		<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-search"></i>
				</span>
				<h5>Filtro</h5>
			</div>
			<div class="widget-content nopadding">
		<!-- ////////////////////////////////////////INCIO - FORMULARIO BUSQUEDA////////////////////////////////////////////////-->
		<?php echo $this->BootstrapForm->create('InvMovement', array('class' => 'form-search', 'novalidate' => true));?>
		<fieldset>
					<?php
					/*
					echo $this->BootstrapForm->input('document_code', array(				
							//'label' => 'Codigo Compra:',
							'id'=>'txtCodeDocument',
							'value'=>$document_code,
							'placeholder'=>'Codigo Transferencia'
							));
					*/
					echo $this->BootstrapForm->input('searchDate', array(				
							'id'=>'txtDate',
							'value'=>$searchDate,
							'placeholder'=>'Fecha de Traslado',
						'class'=>'input-date-type'
						));
					?>
				<?php
					echo $this->BootstrapForm->submit('<i class="icon-search icon-white"></i>',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSearch', 'title'=>'Buscar'));
					echo $this->BootstrapForm->submit('<i class="icon-trash icon-white"></i>',array('class'=>'btn btn-danger','div'=>false, 'id'=>'btnClearSearch', 'title'=>'Limpiar Busqueda'));
				?>
		</fieldset>
		<?php echo $this->BootstrapForm->end();?>
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
				<th><?php echo "#";?></th>
				<!--<th><?php// echo 'Codigo Transferencia';?></th>-->
				<th><?php echo $this->BootstrapPaginator->sort('date', 'Fecha de Traslado');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_warehouse_id', 'Almacen Origen (Salida)');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('inv_warehouse_id', 'Almacen Destino (Entrada)');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state', 'Estado Documento');?></th>
			</tr>
		<?php foreach ($invMovements as $invMovement): ?>
			<tr>
				<td><?php echo $cont++;?></td>
				<!--<td>
					<?php 
					echo h($invMovement['InvMovement']['document_code']); 
					?>
					&nbsp;
				</td>-->
				
				<td>
					<?php 
					echo date("d/m/Y", strtotime($invMovement['InvMovement']['date']));
					?>
					&nbsp;
				</td>
				<td>
					<?php echo h($invMovement['InvWarehouse']['name']); ?>
				</td>
				<td>
					<?php 
					
					for($i=0; $i < count($warehouseDestination); $i++){
						if($invMovement['InvMovement']['document_code'] == $warehouseDestination[$i]['InvMovement']['document_code']){
							echo h($warehouseDestination[$i]['InvWarehouse']['name']); 
						}
					}
					?>
				</td>
				<td>
					<?php 
					
					$documentState = $invMovement['InvMovement']['lc_state'];
					switch ($documentState){
								case 'PENDANT':
									$stateColor = 'btn-warning';
									$stateName = 'Pendiente';
									break;
								case 'APPROVED':
									$stateColor = 'btn-success';
									$stateName = 'Aprobado';
									break;
								case 'CANCELLED':
									$stateColor = 'btn-danger';
									$stateName = 'Cancelado';
									break;
							}
					///////////START - SETTING URL AND PARAMETERS/////////////
					$url = array();
					$parameters = $this->passedArgs;
					$url['action']='save_warehouses_transfer';
					$parameters['document_code']=$invMovement['InvMovement']['document_code'];
					////////////END - SETTING URL AND PARAMETERS//////////////
					echo $this->Html->link('<i class="icon-pencil icon-white"></i>'.__(' '.$stateName),  array_merge($url,$parameters), array('class'=>'btn '.$stateColor, 'escape'=>false, 'title'=>'Editar')); 
					?>&nbsp;
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
</div><!-- FIN CONTAINER FLUID/ROW FLUID/SPAN12 - Del Template Principal #UNICORN-->