<?php // echo $this->set('aqui va el tityulo');   ?>
<!--<div style="text-align: center">-->
<div style=" font-size: 28px; font-weight: bold; ">
	SISTEMA IMEXPORT
</div>
<br>
<!--</div>-->
<!--<div class="row-fluid">
	<div class="span9">
		<h3>INICIO SISTEMA IMEXPORT</h3>
	</div>
</div>-->

<div class="alert alert-info">
	Usted inició sesión como <strong><?php echo $this->Session->read('Profile.fullname'); ?></strong>, todos los cambios en el sistema quedaran registrados con esta identidad.
	<a href="#" data-dismiss="alert" class="close">×</a>
</div>
<?php echo $this->Session->flash('flash_change_user_restriction');?>

<?php if(count($total) > 0){ ?>

<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-box widget-plain">
				<div class="widget-content center">
					<ul class="stats-plain">
						<li>										
							<h4><?php echo $total['sinvoiceApproved'];?></h4>
							<span>Ventas</span>
						</li>
						<li>										
							<h4><?php echo $total['pinvoiceApproved'];?></h4>
							<span>Compras</span>
						</li>
						<li>										
							<h4><?php echo $total['inApproved'];?></h4>
							<span>Entradas Almacen</span>
						</li>
						<li>										
							<h4><?php echo $total['outApproved'];?></h4>
							<span>Salidas Almacen</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<div class="widget-box">
			<div class="widget-title"><span class="icon"><i class="icon-tag"></i></span><h5>Ventas</h5></div>
			<div class="widget-content">
				<ul class="site-stats ">
					<li style="background: #f89406; color:#fff" ><strong><?php echo $total['sinvoicePendant'];?> </strong>Facturas Pendientes</li>
					<li style="background: #51a351; color:#fff" ><strong><?php echo $total['sinvoiceApproved'];?> </strong>Facturas Aprobadas</li>
					<li style="background: #bd362f; color:#fff" ><strong><?php echo $total['sinvoiceCancelled'];?> </strong>Facturas Canceladas</li>
					<hr>
					<li style="background: #f89406; color:#fff" ><strong><?php echo $total['snotePendant'];?> </strong>Notas Pendientes</li>
					<li style="background: #51a351; color:#fff" ><strong><?php echo $total['snoteApproved'];?> </strong>Notas Aprobadas</li>
					<li style="background: #bd362f; color:#fff" ><strong><?php echo $total['snoteCancelled'];?> </strong>Notas Canceladas</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="span4">
		<div class="widget-box">
			<div class="widget-title"><span class="icon"><i class="icon-shopping-cart"></i></span><h5>Compras</h5></div>
			<div class="widget-content">
				<ul class="site-stats ">
					<li style="background: #f89406; color:#fff" ><strong><?php echo $total['pinvoicePendant'];?> </strong>Facturas Pendientes</li>
					<li style="background: #51a351; color:#fff" ><strong><?php echo $total['pinvoiceApproved'];?> </strong>Facturas Aprobadas</li>
					<li style="background: #bd362f; color:#fff" ><strong><?php echo $total['pinvoiceCancelled'];?> </strong>Facturas Canceladas</li>
					<!--<li class="divider"></li>-->
					<hr>
					<li style="background: #f89406; color:#fff" ><strong><?php echo $total['porderPendant'];?> </strong>Ordenes Pendientes</li>
					<li style="background: #51a351; color:#fff" ><strong><?php echo $total['porderApproved'];?> </strong>Ordenes Aprobadas</li>
					<li style="background: #bd362f; color:#fff" ><strong><?php echo $total['porderCancelled'];?> </strong>Ordenes Canceladas</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="span4">
		<div class="widget-box">
			<div class="widget-title"><span class="icon"><i class="icon-retweet"></i></span><h5>Movimientos</h5></div>
			<div class="widget-content">
				<ul class="site-stats ">
					<li style="background: #f89406; color:#fff" ><strong><?php echo $total['inPendant'];?> </strong>Entradas Pendientes</li>
					<li style="background: #51a351; color:#fff" ><strong><?php echo $total['inApproved'];?> </strong>Entradas Aprobadas</li>
					<li style="background: #bd362f; color:#fff" ><strong><?php echo $total['inCancelled'];?> </strong>Entradas Canceladas</li>
					<hr>
					<li style="background: #f89406; color:#fff" ><strong><?php echo $total['outPendant'];?> </strong>Salidas Pendientes</li>
					<li style="background: #51a351; color:#fff" ><strong><?php echo $total['outApproved'];?> </strong>Salidas Aprobadas</li>
					<li style="background: #bd362f; color:#fff" ><strong><?php echo $total['outCancelled'];?> </strong>Salidas Canceladas</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php }?>