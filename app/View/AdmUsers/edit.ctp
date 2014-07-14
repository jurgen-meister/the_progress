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
		<h5>Editar Usuario</h5>
	</div>
	<div class="widget-content nopadding">
		
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#userData" data-toggle="tab">Datos usuario</a></li>
              <li><a href="#passwordReset" data-toggle="tab">Resetear Password</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="userData">
				  
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
								'name'=>'txtDiNumberHidden',
								'value'=>$data['AdmProfile']['di_number'],
								'type'=>'hidden'
							));

							echo $this->BootstrapForm->input('di_number', array(
								'label' => '* Documento identidad:',
								'id'=>'txtDiNumber',
								'name'=>'txtDiNumber',
								'value'=>$data['AdmProfile']['di_number']
								//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));
							echo $this->BootstrapForm->input('di_place', array(
								'label' => '* Expedido:',
								'id'=>'txtDiPlace',
								'data-provide'=>'typeahead',
								'data-items'=>4,
								'data-source'=>'["La Paz", "Cochabamba", "Santa Cruz", "Oruro", "Tarija", "Pando", "Beni", "Potosi", "Chuquisaca"]',
								'name'=>'txtDiPlace',
								'value'=>$data['AdmProfile']['di_place'],
								'placeholder'=>'Ej: La Paz, Cochabamba, etc'
							//	'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));
							echo $this->BootstrapForm->input('first_name', array(
								'label' => '* Nombres:',
								'id'=>'txtFirstName',
								'name'=>'txtFirstName',
								'value'=>$data['AdmProfile']['first_name']
								//'class'=>'uneditable-input',
									//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));
							echo $this->BootstrapForm->input('last_name1', array(
								'label' => '* Apellido paterno:',
								'id'=>'txtLastName1',
								'name'=>'txtLastName1',
								'value'=>$data['AdmProfile']['last_name1']
									//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));
							echo $this->BootstrapForm->input('last_name2', array(
								'label' => '* Apellido materno:',
								'id'=>'txtLastName2',
								'name'=>'txtLastName2',
								'value'=>$data['AdmProfile']['last_name2']
									//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('active', array(
								'label'=>'* Activo:',
								'type'=>'select',
								'options'=>array('1'=>'SI','0'=>'NO'),
								'id'=>'cbxActive',
								'name'=>'cbxActive',
								'value'=>$data['AdmUser']['active']
								//'placeholder'=>'Fecha en que el usuario dejará de estar activo',
								//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('active_date', array(
								'label'=>'* Fecha actividad:',
								'type'=>'text',
								'id'=>'txtActiveDate',
								'name'=>'txtActiveDate',
								'value'=>date("d/m/Y", strtotime($data['AdmUser']['active_date'])),
								'class'=>'input-date-type' 
								//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('email', array(
								//'required' => 'required',
								'id'=>'txtEmail',
								'name'=>'txtEmail',
								'label' => '* Correo electrónico:',
								'type'=>'text',
								'value'=>$data['AdmProfile']['email']
									//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('job', array(
								//'required' => 'required',
								'label' => '* Cargo:',
								'id'=>'txtJob',
								'name'=>'txtJob',
								//'type'=>'select',
								'placeholder'=>'Ej: Gerente, Vendedor, etc',
								'value'=>$data['AdmProfile']['job']
									//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('birthdate', array(
								'id'=>'txtBirthdate',
								'name'=>'txtBirthdate',
								'label' => '* Fecha nacimiento:',
								'value'=>date("d/m/Y", strtotime($data['AdmProfile']['birthdate'])),
								'class'=>'input-date-type-years'
									//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('birthplace', array(
								'id'=>'txtBirthplace',
								'name'=>'txtBirthplace',
								'label' => '* Pais Origen:',
								'value'=>$data['AdmProfile']['birthplace']
								//'value'=>'Bolivia'
								//'placeholder'=>'Ciudad, Pais',
							//	'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('address', array(
								'id'=>'txtAddress',
								'name'=>'txtAddress',
								'label' => 'Dirección:',
								'value'=>$data['AdmProfile']['address'],
								'placeholder'=>'Dirección, ciudad, (pais)'
								//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));

							echo $this->BootstrapForm->input('phone', array(
								'id'=>'txtPhone',
								'name'=>'txtPhone',
								'label' => 'Telefono:',
								'value'=>$data['AdmProfile']['phone']
								//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
							));
					?>
					<div class="form-actions" style="text-align: center">
					<?php echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));
					echo ' '.$this->Html->link('Cancelar', array_merge(array('action'=>'index')), array('class'=>'btn') );
					?>
					</div>
					<?php	echo $this->BootstrapForm->end(); ?>
				  
              </div>
				
              <div class="tab-pane fade" id="passwordReset" style="text-align: center">
				  <p>En caso de olvido u otro motivo, se puede cambiar la contraseña de este usuario y se imprimirá el nuevo password.</p>
                <?php 
				echo $this->BootstrapForm->create('AdmUserResetPassword', array('class' => 'form-horizontal', 'id'=>'AdmUserResetPassword'));
				echo '<div class="form-actions" style="text-align: center">';
				echo '<a href="#myAlert" data-toggle="modal" class="btn btn-primary">Resetear Contraseña</a>';
				echo '</div>';
				echo $this->BootstrapForm->end();
				?>
              </div>
            </div>
		
		
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->	
	
	

<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->

<!-- ****************************************************** Modal Alert**************************************************************** -->
<div id="myAlert" class="modal hide">
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3>Resetear Contraseña</h3>
	</div>
	<div class="modal-body">
		<p>El sistema generará una nueva contraseña para este usuario, ¿está seguro?</p>
	</div>
	<div class="modal-footer">
		<a data-dismiss="modal" class="btn btn-primary" id="btnResetPassword" href="#">SI</a>
		<a data-dismiss="modal" class="btn" href="#">NO</a>
	</div>
</div>