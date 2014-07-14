<?php echo $this->Html->script('modules/AdmAreas', FALSE);?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Crear area de la empresa</h5>
	</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('AdmArea', array('class' => 'form-horizontal'));?>
				<?php
				echo $this->BootstrapForm->input('adm_period_id', array(
					'required' => 'required',
					'name'=>'AdmArea[period]',
					'label'=>'* Periodo:',
					'id'=>'cbxPeriods'
				));
				echo $this->BootstrapForm->input('name', array(
					'required' => 'required',
					'label'=>'* Nombre:'
				));
				echo'<div id="boxParentAreas">';
				echo $this->BootstrapForm->input('parent_area_id', array(
					'name'=>'AdmArea[parent_area]',
					'id'=>'cbxParent',
					'label'=>'* Padre:',
					'default'=>0,
					'required' => 'required',
					'class'=>'span4'
				));				
				echo '</div>';
				?>
		<div class="form-actions" style="text-align: center">
				<?php echo $this->BootstrapForm->submit(__('Crear nueva area'), array('div'=>false, 'class'=>'btn btn-primary'));?>
				<?php echo ' '.$this->Html->link('Cancelar', array_merge(array('action'=>'index')), array('class'=>'btn') );?>
		</div>
		<?php	echo $this->BootstrapForm->end();?>
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->	
	
	

<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>

