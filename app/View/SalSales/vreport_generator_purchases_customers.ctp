<?php echo $this->Html->script('jquery.flot.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.pie.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.resize.min', FALSE); ?>
<?php echo $this->Html->script('unicorn', FALSE); ?>
<?php echo $this->Html->script('jquery.dataTables.min.js', FALSE); ?>
<?php echo $this->Html->script('jquery.uniform.js', FALSE); ?>
<?php echo $this->Html->script('modules/SalGraphics', FALSE); ?>


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
			<a href="#" id="btnGenerateReportPurchasesCustomers" class="btn btn-primary noPrint "><i class="icon-cog icon-white"></i> Generar Reporte</a>
			<div id="boxMessage"></div>
			<div id="boxProcessing" align="center"></div>
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->

	<!-- //////////////////////////// Start - buttons /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class=" icon-search"></i>
			</span>
			<h5>Reporte Ventas - Compras de Clientes</h5>
		</div>
		<div class="widget-content nopadding">
			<?php 
				/////////////////START - SETTINGS BUTTON CANCEL /////////////////
				//echo $this->Html->link('<i class="icon-cog icon-white"></i> Generar Reporte', array('#'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo', 'id'=>'btnPrint')); 
			?>
			<?php echo $this->BootstrapForm->create('InvMovement', array('class' => 'form-horizontal', 'novalidate' => true));?>
				<?php
				echo $this->BootstrapForm->input('year', array(
					'label' => 'Gestión:',
					'id'=>'cbxYear',
					'type'=>'select',
					'class'=>'span2',
					'options'=>$years 
				));
				echo $this->BootstrapForm->input('month', array(
					'label' => 'Mes:',
					'id'=>'cbxMonth',
					'type'=>'select',
					'class'=>'span2',
					'options'=>$months 
				));
				
				echo $this->BootstrapForm->input('customer', array(
					'label' => 'Cliente:',
					'id'=>'cbxCustomer',
					'type'=>'select',
					'class'=>'span6',
					'options'=>$customers 
				));
				
				echo $this->BootstrapForm->input('show', array(
					'label' => 'Mostrar:',
					'id'=>'cbxShowZero',
					'type'=>'select',
					'class'=>'span3',
					'options'=>array("no"=>"Valores Sin Cero", "yes"=>"Valores Con Cero") 
				));
				echo $this->BootstrapForm->input('currency', array(
					'label' => 'Moneda:',
					'id'=>'cbxCurrency',
					'type'=>'select',
					'options'=>array("bolivianos"=>"BOLIVIANOS", "dolares"=>"DOLARES")
				));
				echo $this->BootstrapForm->input('type', array(
				'label' => '* Agrupar por:',
				'id'=>'cbxReportGroupTypes',
				'type'=>'select',
				'class'=>'span3',    
				'options'=>array('none'=>'Ninguno','brand'=>'Marca','category'=> 'Categoria')  
				));
				?>
			<?php echo $this->BootstrapForm->end();?>
			
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
			
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->
	
<!-- ************************************************************************************************************************ -->
</div><!-- END CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN
<!-- ************************************************************************************************************************ -->