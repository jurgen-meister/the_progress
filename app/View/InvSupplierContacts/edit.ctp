<div class="span12">
	<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Editar Contacto</h5>			
	</div>
	<div class="widget-content nopadding">
	<?php echo $this->BootstrapForm->create('InvSupplierContact', array('class' => 'form-horizontal'));?>
		<fieldset>
			
			<?php
			echo $this->BootstrapForm->input('inv_supplier_id', array(
				'label' => 'Proveedor',
				'required' => 'required',
				'class'=>'span4'
			));
			echo $this->BootstrapForm->input('name', array(
				'style' => 'width:400px',
				'rows' => 3,
				'label' => 'Nombre',
				'required' => 'required',
			));
			echo $this->BootstrapForm->input('phone', array(
				'label' => 'Teléfono',)			
			);
			echo $this->BootstrapForm->input('job_title', array(
				'style' => 'width:400px',
				'label' => 'Cargo',	)
				
			);				
			echo $this->BootstrapForm->hidden('id');
			?>
			<div class="row-fluid">
				<div class="span2"></div>
				<div class="span6">
				<div class="btn-toolbar">
				<?php echo $this->BootstrapForm->submit('Guardar', array('id'=>'saveButton', 'class' => 'btn btn-primary', 'div' => false));
					   echo $this->Html->link('Cancelar', array('action' => 'index'), array('class'=>'btn') );
				?>
				</div>				
				</div>
				<div class="span4"></div>
			</div>	
		</fieldset>
	<?php echo $this->BootstrapForm->end();?>
	</div>
	</div>
</div>