<?php echo $this->Html->script('modules/SalSales', FALSE); ?>

<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
	<?php
		switch ($documentState){
			case '':
				$documentStateColor = '';
				$documentStateName = 'SIN ESTADO';
				break;
			case 'NOTE_PENDANT':
				if (/*$reserved !== '' && */$reserved === false){
					$documentStateColor = 'label-warning';
					$documentStateName = 'NOTA PENDIENTE';
				}else{
					$documentStateColor = 'label-info';
					$documentStateName = 'NOTA RESERVADA';
				}
				
				
				break;
			case 'NOTE_APPROVED':
				$documentStateColor = 'label-success';
				$documentStateName = 'NOTA APROBADA';
				break;
			case 'NOTE_CANCELLED':
				$documentStateColor = 'label-important';
				$documentStateName = 'NOTA CANCELADA';
				break;
		}
	?>
	<!-- //////////////////////////// Start - buttons /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-content nopadding">
			<?php 
				/////////////////START - SETTINGS BUTTON CANCEL /////////////////
				$url=array('action'=>'index_order');
				$parameters = $this->passedArgs;
				if(!isset($parameters['search'])){
//					unset($parameters['document_code']);
					unset($parameters['code']);
				}
				unset($parameters['id']);
				echo $this->Html->link('<i class=" icon-arrow-left"></i> Volver', array_merge($url,$parameters), array('class'=>'btn', 'escape'=>false)).' ';
				//////////////////END - SETTINGS BUTTON CANCEL /////////////////
			?>

			<?php 
				switch ($documentState){
							case '':
								$displayApproved = 'none';
								$displayPays = 'none';			
								$displayCancelled = 'none';
								break;
							case 'NOTE_PENDANT':
								if (/*$reserved !== '' && */$reserved === false){
									$displayApproved = 'inline';
									$displayPays = 'inline';			
								}else{
									$displayApproved = 'none';
									$displayPays = 'inline';			
								}
								$displayCancelled = 'none';
								break;
							case 'NOTE_APPROVED':
								$displayApproved = 'none';
								$displayPays = 'none';			
								$displayCancelled = 'inline';
								break;
							case 'NOTE_CANCELLED':
								$displayApproved = 'none';
								$displayPays = 'none';			
								$displayCancelled = 'none';
								break;
						}
						
				if ($invoiced == 'true'){
					$displayInvoice = 'inline';
				}else{
					$displayInvoice = 'none';
				}
				if ($reserved === ''){
					$displayReserved = 'none';
					$displayEdit = 'none';
				}elseif (/*$reserved !== '' && */$reserved === false) {
					$displayReserved = 'inline';
					$displayEdit = 'none';
				}elseif (/*$reserved !== '' && */$reserved === true) {
					$displayReserved = 'none';
					$displayEdit = 'inline';
				}
//				if ($invoiceState !== array() && current($invoiceState) === 'DRAFT') {
//					$displayReserved = 'inline';
//				}else{
//					$displayReserved = 'none';
//				}	class="icon-pencil icon-white"
			?>
			<?php
			if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR $reserved === false)){
				echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));	
			}
			?>
			<a href="#" id="btnReserveNote" class="btn btn-info" style="display:<?php echo $displayReserved;?>"> Reservar Nota de Remisión</a>
			<a href="#" id="btnEditReservedNote" class="btn btn-warning" style="display:<?php echo $displayEdit;?>"><i class="icon-pencil icon-white"></i> Editar Nota de Remisión</a>
		<!--	<a href="#" id="btnApproveState" class="btn btn-success" style="display:<?php echo $displayApproved;?>"> Aprobar Orden de Compra</a> -->
		<!--	<a href="#" id="btnApproveStateFull" class="btn btn-inverse" style="display:<?php echo $displayApproved;?>"> Solo Genera FAC MOV </a>-->
			<a href="#" id="btnLogicDeleteState" class="btn btn-danger" style="display:<?php echo $displayApproved;?>"><i class=" icon-trash icon-white"></i> Eliminar</a>
			<a href="#" id="btnCancellState" class="btn btn-danger" style="display:<?php echo $displayCancelled;?>"> Cancelar Orden de Compra</a>
		<!--	<a href="#" id="btnCancellAll" class="btn btn-danger" style="display:<?php echo $displayCancelled;?>"> Cancelar Orden y Movs</a>-->
			<?php
				$displayPrint = 'none';
				if($id <> ''){
					$displayPrint = 'inline';
				}
				echo $this->Html->link('<i class="icon-print icon-white"></i> Imprimir', array('action' => 'view_document_movement_pdf', $id.'.pdf'), array('class'=>'btn btn-primary','style'=>'display:'.$displayPrint, 'escape'=>false, 'title'=>'Nuevo', 'id'=>'btnPrint', 'target'=>'_blank')); 

			?>
			
			
			
			
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->
	
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>NOTA DE REMISION</h5>
			<span id="documentState" class="label <?php echo $documentStateColor;?>"><?php echo $documentStateName;?></span>
		</div>
		<div class="widget-content nopadding">
		
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
	
	<!-- ////////////////////////////////// START - FORM STARTS ///////////////////////////////////// -->
		<?php echo $this->BootstrapForm->create('SalSale', array('class' => 'form-horizontal'));?>
		<fieldset>
	<!-- ////////////////////////////////// END - FORM ENDS /////////////////////////////////////// -->				
				
						
				<!-- ////////////////////////////////// START FORM ORDER FIELDS /////////////////////////////////////// -->
				<?php
				//////////////////////////////////START - block when APPROVED or CANCELLED///////////////////////////////////////////////////
				$disable = 'disabled';

				if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR $reserved === false)){
					$disable = 'enabled';
				}
				
				//////////////////////////////////END - block when APPROVED or CANCELLED///////////////////////////////////////////////////
				
				echo $this->BootstrapForm->input('purchase_hidden', array(
					'id'=>'txtPurchaseIdHidden',
					'value'=>$id,
//					'type'=>'hidden'
				));
							
				echo $this->BootstrapForm->input('doc_code', array(
					'id'=>'txtCode',
//					'label'=>'Código:',
//					'style'=>'background-color:#EEEEEE',
//					'disabled'=>$disable,
//					'placeholder'=>'El sistema generará el código',
//					'type'=>'hidden'
				));
				
				echo $this->BootstrapForm->input('generic_code', array(
					'id'=>'txtGenericCode',
					'value'=>$genericCode,
//					'type'=>'hidden'
				));
				
				echo $this->BootstrapForm->input('note_code', array(
					'id'=>'txtNoteCode',
					'label' => 'No. Nota de Remisión:',
					'disabled'=>$disable
				));
				
				echo $this->BootstrapForm->input('date_in', array(
					'required' => 'required',
					'label' => 'Fecha:',
					'id'=>'txtDate',
					'value'=>$date,
					'disabled'=>$disable,
					'maxlength'=>'0'
				));
				
				echo $this->BootstrapForm->input('sal_customer_id', array(
					'required' => 'required',
					'label' => 'Cliente:',
					'id'=>'cbxCustomers',
					'selected' => $customerId,
					'class'=>'input-xlarge',
					'disabled'=>$disable
				));
		
				echo '<div id="boxControllers">';
					echo $this->BootstrapForm->input('sal_employee_id', array(
						'required' => 'required',
						'label' => 'Responsable:',
						'class'=>'input-xlarge',
						'id'=>'cbxEmployees',
						'disabled'=>$disable
					));


					echo $this->BootstrapForm->input('sal_tax_number_id', array(
						'required' => 'required',
						'label' => 'NIT/CI - Nombre:',
						'id'=>'cbxTaxNumbers',
						'class'=>'input-xlarge',
						'disabled'=>$disable
					));
				echo '</div>';
			
				echo $this->BootstrapForm->input('sal_adm_user_id', array(
					'required' => 'required',
					'label' => 'Vendedor:',
					'id'=>'cbxSalesman',
					'selected' => $admUserId,
					'class'=>'input-xlarge',
					'disabled'=>$disable
				));
				
				echo $this->BootstrapForm->input('discount', array(
					'label' => 'Descuento:',
					'disabled'=>$disable,
					'id'=>'txtDiscount',
					'value'=>$discount,
					'type'=>'text'
					,'append' => '%'
				));
				
//			echo '<div class="checker" >';//<span><input type="checkbox" name="radios" style="opacity: 0;"></span>
//				echo '<span class>';
					echo $this->BootstrapForm->input('invoice', array(
						'label' => 'Facturado:',						
						'id'=>'chkInv',
						'type'=>'checkbox'
						,'disabled'=>$disable
//						,'style'=>'opacity: 0'
	//					'class'=>'checker'
					));
//				echo '</span>';	
//			echo '</div>';
				
				echo '<div id="boxExRate">';
					echo $this->BootstrapForm->input('ex_rate', array(
						'label' => 'Tipo de Cambio:',
						'value'=>$exRate,
						'disabled'=>'disabled',
						'id'=>'txtExRate',
					//	'step'=>0.01,
					//	'min'=>0
						'type'=>'text'
						,'append' => 'Bs.'
					));
				echo '</div>';
				
				echo $this->BootstrapForm->input('description', array(
					'rows' => 2,
					'label' => 'Observaciones:',
					'disabled'=>$disable,
					'id'=>'txtDescription'
				));
				?>
				<!-- ////////////////////////////////// END FORM ORDER FIELDS /////////////////////////////////////// -->
				
					<!-- ////////////////////////////////// START MESSAGES /////////////////////////////////////// -->
					<div id="boxMessage"></div>
					<div id="processing"></div>
					<!-- ////////////////////////////////// END MESSAGES /////////////////////////////////////// -->
					
	<!-- ////////////////////////////////// START - END FORM ///////////////////////////////////// -->		
	</fieldset>
	<?php echo $this->BootstrapForm->end();?>
	<!-- ////////////////////////////////// END - END FORM ///////////////////////////////////// -->
				
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
		</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
	</div> <!-- Belongs to: <div class="widget-box"> -->
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	
	<!-- ////////////////////////////////// START - MOVEMENT ITEMS DETAILS /////////////////////////////////////// -->
						
	<div class="widget-box">
		<div class="widget-title">
			<ul class="nav nav-tabs">
				<li id="tab1li" class="active"><a data-toggle="tab" href="#tab1">Productos</a></li>
				<li id="tab2li"><a data-toggle="tab" href="#tab2">Pagos</a></li>
				<li id="tab3li" style="display:<?php  echo $displayInvoice;?>" ><a data-toggle="tab"  href="#tab3">Factura</a></li>
			</ul>
		</div>
		<div class="widget-content tab-content">
			<div id="tab1" class="tab-pane active">
				<!-- ////////////////////////////////// START - NOTE ITEMS DETAILS /////////////////////////////////////// -->
				<?php if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR ($reserved === '' OR $reserved === false))/*AND current($invoiceState) == 'DRAFT'*/){ ?>
					<a class="btn btn-primary" href='#' id="btnAddItemSO" title="Adicionar Item"><i class="icon-plus icon-white"></i></a>
				<?php } ?>
						<?php $limit = count($salDetails); $counter = $limit;?>
						<table class="table table-bordered table-hover data-table" id="tablaItems">
							<thead>
								<tr>
									<th rowspan="2">Producto(s) ( <span id="countItems"><?php echo $limit;?> </span> )</th>
									<th rowspan="2">Precio Unitario</th>
									<th colspan="3">Cantidad</th>
									<th rowspan="2">Subtotal</th>
									<th rowspan="2">Almacén</th>
									<th rowspan="2">Virtual Stock</th>
									<th rowspan="2">Real Stock</th>
									<?php if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR $reserved === false)/* AND current($invoiceState) == 'DRAFT'*/){ ?>
									<th rowspan="2" class="columnItemsButtons">Acción</th>
									<?php }?>
								</tr>
								<tr>
									<th>Disponible</th>
									<th>Backorder</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$total = '0.00';
								for($i=0; $i<$limit; $i++){
									$virtualStock = ($salDetails[$i]['stock']) - ($salDetails[$i]['reservedStock']);
//									if($stockReserved <= 0){
//										$stockReservedTemp = 0;
//										$avaQuantityTemp = $stockReservedTemp - ($salDetails[$i]['cantidad']);
//										$avaQuantity = $stockReservedTemp;
//										$boQuantity = abs($avaQuantityTemp);
//									}else{
//										$avaQuantityTemp = $stockReserved - ($salDetails[$i]['cantidad']);
//										if($avaQuantity < 0){
//											$avaQuantity = $stockReserved;
//											$boQuantity = abs($avaQuantityTemp);
//										}
//									}
									$avaQuantity = ($salDetails[$i]['cantidad']) - ($salDetails[$i]['backorder']);
//									$boQuantity = ($salDetails[$i]['cantidad']) - ($salDetails[$i]['backorder']);
									$subtotal = ($salDetails[$i]['cantidad']) * ($salDetails[$i]['salePrice']);
									
									echo '<tr id="itemRow'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">';	//REVISAR SI NECESITA O NO WAREHOUSEId																						//type="hidden" txtWarehouseId
										echo '<td><span id="spaItemName'.$salDetails[$i]['itemId'].'">'.$salDetails[$i]['item'].'</span><input  value="'.$salDetails[$i]['itemId'].'" id="txtItemId" ></td>';
										echo '<td><span id="spaSalePrice'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">'.$salDetails[$i]['salePrice'].'</span></td>';
										echo '<td><span id="spaAvaQuantity'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">'.$avaQuantity.'</span></td>';
										if($salDetails[$i]['backorder'] > 0){
											echo '<td><span id="spaBOQuantity'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'" style="color:red">'.$salDetails[$i]['backorder'].'</span></td>';
										}else{
											echo '<td><span id="spaBOQuantity'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">'.$salDetails[$i]['backorder'].'</span></td>';
										}
										echo '<td><span id="spaQuantity'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">'.$salDetails[$i]['cantidad'].'</span></td>';
										echo '<td><span id="spaSubtotal'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">'.number_format($subtotal, 2, '.', '').'</span></td>';
										echo '<td><span id="spaWarehouse'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">'.$salDetails[$i]['warehouse'].'</span><input  value="'.$salDetails[$i]['warehouseId'].'" id="txtWarehouseId'.$salDetails[$i]['itemId'].'" ></td>';
										if($virtualStock > 0){
											echo '<td><span id="spaVirtualStock'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'" >'.$virtualStock.'</span></td>';
										}else{
											echo '<td><span id="spaVirtualStock'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'" style="color:red">'.$virtualStock.'</span></td>';
										}											
										echo '<td><span id="spaStock'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'">'.$salDetails[$i]['stock'].'</span></td>';
										
										if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR $reserved === false)/* AND current($invoiceState) == 'DRAFT'*/){
											echo '<td class="columnItemsButtons">';
											echo '<a class="btn btn-primary" href="#" id="btnEditItem'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'" title="Editar"><i class="icon-pencil icon-white"></i></a>
												<a class="btn btn-info" href="#" id="btnDistribItem'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'" title="Distribuir"><i class="icon-resize-full icon-white"></i></a>
												<a class="btn btn-danger" href="#" id="btnDeleteItem'.$salDetails[$i]['itemId'].'w'.$salDetails[$i]['warehouseId'].'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
											echo '</td>';
										}
									echo '</tr>';	
									$total += $subtotal;
								}?>
							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<?php if($discount > 0){ ?>
										<td colspan="3"><h6 id="totalLabel">Monto sin </br> descuento:</h6></td>
									<?php }else{ ?>
										<td colspan="3"><h4 id="totalLabel">Total:</h4></td>
									<?php }?>
									<td><h4 id="total" ><?php echo number_format($total, 2, '.', '').' Bs.'; ?></h4></td>
									<td></td>
									<td></td>
									<td></td>
									<?php if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR $reserved === false)/* AND current($invoiceState) == 'DRAFT'*/){ ?>
										<td class="columnItemsButtons"></td>
									<?php }?>
								</tr>
								<?php if($discount > 0){ 
										$discountedAmount = ($discount * $total) / 100;
										$totalDiscounted = $total - $discountedAmount?>
									<tr id="discountTr" >
										<td></td>
										<td></td>
										<td colspan="3"><h4>Descuento:</h4></td>
										<td><h4 id="discAmnt" ><?php echo number_format($discountedAmount, 2, '.', '').' Bs.'; ?></h4></td>
										<td></td>
										<td></td>
										<td></td>
										<?php if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR $reserved === false)/* AND current($invoiceState) == 'DRAFT'*/){ ?>
											<td class="columnItemsButtons"></td>
										<?php }?>
									</tr>
									<tr id="totalTr" >
										<td></td>
										<td></td>
										<td colspan="3"><h4>Total:</h4></td>
										<td><h4 id="totalDisc" ><?php echo number_format($totalDiscounted, 2, '.', '').' Bs.'; ?></h4></td>
										<td></td>
										<td></td>
										<td></td>
										<?php if(($documentState == 'NOTE_PENDANT' OR $documentState == '') AND ($reserved === '' OR $reserved === false)/* AND current($invoiceState) == 'DRAFT'*/){ ?>
											<td class="columnItemsButtons"></td>
										<?php }?>
									</tr>	
								<?php }?>	
							</tfoot>	
						</table>
					
				<!-- ////////////////////////////////// END - NOTE ITEMS DETAILS /////////////////////////////////////// -->		
			</div>
			<div id="tab2" class="tab-pane">
				<!-- ////////////////////////////////// START - NOTE PAY DETAILS /////////////////////////////////////// -->
				
					<a class="btn btn-primary" href='#' id="btnAddPay" title="Adicionar Pago" style="display:<?php echo $displayPays;?>"><i class="icon-plus icon-white"></i></a>
				
						<?php $limit2 = count($salPayments); $counter2 = $limit2;?>
						<table class="table table-bordered table-hover data-table" id="tablaPays">
							<thead>
								<tr>
									<th>Fecha Pago</th>
									<th>Monto</th>
									<th>Descripcion</th>
									<?php if($documentState == 'NOTE_PENDANT' OR $documentState == ''){ ?>
									<th class="columnPaysButtons"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php
								$total2 = '0.00';
								for($i=0; $i<$limit2; $i++){
									echo '<tr id="payRow'.$salPayments[$i]['dateId'].'" >';
										echo '<td><span id="spaPayDate'.$salPayments[$i]['dateId'].'">'.$salPayments[$i]['payDate'].'</span><input type="hidden" value="'.$salPayments[$i]['dateId'].'" id="txtPayDate" ></td>';
										echo '<td><span id="spaPayAmount'.$salPayments[$i]['dateId'].'">'.$salPayments[$i]['payAmount'].'</span></td>';
										echo '<td><span id="spaPayDescription'.$salPayments[$i]['dateId'].'">'.$salPayments[$i]['payDescription'].'</span></td>';
										
										if($documentState == 'NOTE_PENDANT' OR $documentState == ''){
											echo '<td class="columnPaysButtons">';
											echo '<a class="btn btn-primary" href="#" id="btnEditPay'.$salPayments[$i]['dateId'].'" title="Editar"><i class="icon-pencil icon-white"></i></a>
												
												<a class="btn btn-danger" href="#" id="btnDeletePay'.$salPayments[$i]['dateId'].'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
											echo '</td>';
										}
									echo '</tr>';	
									$total2 += $salPayments[$i]['payAmount'];
								}?>
							</tbody>
							<tfoot>
								<tr>
									
									<td><h4>Total:</h4></td>
									<td><h4 id="total2" ><?php echo number_format($total2, 2, '.', '').' Bs.'; ?></h4></td>
									<td></td>
									<?php if($documentState == 'NOTE_PENDANT' OR $documentState == '') { ?>
										<td></td>
									<?php }?>
								</tr>	
							</tfoot>
						</table>
					
				<!-- ////////////////////////////////// END NOTE PAY DETAILS /////////////////////////////////////// -->
			</div>
			<div id="tab3" class="tab-pane">
				<!-- ////////////////////////////////// START - NOTE DETAILS /////////////////////////////////////// -->
				<!-- ////////////////////////////////// START - FORM STARTS ///////////////////////////////////// -->
				<?php // echo $this->BootstrapForm->create('SalInvoice', array('class' => 'form-horizontal'));  //  SalInvoice?????????????????????????????????????????????????????? ?>
				<fieldset>
				<!-- ////////////////////////////////// END - FORM ENDS /////////////////////////////////////// -->	
				<?php
					echo $this->BootstrapForm->input('invoice_number', array(
						'id'=>'tabInvoiceNumber',
						'label' => 'No. de Factura:',
						'value'=>$invoiceName
//						'disabled'=>$disable
					));
					
//					echo $this->BootstrapForm->input('invoice_date', array(
//						'required' => 'required',
//						'label' => 'Fecha:',
//						'id'=>'tabDate',
//						'value'=>$date,
//						'maxlength'=>'0',
//						'class'=>'input-date-type'
//					));	
//					
//					echo $this->BootstrapForm->input('invoice_name', array(
//						'id'=>'tabName',
//						'label' => 'Razón Social:'
//					));
//					
//					echo $this->BootstrapForm->input('invoice_nit', array(
//						'id'=>'tabNit',
//						'label' => 'NIT/CI:'
//					));
//					
//					echo $this->BootstrapForm->input('invoice_total', array(				
//						'label' => 'Total:',
//						'id'=>'tabTotal',
//						'class'=>'span3',
//						'maxlength'=>'15'
//					));
					
					echo $this->BootstrapForm->input('invoice_description', array(				
						'label' => 'Observaciones:',
						'id'=>'tabDescription',
						'class'=>'span9',
						'rows' => 2,
						'value'=>$invoiceDescription
					));
					
					?>
					<!-- ////////////////////////////////// START - END FORM ///////////////////////////////////// -->		
					</fieldset>
					<?php // echo $this->BootstrapForm->end();?>
					<!-- ////////////////////////////////// END - END FORM ///////////////////////////////////// -->
				<!-- ////////////////////////////////// END NOTE DETAILS /////////////////////////////////////// -->
			</div>
		</div>                            
	</div>
								
	<!-- ////////////////////////////////// END NOTE ITEMS DETAILS /////////////////////////////////////// -->
	
<!-- ************************************************************************************************************************ -->
</div><!-- END CONTAINER FLUID/ROW FLUID/SPAN12 - MAIN Template #UNICORN -->
<!-- ************************************************************************************************************************ -->

<!-- ////////////////////////////////// START MODAL ADD ITEM (Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->
			<div id="modalAddItem" class="modal hide fade ">
				  
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 id="myModalLabel">Cantidad Item</h3>
				  </div>
				  
				  <div class="modal-body">
					<!--<p>One fine body…</p>-->
					<?php
					echo '<div id="boxModalInitiateIWPS">';
						//////////////////////////////////////
						echo $this->BootstrapForm->input('items_id', array(				
						'label' => 'Item:',
						'id'=>'cbxModalItems',
						'class'=>'span12'
						));	
						echo '<br>';
						echo '<br>';
						echo '<div id="boxModalWarehousePriceStock">';
							//////////////////////////////////////
							echo $this->BootstrapForm->input('inv_warehouse_id', array(				
							'label' => 'Almacén:',
							'id'=>'cbxModalWarehouses',
							'class'=>'span6'
							));
							echo '<br>';
							echo '<br>';
							echo '<div id="boxModalPriceStock">';
//							echo '<div id="boxModalPrice">';
								$price='';
								echo $this->BootstrapForm->input('sale_price', array(				
								'label' => 'Precio Unitario:',
								'id'=>'txtModalPrice',
								'value'=>$price,
								'class'=>'span3',
								'maxlength'=>'15'
								,'append' => 'Bs.'	
								));
//							echo '</div>';	
								echo '<div id="boxModalStocks">';		
									echo '<div id="boxModalStock">';
									$stock='';
									echo $this->BootstrapForm->input('stock', array(				
									'label' => 'Stock:',
									'id'=>'txtModalStock',
									'value'=>$stock,
									'disabled'=>'disabled',
									'style'=>'background-color:#EEEEEE',
									'class'=>'span3',
									'maxlength'=>'15'
									,'append' => 'u.'	
									));
									echo '</div>';

									echo '<div id="boxModalStockTotal">';
									$stockTotal='';
									echo $this->BootstrapForm->input('stockTotal', array(				
									'label' => 'Stock Total:',
									'id'=>'txtModalStockTotal',
									'value'=>$stockTotal,
									'disabled'=>'disabled',
									'style'=>'background-color:#EEEEEE',
									'class'=>'span3',
									'maxlength'=>'15'
									,'append' => 'u.'	
									));
									echo '</div>';
									
									echo $this->BootstrapForm->input('stockReal', array(	
								'value'=>$stockReal,	
								'id'=>'txtModalStockReal'
						//		,'type'=>'hidden'
								));
									
								echo '</div>';
								
								
								
							echo '</div>';	
							//////////////////////////////////////
						echo '</div>';
						//////////////////////////////////////
					echo '</div>';

					echo $this->BootstrapForm->input('quantity', array(				
					'label' => 'Cantidad:',
					'id'=>'txtModalQuantity',
					'class'=>'span3',
					'maxlength'=>'10'
					,'append' => 'u.'	
					));
					
					echo '<div id="boxModalBOQuantity" style="display:none">';
						echo $this->BootstrapForm->input('backorder', array(				
						'label' => 'Backorder:',
						'id'=>'txtModalBOQuantity',
//						'value'=>0,
						'class'=>'span3',
						'maxlength'=>'10'
						,'append' => 'u.'	
						));
						
						echo $this->BootstrapForm->input('last_backorder', array(			
						'id'=>'txtModalLastBOQuantity'
				//		,'type'=>'hidden'
						));
					echo '</div>';	
					?>
					  <div id="boxModalValidateItem" class="alert-error"></div> 
				  </div>
				  
				  <div class="modal-footer">
					<a href='#' class="btn btn-primary" id="btnModalAddItem">Guardar</a>
					<a href='#' class="btn btn-primary" id="btnModalEditItem">Guardar</a>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
					
				  </div>
					
			</div>
<!-- ////////////////////////////////// FIN MODAL ADD ITEM(Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->

<!-- ////////////////////////////////// START MODAL DISTRIB ITEM(Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->
			<div id="modalDistribItem" class="modal hide fade ">
				  
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 id="myModalLabel">Reparto de Item</h3>
				  </div>
				  
				   <div class="modal-body">
					<!--<p>One fine body…</p>-->
					<?php
					echo '<div id="boxModalInitiateIWS">';
						//////////////////////////////////////
						echo $this->BootstrapForm->input('items_id', array(				
						'label' => 'Item:',
						'id'=>'cbxModalItemsDistrib',
						'class'=>'span12'
						));	
						echo '<br>';
						echo '<br>';
						echo '<div id="boxModalWarehouseStock">';
							//////////////////////////////////////
							echo $this->BootstrapForm->input('inv_warehouse_id', array(				
							'label' => 'Almacén destino:',
							'id'=>'cbxModalWarehousesDistrib',
							'class'=>'span6'
							));
							echo '<br>';
							echo '<br>';

							echo '<div id="boxModalStock">';
							$stock='';
							echo $this->BootstrapForm->input('stock', array(				
							'label' => 'Stock:',
//							'id'=>'txtModalStockDistrib',
								'id'=>'txtModalStockDestDistrib',
							'value'=>$stock,
							'disabled'=>'disabled',
							'style'=>'background-color:#EEEEEE',
							'class'=>'span3',
							'maxlength'=>'15'
							,'append' => 'u.'	
							));
							echo '</div>';
							//////////////////////////////////////
						echo '</div>';
						//////////////////////////////////////
					echo '</div>';

					echo $this->BootstrapForm->input('quantity', array(				
					'label' => 'Cantidad:',
					'id'=>'txtModalQuantityDistrib',
						'disabled'=>'disabled',
							'style'=>'background-color:#EEEEEE',
					'class'=>'span3',
					'maxlength'=>'10'
					,'append' => 'u.'	
					));
					
					echo $this->BootstrapForm->input('quantity_to_pass', array(				
					'label' => 'Cantidad a pasar:',
					'id'=>'txtModalQuantityToDistrib',
					'class'=>'span3',
					'maxlength'=>'10'
					,'append' => 'u.'	
					));
					
					echo $this->BootstrapForm->input('warehouse_hidden', array(	
							'label' => 'Warehouse Almacen Origen:',
//							'id'=>'txtModalOriginWarehousesDistrib',
							'id'=>'txtModalWarehousesOrigDistrib',
//							'type'=>'hidden'
							));
					
					echo $this->BootstrapForm->input('sale_price_hidden', array(				
							'id'=>'txtModalPriceDistrib',
//							'type'=>'hidden'
							));
					
					echo $this->BootstrapForm->input('stock_hidden', array(
							'label' => 'Stock de Almacen Origen:',
//							'id'=>'txtModalOriginStockDistrib',
							'id'=>'txtModalStockOrigDistrib',
//							'type'=>'hidden'
							));
					
//					echo $this->BootstrapForm->input('stockVirtualOrigen', array(		
//			'label' => 'Stock Virtual de almacén origen:',
//		'id'=>'txtModalOriginStockVirtualDistrib'
//		,'value'=>$stock3
////		,'type'=>'hidden'
//		));
					
					echo $this->BootstrapForm->input('realStockOrigen', array(		
			'label' => 'Stock Real de almacén origen:',
//		'id'=>'txtModalOriginStockRealDistrib'
						'id'=>'txtModalRealStockOrigDistrib'
//		,'value'=>$stock2
//		,'type'=>'hidden'
		));
					
					echo $this->BootstrapForm->input('last_backorder_origin', array(			
//						'id'=>'txtModalOriginLastBOQuantityDistrib'
						'id'=>'txtModalLastBOQuantityOrigDistrib'
				//		,'type'=>'hidden'
						));
					
//					echo $this->BootstrapForm->input('stockVirtualDestino', array(		
//			'label' => 'Stock Virtual de almacén destino:',
//		'id'=>'txtModalStockVirtual'
//		,'value'=>$stock2
////		,'type'=>'hidden'
//		));
//		
//		echo $this->BootstrapForm->input('stockRealDestino', array(	
//			'label' => 'Stock Real de almacén destino:',
//		'id'=>'txtModalStockReal'
//		,'value'=>$stockReal
////		,'type'=>'hidden'
//		));
					?>
					  <div id="boxModalValidateItemDistrib" class="alert-error"></div> 
				  </div>
				  
				  <div class="modal-footer">
<!--					<a href='#' class="btn btn-primary" id="btnModalAddItem">Guardar</a>
					<a href='#' class="btn btn-primary" id="btnModalEditItem">Guardar</a>-->
					<a href='#' class="btn btn-primary" id="btnModalDistribItem">Guardar</a>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
					
				  </div>
					
			</div>
<!-- ////////////////////////////////// FIN MODAL DISTRIB ITEM(Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->

<!-- ////////////////////////////////// INICIO MODAL PAYS(Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->
			<div id="modalAddPay" class="modal hide fade ">
				  
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 id="myModalLabel">Pagos</h3>
				  </div>
				  
				  <div class="modal-body">
					<!-- class="control-group"--> 
					<?php
					echo '<div id="boxModalInitiatePay">';
						$datePay = '';
						echo $this->BootstrapForm->input('date', array(	
								'label' => 'Fecha:',
								'id'=>'txtModalDate',
								'value'=>$datePay,
								'class'=>'span3',
								'maxlength'=>'15'
								));
//					
						$payDebt = '';
						echo $this->BootstrapForm->input('amount', array(				
								'label' => 'Monto a Pagar:',
								'id'=>'txtModalPaidAmount',
								'value'=>$payDebt,
								'class'=>'span3',
								'maxlength'=>'15'
								));
						
						echo $this->BootstrapForm->input('debt', array(	
		'value'=>$payDebt,
		'id'=>'txtModalDebtAmount'
//		,'type'=>'hidden'
		));
					echo '</div>';
					
					echo $this->BootstrapForm->input('description', array(				
							'label' => 'Descripcion:',
							'id'=>'txtModalDescription',
							'class'=>'span9',
							'rows' => 2
							));
					
					echo $this->BootstrapForm->input('amount_hidden', array(				
							'id'=>'txtModalAmountHidden',
//							'type'=>'hidden'
							));
					
					

					?>
					  <div id="boxModalValidatePay" class="alert-error"></div> 
				  </div>
				  
				  <div class="modal-footer">
					 <!-- Ztep 0 Save button from modal triggers btnModalAddItem -->
					<a href='#' class="btn btn-primary" id="btnModalAddPay">Guardar</a>
					<a href='#' class="btn btn-primary" id="btnModalEditPay">Guardar</a>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
					
				  </div>
					
			</div>
<!-- ////////////////////////////////// FIN MODAL PAYS (Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->