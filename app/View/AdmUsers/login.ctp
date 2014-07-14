<div id="logo">
	<?php echo $this->Html->image('logoImexport.png', array('alt' => 'IMEXPORT')); ?>
</div>
<?php //echo $this->Session->flash(); ?>



<div id="loginbox">   

<?php echo $this->Form->create('AdmUser', array(
	'class' => 'form-vertical',
	'inputDefaults' => array(
		'label' => false,
		'div' => false,
	)
)); ?>
<p><?php echo __('Ingrese su usuario y contraseña para continuar.'); ?></p>
<?php echo $this->Form->input('login', array( 
											'placeholder' => 'Usuario', 
											'prepend' => '<i class="icon-user"></i>'
											));?>
<?php echo $this->Form->input('password',array( 
												'placeholder' => 'Contraseña',
												'prepend' => '<i class="icon-lock"></i>'
												));?>
	<div class="form-actions">
		<span class="pull-left">
			<?php 
			//////////////////////// START - Message not authorized, when there is no permission///////////
			//Is used authError from AppController 'authError'=>'Auth Error', but I don't use the message only the string not empty
			//if($this->Session->flash('auth') <> ''){ echo '<span style="font-weight:bold;">La sesión termino!</span>';}
			///////////////////////// END - Message not authorized, when there is no permission////////////
			?>	
		</span>
		<span class="pull-right">
			<?php echo $this->Form->submit('Iniciar Sesión',array (
															//'div' => false,
															'class' => 'btn btn-inverse'
															));?>
		</span>
	</div>
</div>
<br>
<?php  echo $this->Session->flash();  //to show setFlash messages ?>