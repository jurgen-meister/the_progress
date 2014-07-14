<?php echo $this->Html->script('modules/AdmUsers', FALSE);?>
<?php echo $this->Html->script('jquery.validate', FALSE);?>			
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Cambio de contraseña</h5>
	</div>
	<div class="widget-content nopadding">
		<?php
		echo $this->BootstrapForm->create('AdmUser', array('class' => 'form-horizontal', 'id'=>'AdmUserFormPassword'));
				echo $this->BootstrapForm->input('password1', array(
					'required' => 'required',
					'label' => '* Ingrese nueva contraseña:',
					'id'=>'txtPassword1',
					'type'=>'password',
					'name'=>'txtPassword1',
				));
				echo $this->BootstrapForm->input('password2', array(
					'required' => 'required',
					'label' => '* Repita nueva contraseña:',
					'id'=>'txtPassword2',
					'type'=>'password',
					'name'=>'txtPassword2',
				));
	?>
		<div class="form-actions" style="text-align: center">
		<?php echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));
		echo ' '.$this->Html->link('Cancelar', array_merge(array('action'=>'welcome')), array('class'=>'btn') );
		?>
		</div>
		<?php		echo $this->BootstrapForm->end();
				?>
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->	
	
	

<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>