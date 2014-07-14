<?php $cakeDescription = __d('cake_dev', 'IMEXPORT SRL'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription; ?>-
		<?php echo $title_for_layout; ?>
	</title>
	<!--  meta info -->
	<?php
	  echo $this->Html->meta(array("name"=>"viewport",
		"content"=>"width=device-width,  initial-scale=1.0"));
	?>
	
	<!--  styles -->
  	<?php 
		//echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		//echo $this->Html->css('uniform');
		//echo $this->Html->css('select2'); //enhanced selects
		echo $this->Html->css('unicorn.main');
		echo $this->Html->css('unicorn.grey',
				null,
				array('class' => 'skin-color'));
		//echo $this->Html->css('datepicker');//just for this project I gonna put the calendar here
		//echo $this->Html->css('jquery.gritter');//growl-like notifications
		//media for print 
		echo $this->Html->css('print');//my print working 
	?>
</head>

<body>
	
	<div id="background-print">
		
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
				///////////////////////// END - Message not authorized, when there is no permission////////////
				?>	
				
				<!-- ////////////////////////// START - VIEWS CONTENT(CORE) //////////////////-->
				<div class="span1"></div>
					<div class="span10" id="content-print">
						<div style="text-align:right;">
							<a href="javascript:window.print()" id="btnPrint" class="btn btn-primary noPrint"><i class="icon-print icon-white"></i> Imprimir</a>
						</div>
							<?php echo $this->fetch('content'); ?>
					</div>
				<div class="span1"></div>
				<!-- ////////////////////////// END - VIEWS CONTENT(CORE) //////////////////-->
			</div>
			<!-- temporal -->
			<div class="row-fluid">
				<div id="footer" class="span12">
					<?php echo $this->element('sql_dump'); ?>
				</div>
			</div>
			<!-- temporal -->
		</div>
		<!-- CONTENT ENDS HERE -->
	</div>
	
	<div class="side-print"></div>
	
</body>
	