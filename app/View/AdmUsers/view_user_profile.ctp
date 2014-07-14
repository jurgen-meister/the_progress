<?php echo $this->Html->script('modules/AdmUsersAdmin', FALSE);?>
<?php //echo $this->Html->css('select2');?>
<?php //echo $this->Html->css('uniform');?>

<?php //echo $this->Html->script('jquery.uniform', FALSE);//Select and deselect all checkbox?>
<?php //echo $this->Html->script('select2.min', FALSE);?>
<?php echo $this->Html->script('jquery.validate', FALSE);?>



			
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
<h5>Para cualquier cambio a la información del usuario debe hablar con su administrador</h5>
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Datos Usuario</h5>
	</div>
	<div class="widget-content nopadding">
	<?php
					echo $this->BootstrapForm->create('AdmUser', array('class' => 'form-horizontal', 'id'=>'AdmUserFormEdit'));
					//$last_name = explode(' ', $data['AdmProfile']['last_name']);

							echo $this->bootstrapForm->input('id_hidden',array(
								'id'=>'txtIdHidden',
								'name'=>'txtIdHidden',
								'value'=>$data['AdmUser']['id'],
								'type'=>'hidden'
							));

							echo $this->bootstrapForm->input('di_number_hidden',array(
								'id'=>'txtDiNumberHidden',
								'disabled'=>'disabled',
								'name'=>'txtDiNumberHidden',
								'value'=>$data['AdmProfile']['di_number'],
								'type'=>'hidden'
							));

							echo $this->BootstrapForm->input('di_number', array(
								'label' => '* Documento identidad:',
								'disabled'=>'disabled',
								'id'=>'txtDiNumber',
								'name'=>'txtDiNumber',
								'value'=>$data['AdmProfile']['di_number']
							));
							echo $this->BootstrapForm->input('di_place', array(
								'label' => '* Expedido:',
								'disabled'=>'disabled',
								'id'=>'txtDiPlace',
								'data-provide'=>'typeahead',
								'data-items'=>4,
								'data-source'=>'["La Paz", "Cochabamba", "Santa Cruz", "Oruro", "Tarija", "Pando", "Beni", "Potosi", "Chuquisaca"]',
								'name'=>'txtDiPlace',
								'value'=>$data['AdmProfile']['di_place'],
								'placeholder'=>'Ej: La Paz, Cochabamba, etc'
							));
							echo $this->BootstrapForm->input('first_name', array(
								'label' => '* Nombres:',
								'disabled'=>'disabled',
								'id'=>'txtFirstName',
								'name'=>'txtFirstName',
								'value'=>$data['AdmProfile']['first_name']
							));
							echo $this->BootstrapForm->input('last_name1', array(
								'label' => '* Apellido paterno:',
								'disabled'=>'disabled',
								'id'=>'txtLastName1',
								'name'=>'txtLastName1',
								'value'=>$data['AdmProfile']['last_name1']
							));
							echo $this->BootstrapForm->input('last_name2', array(
								'label' => '* Apellido materno:',
								'disabled'=>'disabled',
								'id'=>'txtLastName2',
								'name'=>'txtLastName2',
								'value'=>$data['AdmProfile']['last_name2']
							));


							echo $this->BootstrapForm->input('email', array(
								'id'=>'txtEmail',
								'disabled'=>'disabled',
								'name'=>'txtEmail',
								'label' => '* Correo electrónico:',
								'type'=>'text',
								'value'=>$data['AdmProfile']['email']
							));

							echo $this->BootstrapForm->input('job', array(
								'label' => '* Cargo:',
								'disabled'=>'disabled',
								'id'=>'txtJob',
								'name'=>'txtJob',
								'placeholder'=>'Ej: Gerente, Vendedor, etc',
								'value'=>$data['AdmProfile']['job']
							));

							echo $this->BootstrapForm->input('birthdate', array(
								'id'=>'txtBirthdate',
								'disabled'=>'disabled',
								'name'=>'txtBirthdate',
								'label' => '* Fecha nacimiento:',
								'value'=>date("d/m/Y", strtotime($data['AdmProfile']['birthdate']))
							));

							echo $this->BootstrapForm->input('birthplace', array(
								'id'=>'txtBirthplace',
								'disabled'=>'disabled',
								'name'=>'txtBirthplace',
								'label' => '* Pais Origen:',
								'value'=>$data['AdmProfile']['birthplace']
							));

							echo $this->BootstrapForm->input('address', array(
								'id'=>'txtAddress',
								'disabled'=>'disabled',
								'name'=>'txtAddress',
								'label' => 'Dirección:',
								'value'=>$data['AdmProfile']['address']
							));

							echo $this->BootstrapForm->input('phone', array(
								'id'=>'txtPhone',
								'disabled'=>'disabled',
								'name'=>'txtPhone',
								'label' => 'Telefono:',
								'value'=>$data['AdmProfile']['phone']
							));
					?>
					<div class="form-actions" style="text-align: center">
					<?php //echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));
					echo ' '.$this->Html->link('Cancelar', array_merge(array('action'=>'welcome')), array('class'=>'btn') );
					?>
					</div>
					<?php	echo $this->BootstrapForm->end(); ?>
            	
            
		
		
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->	
	
	

<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>
