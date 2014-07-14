<?php echo $this->Html->script('modules/InvPrices', FALSE); ?>
<div class="span12">
	<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Editar Precio</h5>			
	</div>
	<div class="widget-content nopadding">
	<?php echo $this->BootstrapForm->create('InvPrice', array('class' => 'form-horizontal'));?>
		<fieldset>				
			<?php
			echo $this->BootstrapForm->input('inv_item_id', array(
				'label' => 'Item:',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('inv_price_type_id', array(
				'label' => 'Tipo de Precio:',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('date', array(
				'type' => 'text',
				'style' => 'width: 400px',
//				'timeFormat' => 24,
//				'dateFormat' => 'DMY',
				'id' => 'txtDate',
				'label' => 'Fecha:',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('price', array(
				'label' => 'Monto:',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('description', array(
				'label' => 'Descripcion:')
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