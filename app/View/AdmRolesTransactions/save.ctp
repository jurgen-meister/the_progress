<?php // echo $this->Html->script('checkboxtree/jquery.checkboxtree', FALSE); ?>
<?php //echo $this->Html->css('jquery.checkboxtree'); ?>
<?php echo $this->Html->script('jquery.uniform.js', FALSE); ?>
<?php echo $this->Html->script('modules/AdmRolesTransactions', FALSE); ?>

<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
	<!-- ************************************************************************************************************************ -->
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
		<div class="widget-box">
			<div class="widget-content nopadding">
				<button type="submit" class="btn btn-primary" id="saveButton">Guardar Cambios</button>
			</div>
		</div>
	
	<div class="widget-box">
        <div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>                                                                
			</span>
			<h5>Roles Transacciones</h5>
        </div>
        <div class="widget-content nopadding">
			<?php echo $this->BootstrapForm->create('AdmRolesTransaction', array('class' => 'form-horizontal')); ?>
			<fieldset>
				<?php
				echo $this->BootstrapForm->input('adm_role_id', array('label'=>'Rol de Usuario', 'id'=>'cbxRoles', 'class'=>'span4'));

				echo $this->BootstrapForm->input('adm_module_id', array('label'=>'Modulos', 'id'=>'cbxModules', 'class'=>'span4'));
				?>                
                <div id="message" style="text-align: center;"></div>
                <div id="processing" style="text-align: center;"></div>
				<div id="boxChkTree"></div>
			</fieldset>
			<?php echo $this->BootstrapForm->end(); ?>
			<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
        </div> <!-- Belongs to: <div class="widget-content nopadding"> -->
	</div> <!-- Belongs to: <div class="widget-box"> -->
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>