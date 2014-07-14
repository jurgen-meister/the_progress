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
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Registro de Usuario</h5>
	</div>
	<div class="widget-content nopadding">
		<?php
		echo $this->BootstrapForm->create('AdmUser', array('class' => 'form-horizontal', 'id'=>'AdmUserFormAdd'));
				echo $this->BootstrapForm->input('di_number', array(
					'required' => 'required',
					'label' => '* Documento identidad:',
					'id'=>'txtDiNumber',
					'name'=>'txtDiNumber',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				echo $this->BootstrapForm->input('di_place', array(
					'required' => 'required',
					'label' => '* Expedido:',
					'id'=>'txtDiPlace',
					'autocomplete'=>'off',
					'data-provide'=>'typeahead',
					'data-items'=>4,
					'data-source'=>'["La Paz", "Cochabamba", "Santa Cruz", "Oruro", "Tarija", "Pando", "Beni", "Potosi", "Chuquisaca"]',
					'name'=>'txtDiPlace',
					'placeholder'=>'Ej: La Paz, Cochabamba, etc'
				//	'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				echo $this->BootstrapForm->input('first_name', array(
					'required' => 'required',
					'label' => '* Nombres:',
					'id'=>'txtFirstName',
					'name'=>'txtFirstName',
					//'class'=>'uneditable-input',
						//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				echo $this->BootstrapForm->input('last_name1', array(
					'required' => 'required',
					'label' => '* Apellido paterno:',
					'id'=>'txtLastName1',
					'name'=>'txtLastName1',
					'placeholder'=>'Tiene que escribir un apellido completo para que el sistema genere un usuario'
						//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				echo $this->BootstrapForm->input('last_name2', array(
					'required' => 'required',
					'label' => '* Apellido materno:',
					'id'=>'txtLastName2',
					'name'=>'txtLastName2',
					'placeholder'=>'Tiene que escribir un apellido completo para que el sistema genere un usuario'
						//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));

				echo $this->BootstrapForm->input('active', array(
					'required' => 'required',
					'label'=>'* Activo:',
					'type'=>'select',
					'options'=>array('1'=>'SI','0'=>'NO'),
					'id'=>'cbxActive',
					'name'=>'cbxActive',
					//'placeholder'=>'Fecha en que el usuario dejará de estar activo',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo $this->BootstrapForm->input('active_date', array(
					'required' => 'required',
					'label'=>'* Fecha actividad:',
					'type'=>'text',
					'id'=>'txtActiveDate',
					'name'=>'txtActiveDate',
					'placeholder'=>'Tiempo de duración del usuario hasta que expire',
					'class'=>'input-date-type' 
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo $this->BootstrapForm->input('email', array(
					'required' => 'required',
					'id'=>'txtEmail',
					'name'=>'txtEmail',
					'label' => '* Correo electrónico:',
					'type'=>'text',
						//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo $this->BootstrapForm->input('job', array(
					'required' => 'required',
					'label' => '* Cargo:',
					'id'=>'txtJob',
					'name'=>'txtJob',
					//'type'=>'select',
					'placeholder'=>'Ej: Gerente, Vendedor, etc',
						//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo $this->BootstrapForm->input('birthdate', array(
					'required' => 'required',
					'id'=>'txtBirthdate',
					'name'=>'txtBirthdate',
					'label' => '* Fecha nacimiento:',
					'class'=>'input-date-type-years' 
						//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo $this->BootstrapForm->input('birthplace', array(
					'required' => 'required',
					'id'=>'txtBirthplace',
					'name'=>'txtBirthplace',
					'label' => '* Pais Origen:',
					'value'=>'Bolivia'
					//'placeholder'=>'Ciudad, Pais',
				//	'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo $this->BootstrapForm->input('address', array(
					'id'=>'txtAddress',
					'name'=>'txtAddress',
					'label' => 'Dirección:',
					'placeholder'=>'Dirección, ciudad, (pais)'
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo $this->BootstrapForm->input('phone', array(
					'id'=>'txtPhone',
					'name'=>'txtPhone',
					'label' => 'Telefono:',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
	?>
		<div class="form-actions" style="text-align: center">
		<?php echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));
		echo ' '.$this->Html->link('Cancelar', array_merge(array('action'=>'index')), array('class'=>'btn') );
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