<div class="span12">	
	<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Adicionar Detalle de Parametro</h5>			
	</div>
	<div class="widget-content nopadding">
	<?php echo $this->BootstrapForm->create('AdmParameterDetail', array('class' => 'form-horizontal'));?>
		<fieldset>			
			<?php
			echo $this->BootstrapForm->input('adm_parameter_id', array(
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('par_int1');
			echo $this->BootstrapForm->input('par_int2');
			echo $this->BootstrapForm->input('par_char1');
			echo $this->BootstrapForm->input('par_char2');
			echo $this->BootstrapForm->input('par_num1');
			echo $this->BootstrapForm->input('par_num2');
			echo $this->BootstrapForm->input('par_bool1');
			echo $this->BootstrapForm->input('par_bool2');				
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