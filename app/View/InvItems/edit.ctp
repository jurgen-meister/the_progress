	<div class="span9">
		<?php echo $this->BootstrapForm->create('InvItem', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Modificar %s', __('Item')); ?></legend>				
					<?php
					echo $this->BootstrapForm->input('code', array(								
						'label' => 'Código:',
						'required' => 'required',																		
						)
					);

					echo $this->BootstrapForm->input('inv_brand_id', array(
						'label' => 'Marca:',
						'required' => 'required',
						'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
					);
					echo $this->BootstrapForm->input('inv_category_id', array(
						'label' => 'Categoría:',
						'required' => 'required',
						'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
					);							
					echo $this->BootstrapForm->input('name', array(
						'label' => 'Nombre:',
						'rows' => 2,
						'required' => 'required',
						'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
					);
					echo $this->BootstrapForm->input('description', array(
						'rows' => 5,
						'style'=>'width:400px',
						'label' => 'Descripccion:',
						'required' => 'required',
						'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
					);
					echo $this->BootstrapForm->input('min_quantity', array(
						'label' => 'Cantidad Mínima:',
						'default'=>0,)				
					);							
					echo $this->BootstrapForm->input('picture', array(
						)
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