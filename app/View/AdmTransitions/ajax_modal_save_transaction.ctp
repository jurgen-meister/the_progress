<?php echo $this->BootstrapForm->create('AdmTransaction', array('class' => 'form-horizontal', 'id' => 'formSaveTransaction')); ?>
<fieldset>                        
	<?php
		echo $this->BootstrapForm->hidden('id');
		echo $this->BootstrapForm->input('adm_controller_id', array(
			'type'=>'hidden',
			'value'=>$controllerId,
			'required' => 'required',
		));
		echo $this->BootstrapForm->input('name', array(
			'label' => 'Tipo:',
			'type' => 'select',
			'options' => array_combine(array('CREATE', 'MODIFY', 'ELIMINATE'), array('CREATE', 'MODIFY', 'ELIMINATE')),
			'required' => 'required'
		));
//		echo $this->BootstrapForm->input('description', array(
//			'label' => 'Descripción:',
//		));
//		echo $this->BootstrapForm->input('sentence', array(
//			'type' => 'select',
//			'options' => array_combine(array('ADD', 'EDIT', 'DELETE'), array('ADD', 'EDIT', 'DELETE')),
//			'label' => 'Sentencia:',
//		));
	?>
	<div class="form-actions" style="text-align: center">
		<?php
		echo $this->BootstrapForm->submit('Guardar', array('class' => 'btn btn-primary', 'div' => false));
		?>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	</div>                        
</fieldset>
<?php echo $this->BootstrapForm->end(); ?>