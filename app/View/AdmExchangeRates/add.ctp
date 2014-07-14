<?php echo $this->Html->script('modules/AdmExchangeRates', FALSE); ?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Crear Tipo de Cambio </h5>
	</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('AdmExchangeRate', array('class' => 'form-horizontal'));?>
			<fieldset>
				<?php
				echo $this->BootstrapForm->input('currency', array(
					'label' => '* Moneda:',
					'required' => 'required',
					//'disabled'=>true,
					'type'=>'select',
					'options'=>array(1=>"Dolar"),
					"value"=>0
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
					)
				);
				echo $this->BootstrapForm->input('date', array(
					'style' => 'width: 400px',
					'id' => 'txtDate',
					'label' => '* Fecha',
					'required' => 'required',
					'type' => 'text',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
					)					
				);
				echo $this->BootstrapForm->input('value', array(
					'label' => '* Monto en bolivianos:',
					'required' => 'required',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
					)
				);		
				?>
				<div class="row-fluid">
				<div class="span2"></div>
				<div class="span6">
				<div class="btn-toolbar">
				<?php echo $this->BootstrapForm->submit('Guardar', array('id'=>'saveButton', 'class' => 'btn btn-primary', 'div' => false));
					   echo $this->Html->link('Cancelar', array('action' => 'index'), array('class'=>'btn') );
				?>
				</div>				
				</div>
				<div class="span4"></div>
			</div>	
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>