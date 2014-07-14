<?php echo $this->Html->script('modules/AdmPeriods', FALSE);?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Crear nuevo periodo</h5>
	</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('AdmPeriod', array('class' => 'form-horizontal'));?>
				<?php
				echo $this->BootstrapForm->input('name', array(
					'required' => 'required',
					'label'=>'Gestión',
					'value'=>$newPeriod,
					'id'=>'txtPeriod',
					'readonly'=>'readonly',
				));
				?>
		<div class="form-actions" style="text-align: center">
				<a href="#myAlert" data-toggle="modal" class="btn btn-primary">Crear nueva gestión</a>
				<?php echo ' '.$this->Html->link('Cancelar', array_merge(array('action'=>'index')), array('class'=>'btn') );?>
		</div>
		<?php	echo $this->BootstrapForm->end();?>
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->	
	
	

<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>

<!-- ****************************************************** Modal Alert**************************************************************** -->
<div id="myAlert" class="modal hide">
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3>Crear nueva gestión</h3>
	</div>
	<div class="modal-body">
		<p>Se creará la gestión <span id="spaPeriod"><?php echo $newPeriod;?></span>, una vez creada no se podra eliminar ¿está seguro?</p>
	</div>
	<div class="modal-footer">
		<a data-dismiss="modal" class="btn btn-primary" id="btnYes" href="#">SI</a>
		<a data-dismiss="modal" class="btn" href="#">NO</a>
	</div>
</div>