
<?php echo $this->Html->script('modules/AdmUsersAdmin', FALSE);?>
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
		<h5>Registro rol de usuario: <?php echo $username;?></h5>
	</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('AdmUserRestriction', array('class' => 'form-horizontal', 'id'=>'AdmUserRestrictionFormEdit'));?>
			<fieldset>
				<?php
				echo $this->BootstrapForm->input('userId', array(
					//'required' => 'required',
					'label'=>'idUser:',
					'type'=>'hidden',
					'id'=>'txtUserIdHidden',
					'name'=>'txtUserIdHidden',
					'value'=>$userId
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				echo $this->BootstrapForm->input('idUserRestriction', array(
					'id'=>'txtIdUserRestrictionHidden',
					'value'=>$idUserRestriction,
					'type'=>'hidden'
				));
				
				echo $this->BootstrapForm->input('periods', array(
					'required' => 'required',
					'label'=>'* Periodo:',
					'type'=>'select',
					'options'=>$periods,
					'value'=>$periodId,
					'id'=>'cbxPeriods',
					'name'=>'cbxPeriods',
					'disabled'=>'disabled'
					//'placeholder'=>'Fecha en que el usuario dejará de estar activo',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				
				echo '<div id="boxRolesAreas">';
				echo $this->BootstrapForm->input('roles', array(
					'required' => 'required',
					'label'=>'* Role:',
					'type'=>'select',
					'options'=>$roles,
					'value'=>$roleId,
					'id'=>'cbxRoles',
					'name'=>'cbxRoles',
					'disabled'=>'disabled'
					//'placeholder'=>'Fecha en que el usuario dejará de estar activo',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				echo $this->BootstrapForm->input('areas', array(
					'required' => 'required',
					'label'=>'* Area:',
					'type'=>'select',
					'options'=>$areas,
					'value'=>$areaId,
					'id'=>'cbxAreas',
					'name'=>'cbxAreas',
					'class'=>'span4'
					//'placeholder'=>'Fecha en que el usuario dejará de estar activo',
					//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
				));
				echo '</div>';
				//own UserRestriction edit validation
				if($idUserRestriction <> $this->Session->read('UserRestriction.id')){

					echo $this->BootstrapForm->input('active', array(
						'required' => 'required',
						'label'=>'* Activo:',
						'type'=>'select',
						'options'=>array('1'=>'SI','0'=>'NO'),
						'id'=>'cbxActive',
						'name'=>'cbxActive',
						'value'=>$active
					));

					echo $this->BootstrapForm->input('active_date', array(
						'required' => 'required',
						'label'=>'* Fecha actividad:',
						'type'=>'text',
						'id'=>'txtActiveDate',
						'name'=>'txtActiveDate',
						'value'=>$activeDate,
						'class'=>'input-date-type' 
					));
					if($userId <> $this->Session->read('User.id')){
						echo $this->BootstrapForm->input('selected', array(
							'required' => 'required',
							'label'=>'* Iniciar sesion cón este rol:',
							'type'=>'select',
							'options'=>array('1'=>'SI','0'=>'NO'),
							'id'=>'cbxSelected',
							'name'=>'cbxSelected',
							'value'=>$selected
						));
					}
					
				}	
				?>
		<div class="form-actions" style="text-align: center">
		<?php echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));
		echo ' '.$this->Html->link('Cancelar', array_merge(array('action'=>'index_user_restriction', $userId)), array('class'=>'btn') );
		?>
		</div>
		<?php		echo $this->BootstrapForm->end();
				?>
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->	
	
	

<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
