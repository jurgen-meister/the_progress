<?php echo $this->BootstrapForm->create('AdmTransition', array('class' => 'form-horizontal', 'id' => 'formSaveTransition')); ?>
<fieldset>                        
	<?php
		echo $this->BootstrapForm->hidden('id');
		echo $this->BootstrapForm->input('adm_state_id', array(
			'required' => 'required',
		));
		echo $this->BootstrapForm->input('adm_transaction_id', array(
			'required' => 'required',
		));
		echo $this->BootstrapForm->input('adm_final_state_id', array(
			'required' => 'required',
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