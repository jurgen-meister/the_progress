<?php echo $this->Html->script('modules/AdmRolesTransactions', FALSE); ?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Asignar Roles Transacciones</h5>
	</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('AdmRolesTransaction', array('class' => 'form-horizontal'));?>
			<fieldset>
				<?php
				echo $this->BootstrapForm->input('adm_role_id', array('label'=>'Rol de Usuario', 'id'=>'roles'));

				echo $this->BootstrapForm->input('adm_module_id', array('label'=>'Modulos', 'id'=>'modules'));

				echo '<div id="boxControllers">';
				echo $this->BootstrapForm->input('adm_controller_id', array('label'=>'Controladores', 'id'=>'controllers'));

				echo '<div id="boxTransactions">';
				echo $this->BootstrapForm->input('adm_transaction_id', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'transactions', 'label'=>'Transacciones:', 'selected' => $checkedTransactions ));
				echo '</div>';
				echo '</div>';
				?>
				<div class="form-actions" style="text-align: center">
					<button type="submit" class="btn btn-primary" id="saveButton">Guardar Cambios</button>
				</div>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
		<div id="message" style="text-align: center;"></div>
		<div id="processing" style="text-align: center;"></div>
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>