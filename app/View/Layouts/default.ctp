<?php $cakeDescription = __d('cake_dev', 'IMEXPORT SRL'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription; ?>
		<?php echo $title_for_layout; ?>
	</title>
	<!--  meta info -->
	<?php
	  echo $this->Html->meta(array("name"=>"viewport",
		"content"=>"width=device-width,  initial-scale=1.0"));
	/*  echo $this->Html->meta(array("name"=>"description",
		"content"=>"this is the description"));
	  echo $this->Html->meta(array("name"=>"author",
		"content"=>"TheHappyDeveloper.com - @happyDeveloper"))*/
	?>
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- styles -->
  	<?php 
		//echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('uniform');
		echo $this->Html->css('select2'); //enhanced selects
		echo $this->Html->css('unicorn.main');
		echo $this->Html->css('unicorn.grey',
				null,
				array('class' => 'skin-color'));
		echo $this->Html->css('datepicker');//just for this project I gonna put the calendar here
		echo $this->Html->css('jquery.gritter');//growl-like notifications
		//media for print 
		//echo $this->Html->css(array('bootstrap.min'), 'stylesheet', array('media' => 'all'));//supposedly default for print properties bootstrap but is not working
		echo $this->Html->css('print');//my print working 
	?>
</head>
<body>
	<?php ;?>
	<div id="header">
		<h1>IMEXPORT SRL</h1>
		<span id="currentDeviceType" style="visibility:hidden;"><?php echo $this->Session->read('currentDeviceTyoe'); ?></span>
	</div>

	<div id="user-nav" class="navbar navbar-inverse"> 
		<?php // if($logged_in): //Redundant because if there isn't a session set this view won't appear'?>
			<ul class="nav btn-group">
				<?php //declare variables
//					$userId = $this->session->read('User.id');
					$period = $this->Session->read('Period.name');
					$login = $this->session->read('User.username');
					$roleName = $this->Session->read('Role.name');
					$avaliableRoles=$this->Session->read('Avaliable.roles');
					$avaliableRolesPeriods=$this->Session->read('Avaliable.rolesPeriods');
				?>
				<li class="btn btn-inverse dropdown" id="user-menu">
					<a href="#" data-toggle="dropdown" data-target="#user-menu" class="dropdown-toggle">
						<i class="icon icon-user"></i> 
						<span class="text"><?php echo ' Usuario: '.$login; ?></span> 
						<b class="caret"></b>
					</a>
                    <ul class="dropdown-menu">
                        <li><?php echo $this->Html->link('Cambiar contraseña',array('controller'=>'admUsers', 'action'=>'change_password'));?></li>
                        <li><?php echo $this->Html->link('Cambiar correo electrónico',array('controller'=>'admUsers', 'action'=>'change_email'));?></li>
						<li><?php echo $this->Html->link('Datos del usuario',array('controller'=>'admUsers', 'action'=>'view_user_profile'));?></li>
                    </ul>
                </li>
				
				<li class="btn btn-inverse dropdown" id="role-menu">
					<a href="#" data-toggle="dropdown" data-target="#role-menu" class="dropdown-toggle">
						<i class="icon icon-briefcase"></i> 
						<span class="text"><?php echo ' Rol: '.$roleName;?></span> 
					<?php 
					if(count($avaliableRoles) > 0){?>
						<b class="caret"></b>
					<?php } ?>
					</a>
					<?php if(count($avaliableRoles) > 0){?>
                    <ul class="dropdown-menu">
						<?php foreach ($avaliableRoles as $avaliablesRolesId => $avaliablesRolesIdName) {
							echo '<li>'.$this->Html->link($avaliablesRolesIdName, array('controller'=>'AdmUsers','action'=>'change_user_restriction', 'role'=>$avaliablesRolesId)).'</li>';
						}?>
                    </ul>
					<?php  }?>
                </li>
				
				<li class="btn btn-inverse dropdown" id="period-menu">
					<a href="#" data-toggle="dropdown" data-target="#period-menu" class="dropdown-toggle">
						<i class="icon icon-time"></i> 
						<span class="text"><?php
						echo ' Gestión: <span id="globalPeriod">'.$period.'</span>';
						?>
						</span> 
						<?php 
						if(count($avaliableRolesPeriods) > 0){?>
							<b class="caret"></b>
						<?php } ?>
					</a>
					<?php if(count($avaliableRolesPeriods) > 0){?>
                    <ul class="dropdown-menu">
						<?php foreach ($avaliableRolesPeriods as $avaliableRolesPeriodsName) {
							echo '<li>'.$this->Html->link($avaliableRolesPeriodsName, array('controller'=>'AdmUsers','action'=>'change_user_restriction', 'period'=>$avaliableRolesPeriodsName)).'</li>';
						}?>
                    </ul>
					<?php  }?>
                </li>
				
				
				<li class="btn btn-inverse">
					<?php echo $this->Html->link(
						'<i class="icon icon-share-alt"></i><span class="text">&nbspSalir</span>', 
						array('controller'=>'admUsers', 'action'=>'logout'),
						array('escape' => FALSE));
					?>
				</li>
			</ul>
		
		<?php // endif;?>
	</div>
	
	<!-- MENU -->
	<div id="sidebar">
		<!--<a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>-->
		<?php
		if($this->Session->read('currentRoleActive')=='yes')echo $this->Session->read('Menu');
		?>
		
	</div>
	<div id="content">
		
		<!-- CONTENT STARTS HERE -->
		<div class="container-fluid">
			
			<div class="row-fluid">
				<?php 
				//////////////////////// START - Message not authorized, when there is no permission///////////
				//Is used authError from AppController 'authError'=>'Auth Error', but I don't use the message only the string not empty
				if($this->Session->flash('auth') <> ''){?>
					<div class="alert alert-error">
							<button class="close" data-dismiss="alert">×</button>
							<strong>ACCESO DENEGADO!</strong> No tiene permiso.
					</div>
				<?php }
				echo $this->Session->flash();  //to show setFlash messages
				echo $this->Session->flash('flash_check_active');
				///////////////////////// END - Message not authorized, when there is no permission////////////
				?>	
				
				<!-- ////////////////////////// START - VIEWS CONTENT(CORE) //////////////////-->
				<?php if($this->Session->read('currentRoleActive')=='yes')echo $this->fetch('content'); ?>			
				<!-- ////////////////////////// END - VIEWS CONTENT(CORE) //////////////////-->
				
				
			</div>
			<div class="row-fluid">
				<div id="footer" class="span12">
					<?php echo $this->element('sql_dump'); ?>
				</div>
			</div>
		</div>
		<!-- CONTENT ENDS HERE -->
	</div>
	<!-- page specific scripts -->
	
	<?php 
	
	echo $this->Html->script('jquery.min');
	echo $this->Html->script('jquery.ui.custom');
	echo $this->Html->script('bootstrap.min');
	echo $this->Html->script('unicorn');
	echo $this->Html->script('modules/BittionAlertModal');
	echo $this->Html->script('bootstrap-datepicker'); //just for this project I gonna put the calendar here
	echo $this->Html->script('jquery.gritter.min'); //growl-like notifications
	echo $this->Html->script('select2.min'); //enhanced selects
	echo $this->Html->script('BittionMain');
	?>
	<?php echo $this->fetch('script'); //here goes scripts created on the views?>
	
</body>
</html>