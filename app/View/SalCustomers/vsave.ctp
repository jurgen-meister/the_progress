<?php echo $this->Html->script('modules/SalCustomers', FALSE); ?>
<div class="span12">

	<div class="widget-box">
		<div class="widget-content nopadding">
			<?php
//			echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn'));
			$url = array("action" => "index");
			$parameters = $this->passedArgs;
			
			echo $this->Html->link('<i class=" icon-arrow-left"></i> Volver', array_merge($url, $parameters), array('class' => 'btn', 'escape' => false)) . ' ';
			echo $this->BootstrapForm->submit('Guardar Cambios', array('id' => 'saveCustomer', 'class' => 'btn btn-primary', 'div' => false));
			echo '<span id="boxProcessing"></span>';
			echo '<br><div id="boxMessage"></div>';
			?>
		</div>
	</div>

	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>Cliente</h5>			
		</div>
		<?php echo $this->BootstrapForm->create('SalCustomer', array('class' => 'form-horizontal')); ?>
		<?php
		echo $this->BootstrapForm->input('idCustomer', array(
			'type' => 'hidden'
			,'id' => 'txtIdCustomer'
			,'value'=>$idCostumer
		));
		echo $this->BootstrapForm->input('name', array(
			'label' => "Razón Social:"
			,'id' => 'txtNameCustomer'
			,'value'=> $customer[0]['SalCustomer']['name']
		));
		echo $this->BootstrapForm->input('idEmployee', array(
			'type' => 'hidden'
			,'id' => 'txtIdEmployee'
			,'value'=>$employees[0]['SalEmployee']['id']
		));
		echo $this->BootstrapForm->input('employee_name', array(
			'label' => "Responsable:"
			,'id' => 'txtNameEmployee'
			,'value'=> $employees[0]['SalEmployee']['name']
		));
		echo $this->BootstrapForm->input('idTaxNumber', array(
			'type' => 'hidden'
			,'id' => 'txtidTaxNumber'
			,'value'=>$taxNumbers[0]['SalTaxNumber']['id']
		));
		echo $this->BootstrapForm->input('nit', array(
			'label' => "Nombre Factura:"
			,'id' => 'txtNameTaxNumber'
			,'value'=> $taxNumbers[0]['SalTaxNumber']['name']
		));
		echo $this->BootstrapForm->input('nit', array(
			'label' => "NIT/CI:"
			,'id' => 'txtNitTaxNumber'
			,'value'=> $taxNumbers[0]['SalTaxNumber']['nit']
		));
		echo $this->BootstrapForm->input('address', array(
			'label' => "Dirección:"
			, 'placeholder' => 'Dirección, ciudad, (pais)'
			,'id' => 'txtAddressCustomer'
			,'value'=> $customer[0]['SalCustomer']['address']
		));
		echo $this->BootstrapForm->input('phone', array(
			'label' => "Teléfono/Fax:"
			,'id' => 'txtPhoneCustomer'
			,'value'=> $customer[0]['SalCustomer']['phone']
		));
		echo $this->BootstrapForm->input('email', array(
			'label' => "Correo Electrónico:"
			,'id' => 'txtEmailCustomer'
			,'value'=> $customer[0]['SalCustomer']['email']
		));
		echo $this->BootstrapForm->input('description', array(
			'label' => "Observaciones:"
			,'id' => 'txtDescriptionCustomer'
			,'rows' => 2
			,'value'=> $customer[0]['SalCustomer']['description']
		));
//		echo $this->BootstrapForm->end();
		?>
		<?php echo $this->BootstrapForm->end(); ?>



	<!--	<div class="widget-box">
			<div class="widget-title">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#tab1">Persona Responsable</a></li>
					<li><a data-toggle="tab" href="#tab2">Nit/CI</a></li>
				</ul>
			</div>
			<div class="widget-content tab-content">
				<div id="tab1" class="tab-pane active">
					<?php
					echo $this->BootstrapForm->create('SalEmployee', array('class' => 'form-inline'));
					echo $this->BootstrapForm->input('idEmployee', array('placeholder' => "id", 'class' => 'span1', 'id' => 'txtIdEmployee', 'type' => 'hidden'));
					echo $this->BootstrapForm->input('nameEmployee', array('placeholder' => "Nombre", 'class' => 'span3', 'id' => 'txtNameEmployee'));
					echo $this->BootstrapForm->input('phoneEmployee', array('placeholder' => "Telefono", 'class' => 'span2', 'id' => 'txtPhoneEmployee'));
					echo $this->BootstrapForm->input('emailEmployee', array('placeholder' => "Correo electrónico", 'class' => 'span2', 'id' => 'txtEmailEmployee'));
					echo $this->BootstrapForm->submit('<i class="icon-plus icon-white"></i> ', array('id' => 'btnAddEmployee', 'class' => 'btn btn-primary', 'div' => false, 'title' => 'Nuevo Empleado'));
					echo $this->BootstrapForm->submit('Guardar', array('id' => 'btnEditEmployee', 'class' => 'btn btn-primary', 'div' => false, 'style' => 'display:none;'));
					echo $this->BootstrapForm->submit('Cancelar', array('id' => 'btnCancelEmployee', 'class' => 'btn btn-cancel', 'div' => false, 'style' => 'display:none;'));
					echo $this->BootstrapForm->end();
					echo '<span id="boxProcessingEmployee"></span>';
					echo '<div id="boxMessageEmployee"></div>';
					?>
					<table class="table table-striped table-bordered table-hover" id="tblEmployees">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Telefono</th>
								<th>Correo Electrónico</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($employees as $keyEmployee => $employee){?>
							<tr id="rowEmployee<?php echo $employee['SalEmployee']['id'];?>">
								<td  style="text-align: center;"><span class="spaNumber"><?php echo ($keyEmployee + 1);?></span> <input type="hidden" value="<?php echo $employee['SalEmployee']['id'];?>" class="spaIdEmployee"></td>
								<td><span class="spaNameEmployee"><?php echo $employee['SalEmployee']['name'];?></span></td>
								<td><span class="spaPhoneEmployee"><?php echo $employee['SalEmployee']['phone'];?></span></td>
								<td><span class="spaEmailEmployee"><?php echo $employee['SalEmployee']['email'];?></span></td>
								<td>
									<?php
									echo $this->Html->link('<i class="icon-pencil icon-white"></i>', array('action' => 'vsave'), array('class' => 'btn btn-primary btnRowEditEmployee', 'escape' => false, 'title' => 'Editar'));
									echo ' ' . $this->Html->link('<i class="icon-trash icon-white"></i>', array('action' => 'vsave'), array('class' => 'btn btn-danger btnRowDeleteEmployee', 'escape' => false, 'title' => 'Eliminar'));
									?>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>		
					
				</div>


				<div id="tab2" class="tab-pane">
					<?php
					echo $this->BootstrapForm->create('SalTaxNumber', array('class' => 'form-inline'));
					echo $this->BootstrapForm->input('idTaxNumber', array('placeholder' => "id", 'class' => 'span1', 'id' => 'txtIdTaxNumber', 'type' => 'hidden'));
					echo $this->BootstrapForm->input('nitTaxNumber', array('placeholder' => "Nit/CI", 'class' => 'span2', 'id' => 'txtNitTaxNumber'));
					echo $this->BootstrapForm->input('nameTaxNumber', array('placeholder' => "Nombre", 'class' => 'span2', 'id' => 'txtNameTaxNumber'));
					echo $this->BootstrapForm->submit('<i class="icon-plus icon-white"></i> ', array('id' => 'btnAddTaxNumber', 'class' => 'btn btn-primary', 'div' => false, 'title' => 'Nuevo Empleado'));
					echo $this->BootstrapForm->submit('Guardar', array('id' => 'btnEditTaxNumber', 'class' => 'btn btn-primary', 'div' => false, 'style' => 'display:none;'));
					echo $this->BootstrapForm->submit('Cancelar', array('id' => 'btnCancelTaxNumber', 'class' => 'btn btn-cancel', 'div' => false, 'style' => 'display:none;'));
					echo $this->BootstrapForm->end();
					echo '<span id="boxProcessingTaxNumber"></span>';
					echo '<div id="boxMessageTaxNumber"></div>';
					?>
					<table class="table table-striped table-bordered table-hover" id="tblTaxNumbers">
						<thead>
							<tr>
								<th>#</th>
								<th>Nit/CI</th>
								<th>Nombre</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($taxNumbers as $keyTaxNumber => $taxNumber){?>
							<tr id="rowTaxNumber<?php echo $taxNumber['SalTaxNumber']['id'];?>">
								<td  style="text-align: center;"><span class="spaNumber"><?php echo ($keyTaxNumber + 1);?></span> <input type="hidden" value="<?php echo $taxNumber['SalTaxNumber']['id'];?>" class="spaIdTaxNumber"></td>
								<td><span class="spaNitTaxNumber"><?php echo $taxNumber['SalTaxNumber']['nit'];?></span></td>
								<td><span class="spaNameTaxNumber"><?php echo $taxNumber['SalTaxNumber']['name'];?></span></td>
								<td>
									<?php
									echo $this->Html->link('<i class="icon-pencil icon-white"></i>', array('action' => 'vsave'), array('class' => 'btn btn-primary btnRowEditTaxNumber', 'escape' => false, 'title' => 'Editar'));
									echo ' ' . $this->Html->link('<i class="icon-trash icon-white"></i>', array('action' => 'vsave'), array('class' => 'btn btn-danger btnRowDeleteTaxNumber', 'escape' => false, 'title' => 'Eliminar'));
									?>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>	
				</div>
			</div>
		</div> -->


	</div>
</div>
<?php echo $this->BootstrapForm->end(); ?>


