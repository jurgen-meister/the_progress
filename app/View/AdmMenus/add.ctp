<?php echo $this->Html->script('modules/AdmMenus', FALSE); ?>
<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
<div class="widget-box">
	<div class="widget-title">
		<span class="icon">
			<i class="icon-edit"></i>								
		</span>
		<h5>Crear menu</h5>
	</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('AdmMenu', array('class' => 'form-horizontal'));?>
			<fieldset>
				<?php
				echo $this->BootstrapForm->input('adm_module_id', array(
					'label'=>'* Módulo'
					,'id'=>'modules'
					,'class'=>'span3'
				));
				echo $this->BootstrapForm->input('name', array(
					'label'=>'* Nombre menu',
					'required' => 'required'
					
				));
				echo $this->BootstrapForm->input('icon', array(
					'label'=>'* Icono',
					//'required' => 'required'
					
				));
				echo $this->BootstrapForm->input('order_menu', array(
					'label'=>'* Orden menu',
					'default'=>0,
					'required' => 'required'
					,'class'=>'span1'
				));
				echo '<div id="boxActions">';
				echo $this->BootstrapForm->input('adm_action_id', array(
					'default'=>0
					, 'label'=>'* Controlador->Acción'
					,'class'=>'span6'
					,'id'=>'cbxAction'
				));
				echo $this->BootstrapForm->input('adm_menu_id', array(
					 'label'=>'* Menu padre'
					,'default'=>0
					,'class'=>'span3'
					,'name'=>'AdmMenu[parent_node]'	
					,'options'=>$parentsMenus
				));
				echo '</div>';
				?>
				<div class="form-actions" style="text-align: center">
					<?php echo $this->BootstrapForm->submit(__('Crear menu'), array('div'=>false, 'class'=>'btn btn-primary'));?>
					<?php echo ' '.$this->Html->link('Volver', array('action'=>'index', $this->passedArgs[0]), array('class'=>'btn') );?>
				</div>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
		<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
</div> <!-- Belongs to: <div class="widget-box"> -->
<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
</div>