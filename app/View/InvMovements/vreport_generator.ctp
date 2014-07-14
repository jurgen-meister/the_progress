<?php echo $this->Html->script('jquery.dataTables.min.js', FALSE); ?>
<?php echo $this->Html->script('jquery.uniform.js', FALSE); ?>
<?php echo $this->Html->script('modules/InvReports', FALSE); ?>

<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN -->
<!-- ************************************************************************************************************************ -->
	<!-- //////////////////////////// Start - buttons /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-content nopadding">
			<?php 
				/////////////////START - SETTINGS BUTTON CANCEL /////////////////
				//echo $this->Html->link('<i class="icon-cog icon-white"></i> Generar Reporte', array('#'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo', 'id'=>'btnPrint')); 
			?>
			<a href="#" id="btnGenerateReport" class="btn btn-primary noPrint "><i class="icon-cog icon-white"></i> Generar Reporte</a>
			<div id="boxMessage"></div>
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->

		<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class=" icon-search"></i>
				</span>
				<h5>Reporte de Movimientos de Inventario</h5>
			</div>
			<div class="widget-content nopadding">
			<!-- ////////////////////////////////////////START - FILTERS////////////////////////////////////////////////-->
				
					<form class="form-horizontal">
					  
						<?php 
						echo '<div class="row-fluid">';
						  echo $this->BootstrapForm->input('start_date', array(
							'label' => '* Fecha Inicio:',
							'id'=>'txtReportStartDate',
							  'class'=>'input-date-type' 
//							,'type'=>'date'  
						  ));
						  
						  echo $this->BootstrapForm->input('finish_date', array(
							'label' => '* Fecha Fin:',
							'id'=>'txtReportFinishDate',
							  'class'=>'input-date-type' 
						  ));
						echo '</div>';
						
						echo '<div class="row-fluid">';
						  echo $this->BootstrapForm->input('movement_type', array(
							'label' => '* Tipo de Movimiento:',
							'id'=>'cbxReportMovementTypes',
							'type'=>'select',
							'class'=>'span6',  	
							'options'=>array(1000=>'TODAS LAS ENTRADAS Y SALIDAS', 998=>'TODAS LAS ENTRADAS', 999=>'TODAS LAS SALIDAS', 1001=>'TRASPASOS ENTRE ALMACENES', 1=>'Entradas de compra', 5=>'Entradas de apertura',4=>'Entradas de traspaso', 6=>'Entradas otras', 2=>'Salidas de venta', 3=>'Salidas de traspaso', 7=>'Salidas otras')  
						  ));
						echo '</div>';
						  
						echo '<div class="row-fluid" id="boxWarehouse">';
						  echo $this->BootstrapForm->input('warehouse', array(
							'label' => '* Almacen:',
							'id'=>'cbxReportWarehouse',
							'type'=>'select',
							//'multiple'=>'multiple',
							'options'=>$warehouse,
							//'selected'=>  array_keys($warehouse),
							'class'=>'span4'  
						  ));
						echo '</div>';
						
						echo '<div class="row-fluid" id="boxWarehouse2" style="display:none;">';
						  echo $this->BootstrapForm->input('warehouse2', array(
							'label' => '* Almacen a Comparar:',
							'id'=>'cbxReportWarehouse2',
							'type'=>'select',
							'options'=>$warehouseClean,
							'class'=>'span4',
						  ));
						echo '</div>';
						
						echo '<div class="row-fluid">';
						  echo $this->BootstrapForm->input('currency', array(
							'label' => '* Moneda:',
							'id'=>'cbxReportCurrency',
							'type'=>'select',
							//'multiple'=>'multiple',
							'options'=>array('BOLIVIANOS'=>'BOLIVIANOS', 'DOLARES'=>'DOLARES'),
							//'selected'=>  array_keys($warehouse),
							'class'=>'span4'  
						  ));
						echo '</div>';
						
						
						echo '<div class="row-fluid">';
						  echo $this->BootstrapForm->input('detail', array(
							'label' => '* Mostrar reporte:',
							'id'=>'cbxDetail',
							'type'=>'select',
							'options'=>array('YES'=>'Detallado', 'NO'=>'Totales'),
							'class'=>'span2'  
						  ));
						echo '</div>';
						
						
						echo '<div class="row-fluid">';
						  echo $this->BootstrapForm->input('type', array(
							'label' => '* Agrupar por:',
							'id'=>'cbxReportGroupTypes',
							'type'=>'select',
							'class'=>'span4',    
							'options'=>array('none'=>'Ninguno','brand'=>'Marca','category'=> 'Categoria')  
						  ));
						 echo '</div>';	  
				?>
			</form>
			
			<div id="boxProcessing" align="center"></div>
			<div id="boxGroupItemsAndFilters">
				<table class="table table-bordered data-table with-check">
					<thead>
					<tr>
						<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" checked="checked" /></th>
						<th>Item</th>
						<th>Marca</th>
						<th>Categoria</th>
					</tr>
					</thead>

					<tbody>
					<?php foreach($item as $val){ ?>	
					<tr>
						<td><input type="checkbox" checked="checked" value="<?php echo $val['InvItem']['id'];?>" /></td>
						<td><?php echo '[ '.$val['InvItem']['code'].' ] '.$val['InvItem']['name'];?></td>
						<td><?php echo $val['InvBrand']['name'];?></td>
						<td><?php echo $val['InvCategory']['name'];?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>  
			</div>
			<!-- ////////////////////////////////////////END - FILTERS////////////////////////////////////////////////-->		
			</div>
		<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
		</div>
		
<!-- ************************************************************************************************************************ -->
</div><!-- END CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN
<!-- ************************************************************************************************************************ -->
