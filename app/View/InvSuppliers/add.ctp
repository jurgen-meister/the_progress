<div class="span12">
		<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Adicionar Proveedor</h5>			
	</div>
	<div class="widget-content nopadding">
	<?php echo $this->BootstrapForm->create('InvSupplier', array('class' => 'form-horizontal'));?>
		<fieldset>			
			<?php			
			echo $this->BootstrapForm->input('name', array(
				'style' => 'width:400px',
				'label' => 'Nombre:',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('location', array(
				'label' => 'Locacion:',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('adress', array(
				'style' => 'width:400px',
				'rows' => 5,
				'label' => 'Dirección:',

				)
			);
			echo $this->BootstrapForm->input('phone', array(
				'label' => 'Teléfono:',					
				)
			);				
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