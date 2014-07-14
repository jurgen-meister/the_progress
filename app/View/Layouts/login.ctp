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
	/*  echo $this->Html->meta(array("name"=>"description",
		"content"=>"this is the description"));
	  echo $this->Html->meta(array("name"=>"author",
		"content"=>"TheHappyDeveloper.com - @happyDeveloper"))*/
	?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- styles -->
  	<?php 
		//echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('unicorn.login'); 
	?>
	<!-- icons -->
	<?php
	/*// I closed 'cause it represent a security problem
	 
		echo  $this->Html->meta('icon',$this->webroot.'img/favicon.ico');
		echo $this->Html->meta(array('rel' => 'apple-touch-icon',
		  'href'=>$this->webroot.'img/apple-touch-icon.png'));
		echo $this->Html->meta(array('rel' => 'apple-touch-icon',
		  'href'=>$this->webroot.'img/apple-touch-icon.png',  'sizes'=>'72x72'));
		echo $this->Html->meta(array('rel' => 'apple-touch-icon',
		  'href'=>$this->webroot.'img/apple-touch-icon.png',  'sizes'=>'114x114'));
	 * 
	 */
	?>
</head>
<body>
	<!-- contenido  -->
	<div class="row-fluid">
		<div class="span4 offset4">
			<?php 
			echo $this->fetch('content'); 
			?>
		</div>
	</div>
	<!-- page specific scripts -->
	<?php echo $this->Html->script('jquery.min'); ?>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->Html->script('unicorn.login'); ?>
	<?php //echo $this->fetch('script'); //maybe not necessary?>

    
</body>
</html>
