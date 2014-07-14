<?php echo $this->Html->script('jquery.validate', FALSE); ?>
<?php echo $this->Html->script('modules/AdmTransitions', FALSE); ?>
<div class="span12">
	<h3><a href="#" class="btn btn-primary" title="Nuevo" id="btnAdd"><i class="icon-plus icon-white"></i></a>
		<?php echo __('%s', __('Ciclos de Vida')); ?>
	</h3>
	<div class="row-fluid">
			<?php
			echo $this->BootstrapForm->create('Controller', array('class' => 'form-horiziontal'));
			echo'<fieldset>';
			echo $this->BootstrapForm->input('controller', array(
				'type' => 'select',
				'options' => array(1, 2, 3, 4, 5),
				'id' => 'cbxController',
				'label' => 'Controlador:',
				'class' => 'span4',
				'selected' => 0,
				'options' => $controllers
			));
			echo'</fieldset>';
			echo $this->BootstrapForm->end();
			?>
</div>
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box ">
				<div class="widget-title">
					<ul class="nav nav-tabs">
						<li id="headtabTransition" class="active"><a data-toggle="tab" href="#tab1">Transiciones</a></li>
						<li id="headtabState" ><a data-toggle="tab" href="#tab2">Estados</a></li>
						<li id="headtabTransaction" ><a data-toggle="tab" href="#tab3">Transacciones</a></li>
					</ul>
				</div>
				<div class="widget-content tab-content nopadding"><!-- nopadding -->
					<div id="tab1" class="tab-pane active">
						<!-----------------------------------------Start-Tab1-------------------------------------------------->
						<table class="table table-bordered table-hover" id="dataTableTransition">
							<thead>
							<th style="width: 4%">#</th>
							<th>Estado Inicial</th>
							<th>Transacción</th>
							<th>Estado Final</th>
							<th></th>
							</thead>
							<tbody>
							</tbody>
						</table>
						<!-------------------------------------------End-Tab1------------------------------------------------>
					</div>
					<div id="tab2" class="tab-pane">
						<!-----------------------------------------Start-Tab2-------------------------------------------------->
						<table class="table table-bordered table-hover" id="dataTableStates">
							<thead>
							<th style="width: 4%">#</th>
							<th>Nombre</th>
							<th>Descripción</th>
							<th></th>
							</thead>
							<tbody>
							</tbody>
						</table>
						<!-------------------------------------------End-Tab2------------------------------------------------>
					</div>
					<div id="tab3" class="tab-pane">
						<!-----------------------------------------Start-Tab2-------------------------------------------------->
						<table class="table table-bordered table-hover" id="dataTableTransactions">
							<thead>
							<th style="width: 4%">#</th>
							<th>Nombre</th>
							<th></th>
							</thead>
							<tbody>
							</tbody>
						</table>
						<!-------------------------------------------End-Tab2------------------------------------------------>
					</div>
				</div>
				<div id="boxLoading"></div>
			</div>
		</div>
	</div>
</div>
