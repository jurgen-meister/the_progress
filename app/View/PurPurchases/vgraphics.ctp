<?php echo $this->Html->script('jquery.flot.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.pie.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.resize.min', FALSE); ?>
<?php echo $this->Html->script('unicorn', FALSE); ?>
<?php echo $this->Html->script('jquery.dataTables.min.js', FALSE); ?>
<?php echo $this->Html->script('jquery.uniform.js', FALSE); ?>
<?php echo $this->Html->script('modules/PurGraphics', FALSE); ?>


<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN -->
<!-- ************************************************************************************************************************ -->
	<!-- //////////////////////////// Start - buttons /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-content nopadding">
			<a href="#" id="btnGenerateGraphicsPurchases" class="btn btn-primary noPrint "><i class="icon-cog icon-white"></i> Generar Gráficas (abajo)</a>
			<div id="boxMessage"></div>
			<div id="boxProcessing" align="center"></div>
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->
	
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class=" icon-search"></i>
			</span>
			<h5>Filtros</h5>
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
				/*
				echo $this->BootstrapForm->input('month', array(
					'label' => 'Mes:',
					'id'=>'cbxMonth',
					'type'=>'select',
					'class'=>'span2',
					'options'=>array(0=>"Todos", 1=>"Enero", 2=>"Febrero", 3=>"Marzo", 4=>"Abril", 5=>"Mayo", 6=>"Junio", 7=>"Julio", 8=>"Agosto", 9=>"Septiembre", 10=>"Octubre", 11=>"Noviembre", 12=>"Diciembre") 
				));
				 * 
				 */
				echo $this->BootstrapForm->input('priceType', array(
					'label' => 'Tipo de precio:',
					'id'=>'cbxPriceType',
					'type'=>'select',
					'options'=>array("CIF"=>"CIF", "FOB"=>"FOB")
				));
				echo $this->BootstrapForm->input('currency', array(
					'label' => 'Moneda:',
					'id'=>'cbxCurrency',
					'type'=>'select',
					'options'=>array("bolivianos"=>"BOLIVIANOS", "dolares"=>"DOLARES")
				));
				/*
				echo $this->BootstrapForm->input('item', array(
					'label' => 'Item:',
					'id'=>'cbxItem',
					'class'=>'span8',
					'type'=>'select',
					'options'=>$items,
				));
				 * */
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
	
<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class=" icon-signal"></i>
				</span>
				<h5>Compras - Meses</h5>
			</div>
			<div class="widget-content nopadding">
				<div class="bars"></div>
			</div>	
		</div>
	</div>
</div>

<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
		
	
	
<!-- ************************************************************************************************************************ -->
</div><!-- END CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN
<!-- ************************************************************************************************************************ -->