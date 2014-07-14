<?php echo $this->Html->script('modules/PurPurchasesIndex', FALSE); ?> 
<!--<div class="row-fluid">--> <!-- No va porque ya esta dentro del row-fluid del container del template principal-->
<?php echo  $this->BootstrapPaginator->options(array('url' => $this->passedArgs));?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<h3>	<!-- <?php echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'save_invoice'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo')); ?> -->
			<?php echo __('Facturas de Compra');?></h3>
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
			<?php echo $this->BootstrapForm->create('PurPurchase', array('class' => 'form-search', 'novalidate' => true));?>
			<fieldset>
						<?php
//						echo $this->BootstrapForm->input('doc_code', array(				
//										//'label' => 'Codigo Entrada:',
//										'id'=>'txtCode',
//										'value'=>$doc_code,
//										'placeholder'=>'Codigo'
//										));
						echo $this->BootstrapForm->input('searchDate', array(				
							'id'=>'txtDate',
							'value'=>$searchDate,
							'placeholder'=>'Fecha'
						));
						echo "&nbsp;";
						echo $this->BootstrapForm->input('note_code', array(				
								'id'=>'txtNoteCode',
								'value'=>$note_code,
								'placeholder'=>'Cod. Factura de Compra'
								));
						?>

					<?php
						echo $this->BootstrapForm->submit('<i class="icon-search icon-white"></i>',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSearch', 'title'=>'Buscar'));
						echo "&nbsp;";
						echo $this->BootstrapForm->submit('<i class="icon-trash icon-white" ></i>',array('class'=>'btn btn-danger','div'=>false, 'id'=>'btnClearSearch', 'title'=>'Limpiar Busqueda'));
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
				<h5><?php echo $this->BootstrapPaginator->counter(array('format' => __('Página {:page} de {:pages}, mostrando {:current} registros de {:count} total, comenzando en {:start}, terminando en {:end}')));?></h5>
			</div>
			<div class="widget-content nopadding">
		<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->

			<?php $cont = $this->BootstrapPaginator->counter('{:start}'); ?>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th><?php echo '#';?></th>
		<!--		<th><?php echo $this->BootstrapPaginator->sort('doc_code', 'Código');?></th>			-->
				<th><?php echo $this->BootstrapPaginator->sort('date', 'Fecha');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('note_code','Cod. Factura de Compra');?></th>
		<!--		<th><?php echo $this->BootstrapPaginator->sort('InvSupplier.name','Proveedor');?></th>	-->
				<th><?php echo $this->BootstrapPaginator->sort('inv_warehouse_id', 'Almacén Destino');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state', 'Estado Documento');?></th>				
			</tr>
		<?php foreach ($purPurchases as $purPurchase): ?>
			<tr>
				<td><?php echo $cont++;?></td>				
		<!--		<td><?php echo h($purPurchase['PurPurchase']['doc_code']); ?>&nbsp;</td>	-->
				<td><?php echo date("d/m/Y", strtotime($purPurchase['PurPurchase']['date'])); ?>&nbsp;</td>
				<td><?php echo h($purPurchase['PurPurchase']['note_code']); ?>&nbsp;</td>
		<!--		<td><?php echo h($purPurchase['InvSupplier']['name']); ?>&nbsp;</td>		-->		
				<td><?php echo h($purPurchase['InvWarehouse']['name']); ?>&nbsp;</td>
				<td><?php 
						$documentState = $purPurchase['PurPurchase']['lc_state'];
						switch ($documentState){
							case 'PINVOICE_PENDANT':
								$stateColor = 'btn-warning';
								$stateName = 'Factura Pendiente';
								break;
							case 'PINVOICE_APPROVED':
								$stateColor = 'btn-success';
								$stateName = 'Factura Aprobada';
								break;
							case 'PINVOICE_CANCELLED':
								$stateColor = 'btn-danger';
								$stateName = 'Factura Cancelada';
								break;						
						}
						///////////START - SETTING URL AND PARAMETERS/////////////
					$url = array();
					$parameters = $this->passedArgs;
						$url['action'] = 'save_invoice';
						$parameters['id']=$purPurchase['PurPurchase']['id'];
						
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
</div><!-- FIN CONTAINER FLUID/ROW FLUID/SPAN12 - Del Template Principal #UNICORN
<!-- ************************************************************************************************************************ -->
<!--</div>--><!-- No va porque ya esta dentro del row-fluid del container del template principal-->