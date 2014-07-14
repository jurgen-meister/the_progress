<?php echo $this->BootstrapForm->create('AdmState', array('class' => 'form-horizontal', 'id' => 'formSaveState')); ?>
<fieldset>                        
	<?php
		echo $this->BootstrapForm->hidden('id');
		echo $this->BootstrapForm->input('adm_controller_id', array(
			'type'=>'hidden',
			'value'=>$controllerId,
			'required' => 'required'
		));
		echo $this->BootstrapForm->input('name', array(
			'label' => 'Nombre:',
			'required' => 'required',
			'maxlenght' => '30'
		));
		echo $this->BootstrapForm->input('description', array(
			'label' => 'Descripción:',
			'placeholder'=>'(opcional)'
//			'required' => 'required',
		));
	?>
	<div class="form-actions" style="text-align: center">
		<?php
		echo $this->BootstrapForm->submit('Guardar', array('class' => 'btn btn-primary', 'div' => false));
		?>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	</div>                        
</fieldset>
<?php echo $this->BootstrapForm->end(); ?>