<?php echo $this->Html->script('jquery.flot.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.pie.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.resize.min', FALSE); ?>
<?php echo $this->Html->script('unicorn', FALSE); ?>
<?php echo $this->Html->script('jquery.dataTables.min.js', FALSE); ?>
<?php echo $this->Html->script('jquery.uniform.js', FALSE); ?>
<?php echo $this->Html->script('modules/InvGraphics', FALSE); ?>


<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN -->
<!-- ************************************************************************************************************************ -->
	<!-- //////////////////////////// Start - buttons /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-content nopadding">
			<a href="#" id="btnGenerateGraphicsHistoricalPrices" class="btn btn-primary noPrint "><i class="icon-cog icon-white"></i> Generar Gráficas (abajo)</a>
			<div id="boxMessage"></div>
			<div id="boxProcessing" align="center"></div>
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->
	
	<!-- //////////////////////////// Start - filters /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class=" icon-search"></i>
			</span>
			<h5>Gráficas Items - Historicos de Precios</h5>
		</div>
		<div class="widget-content nopadding">
			<?php echo $this->BootstrapForm->create('InvMovement', array('class' => 'form-horizontal', 'novalidate' => true));?>
				<?php
				 echo $this->BootstrapForm->input('start_date', array(
					'label' => '* Fecha Inicio:',
					'id'=>'txtReportStartDate',
					 'class'=>'input-date-type' 
				  ));

				  echo $this->BootstrapForm->input('finish_date', array(
					'label' => '* Fecha Fin:',
					'id'=>'txtReportFinishDate',
					  'class'=>'input-date-type' 
				  ));
				  
				  echo $this->BootstrapForm->input('currency', array(
					'label' => '* Moneda:',
					'id'=>'cbxReportCurrency',
					'type'=>'select',
					'options'=>array('BOLIVIANOS'=>'BOLIVIANOS', 'DOLARES'=>'DOLARES'),
					'class'=>'span4'  
				  ));
				  
				  echo $this->BootstrapForm->input('items', array(
					'label' => '* Item:',
					'id'=>'cbxItems',
					'type'=>'select',
					'options'=>$items,
					'class'=>'span8'  
				  ));
				  echo "<br>";
/*
				echo $this->BootstrapForm->input('type', array(
				'label' => '* Agrupar por:',
				'id'=>'cbxReportGroupTypes',
				'type'=>'select',
				'class'=>'span3',    
				'options'=>array('none'=>'Ninguno','brand'=>'Marca','category'=> 'Categoria')  
				)); 
*/
				?>
			
			<?php echo $this->BootstrapForm->end();?>
			
			
		</div>
	</div>
	<!-- //////////////////////////// End - filters /////////////////////////////////-->
	
<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class=" icon-signal"></i>
				</span>
				<h5>Historico Precios FOB</h5>
			</div>
			<div class="widget-content nopadding">
				<div class="bars"></div>
			</div>	
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class=" icon-signal"></i>
				</span>
				<h5>Historico Precios CIF</h5>
			</div>
			<div class="widget-content nopadding">
				<div class="bars2"></div>
			</div>	
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class=" icon-signal"></i>
				</span>
				<h5>Historico Precios de Ventas</h5>
			</div>
			<div class="widget-content nopadding">
				<div class="bars3"></div>
			</div>	
		</div>
	</div>
</div>
<!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->
		
	
	
<!-- ************************************************************************************************************************ -->
</div><!-- END CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN
<!-- ************************************************************************************************************************ -->